<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class OrderController extends Controller
{
    // Show the orders page with session data
    public function showOrders()
    {
        $username = Session::get('username');

        if (!$username) {
            return redirect()->route('login')->with('error', 'You must be logged in to view your orders.');
        }

        // Fetch user's orders and order details
        $orders = DB::table('order_list as ol')
            ->join('order_product as op', 'ol.order_id', '=', 'op.order_id')
            ->join('products as p', 'op.product_name', '=', 'p.name')
            ->where('ol.username', $username)
            ->orderByDesc('ol.order_date')
            ->select(
                'ol.order_id',
                'ol.delivered_status',
                'ol.order_date',
                'ol.total_amount',
                'op.order_product_id',
                'op.product_name',
                'op.quantity',
                'op.rate',
                DB::raw('SUBSTRING_INDEX(p.image, ",", 1) as product_image')
            )
            ->get()
            ->groupBy('order_id');

        // Categorize orders by date
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $ordersCategorized = [
            'Today' => [],
            'Yesterday' => [],
            'Older' => []
        ];

        foreach ($orders as $orderId => $order) {
            $orderDate = date('Y-m-d', strtotime($order[0]->order_date));
            if ($orderDate === $today) {
                $ordersCategorized['Today'][] = $order;
            } elseif ($orderDate === $yesterday) {
                $ordersCategorized['Yesterday'][] = $order;
            } else {
                $ordersCategorized['Older'][] = $order;
            }
        }

        return view('orders.index', compact('ordersCategorized'));
    }

    // Handle product cancellation
    public function cancelProduct(Request $request)
    {
        $orderProductId = $request->input('order_product_id');
        $orderId = $request->input('order_id');
        $username = Session::get('username');
    
        // Get the product details (price and quantity) from order_product
        $product = DB::table('order_product')
            ->where('order_product_id', $orderProductId)
            ->first();
    
        if (!$product) {
            return redirect()->route('orders.show')->withErrors(['error' => 'Product not found.']);
        }
    
        // Insert the canceled product into canceled_orders table
        DB::table('canceled_orders')->insert([
            'canceled_order_id' => $orderId,
            'product_name' => $product->product_name,
            'username' => $username,
            'quantity' => $product->quantity,
            'created_at' => now()  // Using Carbon for system time
        ]);
    
        // Remove the product from the order_product table
        DB::table('order_product')
            ->where('order_product_id', $orderProductId)
            ->delete();
    
        // Update the total_amount in the order_list table by subtracting the product's total price
        $totalPrice = $product->quantity * $product->rate;
        DB::table('order_list')
            ->where('order_id', $orderId)
            ->decrement('total_amount', $totalPrice);
    
        // Get the current timestamp using Carbon (system time)
        $currentTimestamp = date('Y-m-d H:i:s');
    
        // Create the cancellation details string with the correct timestamp
        $cancellationDetails = "Product: $product->product_name, Quantity: $product->quantity, Price: ₹" . 
                           ($product->rate * $product->quantity) . 
                           " was canceled on " . $currentTimestamp;
    
        // Get the existing canceled_products string from the page table
        $existingCanceledProducts = DB::table('page')
            ->where('username', $username)
            ->value('canceled_products');
    
        // If there are existing canceled products, append the new one
        if ($existingCanceledProducts) {
            $canceledProductsString = $existingCanceledProducts . ' | ' . $cancellationDetails;
        } else {
            // If no existing canceled products, just set the new cancellation details
            $canceledProductsString = $cancellationDetails;
        }

        // Update the canceled_products column in the page table
        DB::table('page')
            ->where('username', $username)
            ->update(['canceled_products' => $canceledProductsString]);
    
        return redirect()->route('orders.show')->with('success_message', 'Product successfully canceled.');
    }
    public function showCanceledOrders()
    {
        // Ensure user is logged in
        $username = Session::get('username');
        if (!$username) {
            return redirect()->route('login')->with('error', 'You must be logged in to view canceled orders.');
        }

        // Fetch canceled orders for the specific user
        $canceled_orders = DB::table('canceled_orders as co')
            ->join('products as p', 'co.product_name', '=', 'p.name')
            ->where('co.username', $username)
            ->orderByDesc('co.created_at')
            ->select('co.*', 'p.name as product_name', DB::raw('SUBSTRING_INDEX(p.image, ",", 1) as product_image'))
            ->get();

        // Organize canceled orders by date
        $canceled_orders_by_date = [];
        foreach ($canceled_orders as $row) {
            $date_canceled = Carbon::parse($row->created_at)->toDateString();
            $canceled_orders_by_date[$date_canceled][] = $row;
        }

        // Get today's and yesterday's date
        $today = Carbon::today()->toDateString();
        $yesterday = Carbon::yesterday()->toDateString();

        return view('orders.canceled', compact('canceled_orders_by_date', 'today', 'yesterday'));
}

}
