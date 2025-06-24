<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function index()
    {
        // Fetch delivery details from the database
        $deliveries = DB::table('delivery_details')->get();

        // Return the view with the fetched data
        return view('deliveries.index', compact('deliveries'));
    
    }
    
}
