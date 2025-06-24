<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderStatusController extends Controller
{
    // Display pending orders
    public function index()
    {
        // Fetch all orders with 'pending' delivery status
        $orders = DB::table('order_list')
            ->where('delivered_status', '')
            ->get();

        return view('order_status', compact('orders'));
    }

    // Confirm delivery and update the order status
    public function confirmDelivery(Request $request)
    {
        // Validate input
        $request->validate([
            'order_id' => 'required|integer',
            'courier_service' => 'required|string|in:E-commerce,Post Service,Courier Boy',
        ]);

        $order_id = $request->input('order_id');
        $courier_service = $request->input('courier_service');
        $delivered_on = now();  // Get current timestamp

        // Update order status and courier service in the database
        DB::table('order_list')
            ->where('order_id', $order_id)
            ->update([
                'delivered_status' => 'delivered',
                'delivered_on' => $delivered_on,
                'courier_service' => $courier_service
            ]);

        // Fetch order details for the inserted delivery record
        $order = DB::table('order_list')->where('order_id', $order_id)->first();

        if (!$order) {
            return redirect()->route('order-status')->with('error', 'Order not found.');
        }

        // Insert delivery details
        DB::table('delivery_details')->insert([
            'delivered_on' => $delivered_on,
            'username' => $order->username,
            'total_amount' => $order->total_amount,
            'courier_service' => $courier_service
        ]);

        // Return to order list with a success message
        return redirect()->route('order-status')->with('success', 'Delivery confirmed successfully!');
}
}
