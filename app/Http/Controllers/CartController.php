<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // Show cart items
    public function showCart()
    {
        $username = Session::get('username');  // Get logged-in username from session
        if (!$username) {
            return redirect()->route('login')->with('error', 'Please log in to view your cart.');
        }

        // Retrieve cart items for the logged-in user
        $cartItems = DB::table('cart')
            ->join('products', 'cart.product_id', '=', 'products.id')
            ->where('cart.username', $username)
            ->select('cart.*', 'products.name', 'products.price', 'products.description', 'products.image')
            ->get();

        // Calculate the total amount for the cart
        $total_amount = 0;
        foreach ($cartItems as $item) {
            $total_amount += $item->price * $item->quantity;
        }

        return view('cart', compact('cartItems', 'total_amount'));
    }
      // Remove item from the cart
      public function removeFromCart($productId)
      {
          $username = Session::get('username');
          if (!$username) {
              return redirect()->route('cart.show')->with('error', 'No user logged in.');
          }
  
          // Remove the product from the cart
          DB::table('cart')->where('product_id', $productId)->where('username', $username)->delete();
  
          return redirect()->route('cart.show')->with('success', 'Item removed from cart.');
      }
  
      // Update the quantity of a product in the cart
      public function updateQuantity(Request $request, $productId)
      {
          $username = Session::get('username');
          if (!$username) {
              return redirect()->route('cart.show')->with('error', 'No user logged in.');
          }
  
          // Ensure that the 'quantity' value is a valid number
          $quantity = $request->input('quantity');
          if (!is_numeric($quantity) || $quantity <= 0) {
              return response()->json(['success' => false, 'message' => 'Invalid quantity.']);
          }
  
          // Update the quantity in the cart
          DB::table('cart')
              ->where('product_id', $productId)
              ->where('username', $username)
              ->update(['quantity' => $quantity]);
  
          return redirect()->route('cart.show')->with('success', 'Cart quantity updated successfully!');
      }
  
  

    // Proceed to checkout
    public function checkout(Request $request)
    {
        $username = Session::get('username');
        if (!$username) {
            return redirect()->route('login')->with('error', 'Please log in to proceed with checkout.');
        }

        // Retrieve cart items for the logged-in user
        $cartItems = DB::table('cart')
            ->join('products', 'cart.product_id', '=', 'products.id')
            ->where('cart.username', $username)
            ->select('cart.*', 'products.name', 'products.price', 'products.description', 'products.image')
            ->get();

        // Calculate the total amount for the cart
        $total_amount = 0;
        foreach ($cartItems as $item) {
            $total_amount += $item->price * $item->quantity;

            // Insert into order_product table (order_id will be null initially)
            DB::table('order_product')->insert([
                'product_name' => $item->name,
                'quantity' => $item->quantity,
                'rate' => $item->price,
                'total_price' => $item->price * $item->quantity,
                'order_id' => null, // order_id is null initially
            ]);
        }

        // Save total_amount and cart items to session
        Session::put('total_amount', $total_amount);
        Session::put('cart_items', $cartItems);

        return redirect()->route('payment.page');  // Redirect to payment page
}
}
