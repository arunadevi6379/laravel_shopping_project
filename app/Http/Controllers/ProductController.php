<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import DB facade for direct queries
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index()
    {
        // Fetch paginated products using the DB facade
        $products = DB::table('products')->paginate(10); // 10 products per page

        // Return the view with the products data and pagination links
        return view('manage_products', compact('products'));
    }
    public function show(Request $request)
    {
        // Fetch the 'name' parameter from the query string
        $productName = $request->query('name');

        // Fetch the product from the database using the name
        $product = DB::table('products')->where('name', $productName)->first();

        // Check if the product exists
        if ($product) {
            return view('product_details', compact('product'));  // Return the product details view
        } else {
            return redirect()->route('products.index')->with('error', 'Product not found.');
        }
    }

    public function updateView($id)
    {
        // Fetch the product by ID using DB facade
        $product = DB::table('products')->where('id', $id)->first();

        // If the product doesn't exist, redirect or show a 404 page
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }

        // Fetch all categories using DB facade
        $categories = DB::table('products')->select('category')->distinct()->get();

        // Return the update view with the product data and categories
        return view('update_product', compact('product', 'categories'));
    }

    // Show the Add Product form
    public function showAddProductForm()
    {
        // Fetch distinct categories from the products table
        $categories = DB::table('products')->select('category')->distinct()->get();
        return view('addproduct', compact('categories'));
    }
 // Display the product edit form
 public function showEditForm($id)
 {
     // Fetch product details based on the ID
     $product = DB::table('products')->where('id', $id)->first();

     // Fetch available categories
     $categories = DB::table('products')->select('category')->distinct()->get();

     // If product does not exist, return an error
     if (!$product) {
         abort(404, 'Product not found.');
     }

     // Return the edit form with the product and categories
     return view('product.edit', compact('product', 'categories'));
 }

 // Update the product in the database
 public function updateProduct(Request $request, $id)
 {
     // Validate incoming request data
     $validated = $request->validate([
         'name' => 'required|string|max:255',
         'image' => 'required|string|max:255',
         'price' => 'required|numeric',
         'quantity' => 'required|numeric',
         'description' => 'required|string|max:255',
         'category' => 'required|string',
     ]);

     // Update the product in the database
     DB::table('products')->where('id', $id)->update($validated);

     // Redirect to the product listing page with a success message
     return redirect()->route('products.index')->with('success', 'Product updated successfully!');
 }


    // Handle Excel Import
    public function importExcel(Request $request)
    {
        // Validate the file
        $request->validate([
            'excel_file' => 'required|mimes:xls,xlsx'
        ]);

        // Import the Excel file
        Excel::import(new ProductsImport, $request->file('excel_file'));

        // Redirect back with success message
        return redirect()->route('add.product')->with('alert', 'Products imported successfully!');
    }
    // Handle product deletion
    public function delete($id)
    {
        // Find the product by ID
        $product = DB::table('products')->where('id', $id)->first();

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found');
        }

        // Delete the product
        DB::table('products')->where('id', $id)->delete();

        return redirect()->route('products.index')->with('alert', 'Product deleted successfully!');
    }
    public function create()
    {
        // Fetch categories from the products table
        $categories = DB::table('products')->select('category')->distinct()->get();
        
        return view('addproduct', compact('categories'));
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'photos' => 'required|array',
        'photos.*' => 'image',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'quantity' => 'required|numeric',
        'description' => 'required|string|max:100',
        'category' => 'required|string',
    ]);

    // Store image file names
    $imageNames = [];
    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $photo) {
            // Get the image name and store it in the public/images folder
            $imageName = $photo->getClientOriginalName();
            $photo->move(public_path('images'), $imageName); // Move to public/images directory

            // Store only the image name (no path)
            $imageNames[] = $imageName;
        }
    }

    // Convert the array of image names to a comma-separated string
    $imageNamesString = implode(',', $imageNames);

    // Insert product into the database
    DB::table('products')->insert([
        'name' => $validated['name'],
        'price' => $validated['price'],
        'quantity' => $validated['quantity'],
        'description' => $validated['description'],
        'category' => $validated['category'],
        'image' => $imageNamesString, // Store the comma-separated image names
    ]);

    return redirect()->route('add.product')->with('alert', 'Product added successfully!');
}
 // Show the update product form (empty form initially)
 public function showUpdateForm()
 {
     return view('update-product'); // Display the update form
 }

 // Fetch the product and show details to be updated
 public function fetchProduct(Request $request)
 {
     $id = $request->input('id');
     $product = DB::table('products')->where('id', $id)->first();

     if (!$product) {
         return back()->with('error', 'Product not found');
     }

     // Pass the product data to the form view
     return view('update-product', compact('product'));
 }

 // Update the product details
 public function update(Request $request, $id)
 {
     // Validate the incoming request
     $validated = $request->validate([
         'name' => 'required|string|max:255',
         'quantity' => 'required|integer',
     ]);

     // Update the product in the database
     $affected = DB::table('products')
                 ->where('id', $id)
                 ->update([
                     'name' => $request->name,
                     'quantity' => $request->quantity,
                 ]);

     // Check if update was successful
     if ($affected) {
         return redirect()->route('product.update.form')->with('success', 'Product updated successfully!');
     }

     return redirect()->back()->with('error', 'Failed to update product.');
}
}
