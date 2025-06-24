<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('login');
    }

    // Handle login submission
    public function login(Request $request)
    {
        // Validate the login form inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Check if the user exists in the database
        $user = DB::table('page')->where('email', $request->email)->first();

        if ($user && $user->password == $request->password) {
            // Store the username in session
            Session::put('username', $user->username);

            // Redirect based on whether the user is blocked or not
            if ($user->is_blocked) {
                return redirect()->route('login')->with('error', 'Your account is blocked.');
            }

            // Redirect to user dashboard
            return redirect()->route('user.dashboard');
        } else {
            // Invalid credentials
            return redirect()->route('login')->with('error', 'Invalid email or password.');
        }
    }
}
