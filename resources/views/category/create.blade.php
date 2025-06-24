<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            background-image: url('back.jpeg');
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-top: 80px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            color: white;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"] {
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
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: blue;
            text-decoration: none;
        }
        .alert {
            background-color: green;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .alert.error {
            background-color: red;
        }
    </style>
</head>
<body>
    @include('navbar_admin')

    <h1>Add New Category</h1>

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert error">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('category.store') }}" method="POST">
        @csrf

        <label for="category_name">Category Name:</label>
        <input type="text" id="category_name" name="category_name" required>

        <button type="submit"><i class="fas fa-plus"></i> Add Category</button>
    </form>

    <div class="back-link">
        <p><a href="{{ route('product.create') }}">Go back to Add New Product</a></p>
    </div>
</body>
</html>
