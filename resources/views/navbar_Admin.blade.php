<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>your Treasure</title>
<style>
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
         .navbar-text {
            margin-left: auto; /* Align "Welcome admin" to the far right */
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding-right: 20px; /* Add some right padding for spacing */
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
        .navbar-text {
            margin-right: 100px;
        }
        i{
            font-size: 18px;
        }

    </style>
    <body>
    <div class="header">
        <h1>Your Treasure</h1>
        <ul class="nav-links">
            <li><a href="http://127.0.0.1:8000/admin-dashboard"><i class="fas fa-home"></i>  Home</a></li>
            <li><a href="http://127.0.0.1:8000/admin/dashboard"><i class="fas fa-book"></i>  Records</a></li>
            <li><a href="http://localhost:8000/admin/users"><i class="fas fa-users"></i>  Users</a></li>
            <li><a href="http://localhost:8000/admin/products
"><i class="fas fa-box"></i>  Products</a></li>
            <li><a href="http://127.0.0.1:8000/add-product"><i class="fas fa-plus"></i>  Add product</a></li>
            <li><a href="http://127.0.0.1:8000/update-product"><i class="fas fa-pencil"></i>  Update quantity</a></li>
            <li><a href="http://127.0.0.1:8000/expenses"><i class="fas fa-inr"></i>  Expense</a></li>
            <li><a href="http://127.0.0.1:8000/deliveries"><i class="fas fa-truck"></i>  Delivery</a></li>
            <li><a href="http://127.0.0.1:8000/admin/login"><i class="fas fa-sign-out"></i> Log-out</a></li>
        </ul>
        
       


        <span class="navbar-text" >
           Welcome admin!!
        </span>
        </div>
        
        
        
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
