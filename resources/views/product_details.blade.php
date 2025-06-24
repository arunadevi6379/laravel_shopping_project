<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        img {
            height: 150px;
            width: 100%;
            object-fit: contain;
            object-position: left;
        }

        body {
            background-image: url('back.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
        }

        h1 {
            color: white;
        }

        .card {
            background: rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1>Product Details</h1>
    <div class="card">
        <div class="card-body">
            <!-- Display product images -->
            @php
                $images = explode(',', $product->image);
                $first_image = trim($images[0]); // Get the first image
            @endphp
            <img src="http://localhost:8080/FULLSTACK/uploads/{{ $first_image }}" class="card-img-top" alt="{{ $product->name }}">

            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text">Price: ₹{{ number_format($product->price, 2) }}</p>
            <p class="card-text">Description: {{ $product->description }}</p>
            <p class="card-text">Available Stock: {{ $product->quantity }}</p>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
