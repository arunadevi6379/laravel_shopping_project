<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;  // For using the query builder

class PageController extends Controller
{
    // Method to show the list of users with optional search filter and pagination
    public function index(Request $request)
    {
        // Fetch search query from the request
        $search = $request->input('search', '');
        
        // Fetch pages from the database with pagination and search filter
        $pages = DB::table('page')
            ->where('username', 'like', '%' . $search . '%')
            ->paginate(5); // Pagination

        return view('manage_users', compact('pages'));
    }

    // Method to update the block/unblock status of a user
    public function blockUnblock(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'id' => 'required|integer|exists:page,id', // Ensure the ID exists in the database
            'is_blocked' => 'required|boolean',        // Ensure the status is either 0 or 1
        ]);

        // Update the block/unblock status based on user ID
        $page = DB::table('page')->where('id', $request->id)->first();

        if ($page) {
            DB::table('page')
                ->where('id', $request->id)
                ->update(['is_blocked' => $request->is_blocked]);

            return response()->json($request->is_blocked ? 'User blocked successfully.' : 'User unblocked successfully.');
        }

        return response()->json('User not found.', 404);
    }

    // Method to show user details
    public function show($id)
    {
        // Fetch user details from the database by ID
        $user = DB::table('page')->where('id', $id)->first();

        // Check if the user exists
        if ($user) {
            // Return the user details view with the user data
            return view('user_details', compact('user'));
        } else {
            // If user is not found, redirect to the users list with error
            return redirect()->route('admin.users')->with('error', 'User not found.');
}
}
}
