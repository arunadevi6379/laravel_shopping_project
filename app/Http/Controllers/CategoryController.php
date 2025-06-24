<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CategoryController extends Controller
{
    public function create()
    {
        // Show the category creation form
        return view('category.create');
    }

    public function store(Request $request)
    {
        // Validate the category name
        $request->validate([
            'category_name' => 'required|string|max:255'
        ]);

        // Get the submitted category name
        $category_name = $request->input('category_name');

        // Check if the category already exists
        $check_query = DB::table('products')->where('category', $category_name)->first();

        if ($check_query) {
            return redirect()->back()->with('error', 'Category already exists.');
        } else {
            // Insert the new category into the products table
            DB::table('products')->insert(['category' => $category_name]);

            // Redirect back with a success message
            return redirect()->route('category.create')->with('success', 'New category added successfully.');
        }
    }
    public function showCategory($category)
    {
        // Decode the category name (to handle + symbol and other encoded characters)
        $decodedCategory = urldecode($category); 

        // Fetch the products for the decoded category from the database
        $products = DB::table('products') // Use DB facade to query products table
            ->where('category', $decodedCategory)
            ->get();

        // Return the view with the products and category name
        return view('category.show', compact('products', 'decodedCategory')); // Pass decodedCategory to the view
        }
}
