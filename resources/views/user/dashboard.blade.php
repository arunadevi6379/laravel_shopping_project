<?php
session_start(); // Start session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Toy Treasure</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            background: linear-gradient(to right, violet, pink, violet);
            z-index: 1000;
            position: fixed; /* Fix navbar to the top */
            width: 100%; /* Make navbar full width */
            top: 0; /* Align to top */
            left: 0; /* Align to left */
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: white;
        }
        .nav-links {
            list-style: none;
            padding: 0;
            display: flex;
            align-items: center;
        }
        .content {
            margin-top: 80px; /* Adjust margin to prevent overlap with fixed navbar */
        }
        .navbar-text {
            margin-right: 100px;
            color: white;
            font-size: 16px;
        }
        .nav-links li {
            position: relative;
            margin-right: 15px;
        }
        .nav-links a {
            text-decoration: none;
            color: black;
            font-size: 14px;
            padding: 8px 12px;
        }
        .search-container {
            display: flex;
            align-items: center;
        }
        .search-input {
            padding: 5px;
            width: 180px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 5px;
        }
        .background {
            background-image: url('{{ asset('toy.jpg') }}');
            height: 100vh;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column; /* Center children vertically */
        }
        .transparent-container {
            background-color: rgba(0, 0, 0, 0.5); /* Higher transparency */
            padding: 20px; /* Adjusted padding for better spacing */
            border-radius: 10px;
            display: flex;
            flex-direction: column; /* Center text vertically */
            align-items: center; /* Center text horizontally */
            max-width: 400px; /* Smaller max-width */
            width: 90%; /* Adjusted width */
            border: 1px solid rgba(0, 0, 0, 0.5); /* Light border for definition */
            margin-top: 20px; /* Space between heading and container */
            color: white;
            text-align: center; /* Center text alignment */
        }
        .contact-form, .contact-details {
            width: 45%; /* Width for each section */
            color: white; /* Changed to black for readability */
        }
        .contact-form h2 {
            color: white; /* Ensure heading is visible */
        }
        .btn-submit {
            background-color: green; /* Green submit button */
            color: white; /* White text */
        }
        .contact-details p {
            margin: 0;
        }
        .contact-details i {
            color: black;
        }
        .btn-primary {
            background-color: aquamarine;
            border-color: aquamarine;
        }
        .btn-secondary{
            background-color: blue;
            border-color: blue;
        }
        .btn-secondary:hover{
            background-color: blue;
        }
        i {
            font-size: 24px;
        }
        .session-username {
            font-weight: bold;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Toy Treasure</h1>
        <ul class="nav-links">
            <li><a href="http://127.0.0.1:8000/shopnow"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="http://127.0.0.1:8000/contact"><i class="fas fa-envelope"></i> Contact</a></li>
            <li><a href="http://127.0.0.1:8000/cart"><i class="fas fa-shopping-cart"></i> Cart</a></li>
            <li><a href="http://127.0.0.1:8000/orders"><i class="fas fa-box"></i> Ordered</a></li>
            <li><a href="http://127.0.0.1:8000/cancel-orders"><i class="fas fa-shopping-bag"></i> Cancelled</a></li>
            <li><a href="http://127.0.0.1:8000/login"><i class="fas fa-sign-out"></i> Log-out</a></li>
        </ul>
      
<span class="navbar-text">
    @if(Session::has('username'))
        Welcome, {{ Session::get('username') }}
    @else
        Welcome, Guest
    @endif
</span>

    </div>

    <div class="background">
        <div class="transparent-container">
            <h6>WELCOME TO OUR TOY TREASURE</h6>
            <p>Discover a world of fun and learning with our diverse range of toys</p>
            <button class="btn btn-secondary" onclick="window.location='{{ route('shopnow') }}'">SHOP NOW</button>
            </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
