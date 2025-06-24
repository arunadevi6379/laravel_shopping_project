<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PaymentController extends Controller
{
    // Show the payment page with session data
    public function showPaymentPage(Request $request)
    {
        // Retrieve session data
        $total_amount = $request->query('total_amount', 0);
        $username = Session::get('username', 'Guest'); // Default to 'Guest' if not logged in

        // Fetch user's address and phone number from the database
        $user_data = DB::table('page')
            ->where('username', $username)
            ->first(['address', 'phone']);

        $address = $user_data ? $user_data->address : '';
        $phone = $user_data ? $user_data->phone : '';

        // Fetch the cart count for the logged-in user
        $cartCount = DB::table('cart')
            ->where('username', $username)
            ->sum('quantity'); // Summing up quantities from the cart

        // Return the payment view with data
        return view('payment', compact('total_amount', 'username', 'address', 'phone', 'cartCount'));
    }

    // Process the payment
    public function processPayment(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'total_amount' => 'required|numeric',
            'username' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'payment_method' => 'required|string',
            'account_number' => 'nullable|string|max:16',
            'cvv' => 'nullable|string|max:3',
            'expiry_date' => 'nullable|date',
        ]);

        $totalAmount = $validated['total_amount'];
        $username = $validated['username'];
        $address = $validated['address'];
        $phone = $validated['phone'];
        $paymentMethod = $validated['payment_method'];

        // Handle bank transfer payment method if selected
        if ($paymentMethod === 'bank') {
            $account_number = $validated['account_number'];
            $cvv = $validated['cvv'];
            $expiry_date = $validated['expiry_date'];
            $paymentMethod = "Bank Account: $account_number, CVV: $cvv, Expiry Date: $expiry_date";
        }

        // Insert the order into the database
        DB::beginTransaction();
        try {
            // Insert order details into the order_list table
            $orderId = DB::table('order_list')->insertGetId([
                'username' => $username,
                'total_amount' => $totalAmount,
                'address' => $address,
                'phone' => $phone,
                'payment_method' => $paymentMethod,
            ]);

            // Fetch cart items for the user
            $cartItems = DB::table('cart')
                ->join('products', 'cart.product_id', '=', 'products.id')
                ->where('cart.username', $username)
                ->select('cart.product_id', 'cart.quantity', 'products.name', 'products.price')
                ->get();

            // Insert cart items into the order_product table
            foreach ($cartItems as $item) {
                DB::table('order_product')->insert([
                    'product_name' => $item->name,
                    'quantity' => $item->quantity,
                    'rate' => $item->price,
                    'total_price' => $item->price * $item->quantity,
                    'order_id' => null,  // Initially setting order_id to null
                ]);
            }

            // Get the current value of 'ordered_products' from the page table
            $existingOrderedProducts = DB::table('page')->where('username', $username)->value('ordered_products');
            
            // Prepare the new ordered products string
            $orderedProductsString = '';
            foreach ($cartItems as $item) {
                $orderedProductsString .= $item->name . ' x ' . $item->quantity . ', ';
            }
            $orderedProductsString = rtrim($orderedProductsString, ', ');
            $orderedProductsString .= ', Order Timestamp: ' . Carbon::now()->toDateTimeString();

            // If there is already existing data in the 'ordered_products' column, append new order to it
            if ($existingOrderedProducts) {
                $orderedProductsString = $existingOrderedProducts . ' | ' . $orderedProductsString;
            }

            // Update the 'page' table with the appended ordered products string
            DB::table('page')
                ->where('username', $username)
                ->update(['ordered_products' => $orderedProductsString]);

            // Update the order_id in the order_product table
            DB::table('order_product')
                ->where('order_id', null)
                ->update(['order_id' => $orderId]);

            // Delete cart items after successful payment
            DB::table('cart')->where('username', $username)->delete();

            // Commit transaction
            DB::commit();

            // Clear session data
            Session::forget('total_amount');
            Session::forget('cart_items');

            // Redirect to the success page with order ID
            return redirect()->route('order.success', ['order_id' => $orderId]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'An error occurred while processing your payment']);
        }
    }

    // Success page for the order
    public function orderSuccess(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = DB::table('order_list')->where('order_id', $orderId)->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found!');
        }
        return view('order.success', ['order' => $order]);
}
}
