<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Manage Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Include your CSS styles here */
        body {
            background-color: aliceblue;
            font-family: 'Franklin Gothic Medium', sans-serif;
            margin: 0;
            padding: 0;
        }
        h1 {
            font-size: 30px;
            text-align: center;
            margin-top: 80px;
        }
        table, th, td {
            border-collapse: collapse;
            border: 2px solid black;
            padding: 10px 20px;
        }
        table {
            width: 90%;
            text-align: center;
            margin: 10px auto;
        }
        th {
            font-size: large;
            font-family: sans-serif;
            background-color: darkblue;
            color: white;
        }
        .update-btn {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }
        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }
        .search-container {
            margin: 20px auto;
            text-align: center;
        }
        input[type="text"] {
            padding: 10px;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .pagination {
            text-align: center;
            margin: 20px 0;
            justify-content: center;
        }
        .pagination a {
            margin: 0 5px;
            padding: 8px 12px;
            background: darkblue;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .pagination a.active {
            background: darkgreen;
            font-weight: bold;
        }

        /* To resize the images */
        .product-img {
            width: 50px;  /* Adjust this size as needed */
            height: 50px;
            object-fit: contain;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    @include('navbar_admin') <!-- Include navbar admin if you have one -->

    <div class="content">
        <h1><i class="fas fa-box"></i> MANAGE PRODUCTS</h1>
        <div class="search-container">
            <input type="text" id="search" placeholder="Search Products...">
        </div>
        <table id='t1'>
            <thead>
                <tr>
                    <th>SNo</th>
                    <th>PRODUCT NAME</th>
                    <th>IMAGES</th>
                    <th>PRICE</th>
                    <th>DESCRIPTION</th>
                    <th>CATEGORY</th>
                    <th>QUANTITY</th>
                    <th>UPDATE</th>
                    <th>DELETE</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>
                            @php
                                $images = explode(",", $product->image); // Split the image string into an array
                            @endphp
                            @foreach ($images as $image)
                                @php
                                    // Make sure the image path is correct
                                    $image_path = 'http://localhost:8080/FULLSTACK/uploads/' . trim($image);  // Adjust this to point to your actual image directory
                                @endphp
                                <img src="{{ $image_path }}" class="product-img" alt="{{ $product->name }}">
                            @endforeach
                        </td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->category }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            <a href="{{ route('products.updateView', $product->id) }}">
                                <button class="update-btn"><i class="fas fa-edit"></i> UPDATE</button>
                            </a>
                        </td>
                        <td>
                        <form action="{{ route('products.delete', $product->id) }}" method="POST" onsubmit="return confirmDelete()">
    @csrf
    @method('DELETE')
    <button type="submit" class="delete-btn"><i class="fas fa-trash"></i> REMOVE</button>
</form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            {{ $products->links() }}
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#search").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#t1 tbody tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
             // Confirmation before deletion
             function confirmDelete() {
                return confirm('Are you sure you want to delete this product?');
            }
        </script>
    </div>
</body>
</html>
