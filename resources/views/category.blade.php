<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category }} - Toy Treasure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
            height: 400px;
        }
        .product img {
            max-width: 100%;
            max-height: 150px;
            object-fit: contain;
            border-radius: 5px;
        }
        .product h5 {
            font-size: 1rem;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>

@include('navbar')

<div class="container mt-5">
    <h1 class="text-center">{{ $category }} Products</h1>

    <!-- Success and Alert Messages -->
    @if(session('success_message'))
        <div class="alert alert-success">
            {{ session('success_message') }}
        </div>
    @endif

    @if(session('alert'))
        <div class="alert alert-danger">
            {{ session('alert') }}
        </div>
    @endif

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-3">
                <div class="product">
                    @php
                        // Split the images by comma and get the first image
                        $productImages = explode(',', $product->image);
                        $firstImage = $productImages[0];
                    @endphp
                    <img src="{{ asset($firstImage) }}" class="card-img-top" alt="{{ $product->name }}">
                    <h5>{{ $product->name }}</h5>
                    <p>Price: ₹{{ $product->price }}</p>
                    <p>{{ $product->description }}</p>

                    <p style="color: {{ $product->quantity == 0 ? 'red' : 'black' }}">
                        {{ $product->quantity == 0 ? 'Out of Stock' : 'Quantity: ' . $product->quantity }}
                    </p>
                    <p><i class="fas fa-star" style="color: yellow;"></i> Rating: {{ $product->rating }}</p>

                    @if($product->quantity > 0)
                        <a href="{{ url('/category/' . urlencode($category) . '/add/' . $product->id) }}" class="btn btn-success">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </a>
                    @else
                        <button class="btn btn-danger" disabled>Out of Stock</button>
                    @endif
                </div>
            </div>
        @empty
            <p>No products found in this category.</p>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
