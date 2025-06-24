<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    // Show the signup form
    public function showSignupForm()
    {
        return view('signup');  // Assuming your HTML is now a Blade template
    }

    // Process the signup form
    public function processSignup(Request $request)
    {
        // Validate the form input
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:page,email',
            'phone' => 'required|numeric',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed', // Password confirmation validation
        ]);
    
        // Ensure password and confirm password are the same
        if ($request->password !== $request->password_confirmation) {
            return back()->withErrors(['password' => 'Passwords do not match.']);
        }
    
        // Insert data into the 'page' table with both password and confirm password
        DB::table('page')->insert([
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => $request->password,  // Store plain text password
            'confirmpassword' => $request->password_confirmation,  // Store plain text confirm password
        ]);
    
        // Redirect to another page after successful signup
        return redirect('/login');
    }
}
