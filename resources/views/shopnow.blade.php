<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Now</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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
        .product {
            background: #fff;
            border-radius: 5px;
            margin: 10px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 400px; /* Fixed height */
        }
        .product img {
            max-width: 100%;
            max-height: 150px; /* Set a maximum height for images */
            object-fit: contain; /* Ensure the image fits within the given space */
            border-radius: 5px;
        }
        .product h2 {
            font-size: 0.9rem; /* Reduced size for product name */
            margin: 5px 0; /* Reduced margin for compactness */
            overflow: hidden; /* Ensure text doesn't overflow */
            white-space: nowrap; /* Prevent line breaks */
            text-overflow: ellipsis; /* Show ellipsis for overflow */
        }
        .product p {
            margin: 2px 0; /* Reduced margin between lines */
        }
        .btn-add-to-cart {
            font-size: 0.8rem; /* Smaller button */
            margin-top: auto; /* Push button to the bottom */
        }
        .cart-icon {
            position: relative; /* To position the badge */
        }
        .badge {
            position: absolute;
            top: -5px;
            right: -10px;
            font-size: 0.75rem;
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
        .content {
            margin-top: 100px;
        }
        .product {
            background: #fff;
            border-radius: 5px;
            margin: 20px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 600px; /* Increased height */
            width: 320px;
            overflow: hidden;
            position: relative;
        }
        .product img {
            max-width: 100%;
            height: 200px;
            object-fit: contain;
            border-radius: 5px;
        }
        .product .thumbnails-container {
            display: flex;
            justify-content: center;
            position: relative;
            overflow: hidden;
            margin-top: 15px;
        }
        .product .thumbnails {
            display: flex;
            transition: transform 0.3s ease;
        }
        .product .thumbnails img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            cursor: pointer;
            margin: 0 5px;
        }
        .product .arrow-left, .product .arrow-right {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 24px;
            color: #000;
            cursor: pointer;
            z-index: 1;
        }
        .product .arrow-left {
            left: 10px;
        }
        .product .arrow-right {
            right: 10px;
        }
        .product h3 {
            font-size: 1.5rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .product p {
            font-size: 1rem;
            margin-bottom: 10px;
            text-align: center;
        }
        .product .btn-add-to-cart {
            font-size: 1rem;
            margin-top: auto;
            text-align: center;
            margin-bottom: 10px;
        }
        .rating {
            color: gold;
        }
        .search-bar {
            display: flex;
            align-items: center;
            margin-left: 20px;
        }
        .search-bar input {
            width: 200px;
            margin-right: 5px;
        }
        .search-bar button {
            background: transparent;
            border: none;
            color: white;
        }
        i{
            font-size: 24px;
        }
        .alert {
            margin: 20px;
            padding: 10px;
            color: white;
            background-color: #28a745;
            border-radius: 5px;
            text-align: center;
        }

        .alert-danger {
            background-color: #dc3545;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Toy Treasure</h1>
    <form class="search-bar" method="GET" action="{{ route('shopnow') }}">
        <input type="text" name="search_query" class="form-control" placeholder="Search products..." value="{{ request()->input('search') }}">
        <button type="submit" name="search"><i class="fas fa-search"></i></button>
    </form>
    <ul class="nav-links">
        <li class="nav-item"><a class="nav-link nav-links" href="http://127.0.0.1:8000/shopnow"><i class="fas fa-home"></i> Home</a></li>
        <li class="nav-item"><a class="nav-link nav-links" href="http://127.0.0.1:8000/contact"><i class="fas fa-envelope"></i> Contact</a></li>
        <li class="nav-item">
            <a class="nav-link nav-links cart-icon" href="{{ route('cart.show') }}">
                <i class="fas fa-shopping-cart"></i> Cart
                <span class="badge bg-danger">{{ $cartCount }}</span>
            </a>
        </li>
        <li class="nav-item"><a class="nav-link nav-links" href="http://127.0.0.1:8000/orders"><i class="fas fa-box"></i> Ordered</a></li>
        <li class="nav-item"><a class="nav-link nav-links" href="http://127.0.0.1:8000/cancel-orders"><i class="fas fa-shopping-bag"></i> Cancelled</a></li>
        <li><a href="http://127.0.0.1:8000/login"><i class="fas fa-sign-out"></i> Log-out</a></li>
    </ul>
    <span>
        @if(Session::has('username'))
            Welcome, {{ Session::get('username') }}
        @else
            Welcome, Guest
        @endif
    </span>
</div>

<div class="container content">
    <div style="margin-top: 80px;">
        <div class="row">
            <div class="container mt-3">
                @if(session('success'))
                    <div class="alert">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
            </div>
            <h1 class="text-center" style="margin-top: 80px;">Products</h1>
            @if(count($products) > 0)
                <div class="row">
                    @foreach($products as $product)
                        <?php
                            $images = explode(",", $product->image);
                            $description = htmlspecialchars($product->description);
                            $words = explode(" ", $description);
                            $short_description = implode(" ", array_slice($words, 0, 3)) . (count($words) > 3 ? '...' : '');
                        ?>
                        <div class="col-md-3">
                            <div class="product">
                                <img src="http://localhost:8080/FULLSTACK/uploads/{{ htmlspecialchars($images[0]) }}" alt="Main Image" id="mainImage_{{ $product->id }}" />
                                <div class="thumbnails-container">
                                    <i class="fas fa-chevron-left arrow-left" onclick="moveThumbnails('left', '{{ $product->id }}')"></i>
                                    <div class="thumbnails" id="thumbnails_{{ $product->id }}">
                                        @foreach($images as $image)
                                            <img src="http://localhost:8080/FULLSTACK/uploads/{{ htmlspecialchars($image) }}" alt="Thumbnail" class="thumbnail" onclick="changeMainImage('{{ htmlspecialchars($image) }}', '{{ $product->id }}')" />
                                        @endforeach
                                    </div>
                                    <i class="fas fa-chevron-right arrow-right" onclick="moveThumbnails('right', '{{ $product->id }}')"></i>
                                </div>
                                <h3>{{ htmlspecialchars($product->name) }}</h3>
                                <p>{{ $short_description }}</p>
                                <p>Price: ₹{{ htmlspecialchars($product->price) }}</p>
                                <p>Quantity: {{ htmlspecialchars($product->quantity) }}</p>
                                <p>Rating: <span class="rating">{{ str_repeat('⭐', $product->rating) }}</span> {{ $product->rating }} </p>

                                @if($product->quantity == 0)
                                    <div class="out-of-stock-card">
                                        <p style="color: red; font-weight: bold;">Out of Stock</p>
                                    </div>
                                @else
                                    <a href="{{ route('addToCart', ['product_id' => $product->id]) }}" class="btn btn-success btn-add-to-cart">
                                        <i class="fas fa-shopping-cart"></i> Add to Cart
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No products found.</p>
            @endif
        </div>
    </div>
</div>

<script>
    function changeMainImage(image, productId) {
        document.getElementById('mainImage_' + productId).src = image;
    }

    function moveThumbnails(direction, productId) {
        let thumbnails = document.getElementById('thumbnails_' + productId);
        let currentTransform = thumbnails.style.transform.replace('translateX(', '').replace('px)', '');
        let newTransform = direction === 'left' ? parseInt(currentTransform || 0) + 60 : parseInt(currentTransform || 0) - 60;
        thumbnails.style.transform = translateX(${newTransform}px);
    }
</script>

</body>
</html>
