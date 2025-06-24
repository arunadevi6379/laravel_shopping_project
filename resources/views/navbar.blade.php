<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Toy Treasure</title>
    <style>
        body {
            background: #f8f9fa;
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
        .badge {
            position: absolute;
            top: -5px;
            right: -10px;
            font-size: 0.75rem;
        }
         .cart-icon {
            position: relative; /* To position the badge */
        }

.dropdown-menu {
    display: none; /* Hide by default */
    position: absolute;
    background: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    margin-top: 10px; /* Add some space below the menu */
}

.nav-links li:hover .dropdown-menu {
    display: block; /* Show on hover */
}

.dropdown-menu li {
    white-space: nowrap; /* Prevent line breaks */
}

.dropdown-menu a {
    display: block;
    padding: 8px 12px;
    color: black;
}

.dropdown-menu a:hover {
    background-color: #f1f1f1; /* Highlight on hover */
}
i{
            font-size: 24px;
        }
        .content {
            margin-top:900px;
        }

    </style>
</head>
<!-- resources/views/navbar.blade.php -->
 <body>
<div class="header">
     <h1>Toy Treasure</h1>
     <ul class="nav-links">
         <li><a href="http://127.0.0.1:8000/shopnow"><i class="fas fa-home"></i> Home</a></li>
         <li><a href="http://127.0.0.1:8000/contact"><i class="fas fa-envelope"></i> Contact</a></li>
         <li><a class="nav-link nav-links cart-icon" href="{{ route('cart.show') }}">
         <i class="fas fa-shopping-cart"></i> Cart
             
            </a></li>
         <li><a href="http://127.0.0.1:8000/orders"><i class="fas fa-box"></i> Ordered</a></li>
         <li><a href="http://127.0.0.1:8000/cancel-orders"><i class="fas fa-shopping-bag"></i> Cancelled</a></li>
         <li><a href="http://127.0.0.1:8000/login"><i class="fas fa-sign-out"></i> Log-out</a></li>
         <li class="dropdown">
             <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                 <i class="fas fa-list"></i> Categories
             </a>
             <ul class="dropdown-menu">
    @foreach ($categories as $category)
        <li>
            <a class="dropdown-item" href="{{ route('category.show', ['category' => urlencode($category->category)]) }}">
                {{ $category->category }}
            </a>
        </li>
    @endforeach
</ul>

         </li>
     </ul>
     <span>
        @if(Session::has('username'))
            Welcome, {{ Session::get('username') }}
        @else
            Welcome, Guest
        @endif
    </span>
 </div>
 <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
