<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // Show the contact form
    public function showContactForm()
    {
        return view('contact'); // Ensure you have a 'contact.blade.php' file
    }

    // Handle the form submission and send email
    public function sendContactForm(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Send email directly from the controller
        Mail::send([], [], function ($message) use ($request) {
            $message->to('your-email@example.com')  // Your email address where you want to receive messages
                    ->subject('New Contact Form Submission')
                    ->from($request->email, $request->name)
                    ->setBody(
                        'Name: ' . $request->name . '<br>' . 
                        'Email: ' . $request->email . '<br>' . 
                        'Message: ' . nl2br(e($request->message)),
                        'text/html'
                    );
        });

        // Redirect back with a success message
        return back()->with('success', 'Your message has been sent successfully!');
}
}
