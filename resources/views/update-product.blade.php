<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            background-image: url('back.jpeg');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            padding: 20px;
            color: white;
        }
        h1 {
            text-align: center;
            margin-top: 80px;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: white;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    @include('navbar_admin')

    <h1>Update Product</h1>

    @if(session('error'))
        <div style="color: red; text-align: center;">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div style="color: green; text-align: center;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form to enter Product ID to fetch and update details -->
    <form action="{{ route('product.fetch') }}" method="POST">
        @csrf
        <label for="id">Product ID:</label>
        <input type="number" id="id" name="id" required>

        <button type="submit">Fetch Product</button>
    </form>

    @isset($product)
    <!-- If product data is available, show the form to update product -->
    <form action="{{ route('product.update', $product->id) }}" method="POST">
        @csrf
        @method('POST')

        <label for="id">Product ID:</label>
        <input type="number" id="id" name="id" value="{{ $product->id }}" readonly>

        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" value="{{ $product->name }}" required style="width: 100%">

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="{{ $product->quantity }}" required>

        <button type="submit">Update Product</button>
    </form>
    @endisset
</body>
</html>
