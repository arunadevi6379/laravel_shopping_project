<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            background-image: url('{{ asset('back.jpeg') }}');
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: white;
            margin-top: 80px;
        }
        form {
            max-width: 600px;
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
            color: white;
        }
        input[type="text"],
        input[type="number"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
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
        .btn {
            color: white;
            background-color: white;
            width: auto;
            padding: 10px 10px;
            margin-left: 10px;
            margin-bottom: 10px;
        }
        .btn:hover {
            background-color: darkviolet;
        }
        #imagePreviewContainer {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        #imagePreviewContainer img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            cursor: pointer;
        }
        .import-section {
            margin-top: 50px;
            text-align: center;
        }
        .alert {
            background-color: green;
            color: white;
            border: 1px solid green;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            position: relative;
        }
        .alert button {
            background: none;
            border: none;
            color: red;
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 5px;
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
        .navbar-text{
            margin-right: 100px;
        }
    </style>
</head>
<body>
    @include('navbar_admin')

    <h1 style="color:white">Add New Product</h1>

    <!-- Display Alert if set in session -->
    @if (session('alert'))
        <div class="alert">
            {{ session('alert') }}
            <button onclick="this.parentElement.style.display='none'">X</button>
        </div>
    @endif

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Import Excel Form -->
    <div class="import-section">
        <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="excel_file">Import Products from Excel:</label>
            <input type="file" name="excel_file" id="excel_file" accept=".xls, .xlsx" required>
            <button type="submit"><i class="fas fa-arrow-down"></i> Import Excel</button>
        </form>
    </div>

    <!-- Add New Product Form -->
    <form action="{{ route('store.product') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="photos">Product Photos (Select multiple images):</label>
        <input type="file" id="photos" name="photos[]" accept="image/*" multiple required onchange="previewImages(event)">

        <div id="imagePreviewContainer"></div>

        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required style="width: 100%">

        <label for="price">MRP:</label>
        <input type="number" id="price" name="price" required>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" maxlength="100" required></textarea>

        <label for="category">Category:</label>
        <div style="display: flex; align-items: center;">
            <select id="category" name="category" required style="flex-grow: 1;">
                <option value="" disabled selected>Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->category }}">{{ $category->category }}</option>
                @endforeach
            </select>

            <button type="button" class="btn" onclick="window.location.href='{{ route('category.create') }}'"><i class="fas fa-plus" style="color: white;"></i></button>
        </div>

        <button type="submit"><i class="fas fa-plus"></i> Add Product</button>
    </form>

    <script>
        function previewImages(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('imagePreviewContainer');
            previewContainer.innerHTML = ''; // Clear previous previews

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = file.name;
                    img.style.width = "100px";
                    img.style.height = "100px";
                    img.style.objectFit = "cover";

                    previewContainer.appendChild(img);
                }

                if (file) {
                    reader.readAsDataURL(file);
                }
            }
        }
    </script>
</body>
</html>
