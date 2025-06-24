<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    // Show the shopnow page with all products, or filtered based on search query
    public function showShopNowPage(Request $request)
    {
        // Get the search query from the request
        $searchTerm = $request->input('search');

        // If there is a search term, filter products by the name or description
        if ($searchTerm) {
            // Fetch products based on the search term (you can modify this to match any other fields)
            $products = DB::table('products')
                ->where('name', 'like', '%' . $searchTerm . '%')  // Search by name
                ->orWhere('description', 'like', '%' . $searchTerm . '%')  // Or search by description
                ->get();
        } else {
            // If no search term, fetch all products
            $products = DB::table('products')->get();
        }

        // Check if 'username' is passed in the request (this might be from a login form or URL)
        if ($request->has('username')) {
            // Store the username in the session
            Session::put('username', $request->input('username'));
        }

        // Fetch number of items in the cart for the current user
        $cartCount = DB::table('cart')
            ->where('username', Session::get('username')) // Changed 'user_id' to 'username'
            ->sum('quantity');

        // Pass the products and session data to the view
        return view('shopnow', compact('products', 'cartCount'));
    }

    // Add item to cart
    public function addToCart(Request $request, $product_id)
    {
        // Get the user's ID (username stored in session)
        $username = Session::get('username');
        
        if (!$username) {
            // If username is not found in session, redirect with an error message
            return redirect()->route('shopnow')->with('error', 'Please log in to add items to your cart.');
        }

        // Check if the product exists in the database
        $product = DB::table('products')->where('id', $product_id)->first();
        
        if (!$product) {
            // If the product doesn't exist, return with an error message
            return redirect()->route('shopnow')->with('error', 'Product not found.');
        }

        // Check if the product is already in the cart, then update its quantity if it is
        $cartItem = DB::table('cart')->where('username', $username)->where('product_id', $product_id)->first();

        // Get the product's image URL (assuming the product has an 'image_url' field)
        $productImage = $product->image ?? 'default_image.jpg'; // Use a default image if no image is available

        if ($cartItem) {
            // If the product is already in the cart, update the quantity
            DB::table('cart')
                ->where('id', $cartItem->id)
                ->update(['quantity' => $cartItem->quantity + 1]); // Increment quantity
        } else {
            // Otherwise, insert a new record into the cart with the product image
            DB::table('cart')->insert([
                'username' => $username,  // Using the username as user ID
                'product_id' => $product_id,
                'quantity' => 1,  // Default quantity is 1
                'image' => $productImage, // Add the product image to the cart
            ]);
        }

        // Flash a success message
        return redirect()->route('shopnow')->with('success', 'Product added to your cart!');
}
}
