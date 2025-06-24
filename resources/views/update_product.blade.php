<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: aliceblue;
            font-family: 'Franklin Gothic Medium', sans-serif;
        }

        h1 {
            font-size: 30px;
            text-align: center;
            margin-top: 80px;
        }

        form {
            border: 3px solid #f1f1f1;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
        }

        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #04AA60;
            color: white;
            padding: 14px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 4px;
        }

        button:hover {
            background-color: darkgreen;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        .container {
            padding: 16px;
        }
    </style>
</head>
<body>
    <h1><i class="fas fa-edit"></i> Update Product</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name"><b>Name</b></label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}" required>

        <label for="image"><b>Image</b></label>
      
        <input type="text" name="image" value="{{ old('image', $product->image) }}" required>

        <label for="price"><b>Price</b></label>
        <input type="number" name="price" value="{{ old('price', $product->price) }}" required>

        <label for="quantity"><b>Quantity</b></label>
        <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}" required>

        <label for="description"><b>Description</b></label>
        <input type="text" name="description" value="{{ old('description', $product->description) }}" required>

       
        <label for="category"><b>Category</b></label>
        <select name="category" id="category" required>
            <option value="" disabled>Select a category</option>
            @foreach ($categories as $categoryOption)
                <option value="{{ $categoryOption->category }}" 
                    {{ old('category', $product->category) == $categoryOption->category ? 'selected' : '' }}>
                    {{ $categoryOption->category }}
                </option>
            @endforeach
        </select>
        <button type="submit">Update Product</button>
    </form>
</body>
</html>
