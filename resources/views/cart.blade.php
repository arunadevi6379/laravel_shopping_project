<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            background: linear-gradient(to right, violet, pink, violet);
            z-index: 1000;
            position: fixed; 
            width: 100%; 
            top: 0; 
            left: 0; 
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
        .nav-links a {
            text-decoration: none;
            color: black;
            font-size: 14px;
            padding: 8px 12px;
        }
        .content {
            margin-top: 80px; 
        }
        h1 {
            text-align: center;
            margin-top: 80px; 
        }
        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .cart-item img {
            width: 80px;
            height: auto;
            margin-right: 15px;
        }
        .cart-details {
            flex-grow: 1;
            text-align: center;
        }
        .quantity-buttons {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-right: 10px;
        }
        .quantity-buttons button {
            margin: 0 5px;
            background-color: darkviolet;
            color: white;
            border-color: black;
        }
        .place-order {
            margin-left: 10px;
        }
        i {
            font-size: 24px;
        }
        .cart-item .quantity-buttons form {
            display: flex;
            align-items: center;
        }
        .cart-item .quantity-buttons form input {
            width: 50px;
        }
        .btn-custom {
            background-color: darkviolet;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn-custom:hover {
            background-color: violet;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Toy Treasure</h1>
        <ul class="nav-links">
            <li class="nav-item"><a class="nav-link nav-links" href="http://127.0.0.1:8000/shopnow"><i class="fas fa-home"></i> Home</a></li>
            <li class="nav-item"><a class="nav-link nav-links" href="ui.php"><i class="fas fa-envelope"></i> Contact</a></li>
            <li class="nav-item"><a class="nav-link nav-links" href="http://127.0.0.1:8000/cart"><i class="fas fa-shopping-cart"></i> Cart</a></li>
            <li class="nav-item"><a class="nav-link nav-links" href="order.php"><i class="fas fa-box"></i> Ordered</a></li>
            <li class="nav-item"><a class="nav-link nav-links" href="cancel.php"><i class="fas fa-shopping-bag"></i> Cancelled</a></li>
            <li><a href="http://127.0.0.1:8000/login"><i class="fas fa-sign-out"></i> Log-out</a></li>
        </ul>
        <span>Welcome, {{ Session::get('username') }}</span>
    </div>

    <div class="container mt-5">
        <h1 class="text-center">My Cart</h1>

        <div>
            @if($cartItems->isNotEmpty())
                @foreach($cartItems as $item)
                    <div class="cart-item">
                        <?php
                            $images = explode(",", $item->image);
                            $imageUrl = "http://localhost:8080/FULLSTACK/uploads/" . htmlspecialchars($images[0]);
                        ?>
                        <img src="{{ $imageUrl }}" alt="{{ $item->name }}" class="img-fluid" style="max-width: 100px;">
                        <div class="cart-details">
                            <h5>{{ $item->name }}</h5>
                            <p>{{ $item->description }}</p>
                            <p>Price: ₹{{ $item->price }}</p>
                        </div>

                        <div class="quantity-buttons">
                            <form method="POST" action="{{ route('cart.updateQuantity', $item->product_id) }}">
                                @csrf
                                <button type="button" onclick="incrementQuantity({{ $item->product_id }})" class="btn btn-secondary">+</button>
                                <input type="number" id="quantity-{{ $item->product_id }}" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control" style="width: 50px;">
                                <button type="button" onclick="decrementQuantity({{ $item->product_id }})" class="btn btn-secondary">-</button>
                                <button type="submit" class="btn btn-info">Update</button>
                            </form>
                            <a href="{{ route('cart.remove', $item->product_id) }}" class="btn btn-danger"><i class="fas fa-trash"></i> Remove</a>
                        </div>
                    </div>
                @endforeach

                <h3>Total Amount: ₹{{ $total_amount }}</h3>

                <!-- Redirect to payment page when the user clicks the button -->
                <a href="{{ route('payment.page', ['total_amount' => $total_amount]) }}" class="btn-custom">
    Proceed to Payment
</a>

            @else
                <p>Your cart is empty.</p>
            @endif
        </div>
    </div>

    <script>
        function incrementQuantity(productId) {
            const quantityInput = document.getElementById('quantity-' + productId);
            quantityInput.value = parseInt(quantityInput.value) + 1;
        }

        function decrementQuantity(productId) {
            const quantityInput = document.getElementById('quantity-' + productId);
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        }
    </script>
</body>
</html>