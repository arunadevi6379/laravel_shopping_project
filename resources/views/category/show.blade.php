<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>{{ ucfirst($decodedCategory) }}- Toy Treasure</title>
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
    </style>
</head>
<body>
    <!-- Include your dynamic navbar -->
    @include('navbar')

    <div class="container mt-5">
        <h1 class="text-center" style="margin-top: 80px;">{{ ucfirst($decodedCategory) }}Products</h1>

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
            @forelse($products as $product)
                <div class="col-md-3">
                    <div class="product">
                        <?php
                        // Split the images if there are multiple
                        $product_images = explode(',', $product->image); // Assuming images are stored as comma-separated values
                        $first_image = $product_images[0]; // Get the first image
                        ?>
                        <img src="http://localhost:8080/FULLSTACK/uploads/{{ htmlspecialchars($first_image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Price: ₹{{ $product->price }}</p>
                        <p class="card-text">{{ $product->description }}</p>
                        <p style="color: {{ $product->quantity == 0 ? 'red' : 'black' }}">
                            {{ $product->quantity == 0 ? 'Out of Stock' : 'Quantity: ' . $product->quantity }}
                        </p>
                        <p><i class="fas fa-star" style="color: yellow;"></i> Rating: {{ $product->rating }}</p>
                        @if($product->quantity > 0)
                        <a href="{{ route('category.show', ['category' => urlencode($decodedCategory)]) }}" class="btn btn-success">
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
