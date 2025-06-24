<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;  // Add this line to import the DB facade

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login'); // Because file is at resources/views/admin/login.blade.php
 // Show the login form
    }

    public function login(Request $request)
    {
        // Hardcoded admin credentials (You can update this part to check against your DB or authentication logic)
        $credentials = [
            'email' => 'admin@gmail.com',  // Replace with actual email if needed
            'password' => 'admin'  // Replace with actual password if needed
        ];

        // Check if credentials match
        if ($request->email === $credentials['email'] && $request->password === $credentials['password']) {
            // Store session or use Laravel's built-in auth system
            Session::put('admin_logged_in', true);

            // Redirect to the admin dashboard page (admin_home blade)
            return redirect()->route('admin.dashboard');
        }

        // If login fails, return with error message
        return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
    }

    public function dashboard()
    {
        return view('admin_home');  // This is the page where admin lands after login
    }

    public function todaySales()
    {
        // Get today's date
        $date_today = date('Y-m-d');

        // Query to fetch today's sales data
        $sales_data = DB::table('order_product as op')
            ->join('products as p', 'op.product_name', '=', 'p.name')
            ->join('order_list as ol', 'op.order_id', '=', 'ol.order_id')
            ->whereDate('ol.order_date', $date_today)
            ->select('op.order_id', 'p.name as product_name', 'op.quantity', 'ol.order_date', DB::raw('p.price * op.quantity as total_price'))
            ->get();

        // Pass the sales data to the view
        return view('today_sales', compact('sales_data'));
    }
    public function totalSales()
    {
        // Query to fetch total sales data
        $sales_data = DB::table('order_product as op')
            ->join('products as p', 'op.product_name', '=', 'p.name')
            ->join('order_list as ol', 'op.order_id', '=', 'ol.order_id')
            ->select('ol.order_id', 'p.name as product_name', 'op.quantity', 'ol.order_date', DB::raw('p.price * op.quantity as total_price'))
            ->get();

        return view('total_sales', compact('sales_data'));  // Passing data to the Blade view
    }
    public function allCustomers()
    {
        // Fetching all customers using Eloquent
        $customers = DB::table('page')->select('username', 'email', 'phone')->get();

        return view('all_customers', compact('customers'));
    }
    public function totalProducts()
    {
        // Fetching the total quantity of each product
        $products_data = DB::table('products')
            ->select('name', DB::raw('SUM(quantity) as total_count'))
            ->groupBy('name')
            ->get();

        // Pass the data to the Blade view
        return view('total_products', compact('products_data'));
    }
    public function customerDetails(Request $request, $username)
    {
        // Fetch customer details from the 'page' table based on the provided username
        $customer = DB::table('page')->where('username', $username)->first();

        // If customer not found, return an error message
        if (!$customer) {
            return redirect()->route('admin.dashboard')->with('error', 'Customer not found.');
        }

        // Return the customer details to the view
        return view('customer_details', compact('customer'));
    }
 // Show the admin dashboard
 public function index()
 {
     return view('admin-dashboard');
}
}
