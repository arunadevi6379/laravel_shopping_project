<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url('{{ asset('admin.jpg') }}'); /* Replace with your background image */
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; /* Center items vertically */
        }

        .header-container {
            background-color: rgba(255, 255, 255, 0.8);
            width: 900px; /* Increased width for the header */
            padding: 20px; /* Padding for a larger appearance */
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px; /* Add margin below the header */
            border-radius: 5px; /* Optional: Rounded corners */
        }

        h1 {
            margin: 0;
            color: #333;
            font-size: 24px; /* Increased font size */
        }

        .icon {
            margin-right: 10px; /* Space between icon and text */
            vertical-align: middle; /* Align icon vertically with text */
        }

        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .button-row {
            display: flex;
            justify-content: center; /* Center the buttons horizontally */
            margin-bottom: 10px; /* Space between rows */
        }

        .rainbow-button {
            padding: 10px 25px; /* Increased padding for longer buttons */
            border: none;
            border-radius: 5px;
            background: linear-gradient(270deg, #ff0000, #ff7f00, #ffff00, #00ff00, #0000ff, #4b0082, #9400d3);
            background-size: 400%;
            color: white;
            font-size: 20px; /* Increased font size */
            cursor: pointer;
            position: relative;
            overflow: hidden;
            animation: rainbow-animation 5s linear infinite;
            font-weight: bold;
            margin: 0 10px; /* Space between buttons */
            width: 290px; /* Set a fixed width for equal button sizes */
        }

        @keyframes rainbow-animation {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }

        .add-product-button {
            padding: 10px 25px; /* Increased padding for longer button */
            border: none;
            border-radius: 5px;
            background: linear-gradient(270deg, #ff0000, #ff7f00, #ffff00, #00ff00, #0000ff, #4b0082, #9400d3);
            background-size: 400%;
            color: white;
            font-size: 20px; /* Increased font size */
            cursor: pointer;
            position: relative;
            overflow: hidden;
            animation: rainbow-animation 5s linear infinite;
            font-weight: bold;
            margin-top: 40px; /* Space above the button */
            width: 290px; /* Same width for consistency */
        }
    </style>
</head>
<body>
@include('navbar_admin')

    <div class="header-container">
        <h1><i class="fas fa-cogs icon"></i>ADMIN DASHBOARD</h1>
    </div>

    <div class="button-container">
        <div class="button-row">
            <button class="rainbow-button" onclick="location.href='http://127.0.0.1:8000/admin/dashboard'"><i class="fas fa-book"></i> Records</button>
            <button class="rainbow-button" onclick="location.href='http://localhost:8000/admin/users'"><i class="fas fa-users"></i> Manage Users</button>
            <button class="rainbow-button" onclick="location.href='http://localhost:8000/admin/products'"><i class="fas fa-box"></i> Manage Products</button>
        </div>
        <div>
            <button class="add-product-button" onclick="location.href='http://127.0.0.1:8000/add-product'"><i class="fas fa-plus"></i> Add New Product</button>
            <button class="add-product-button" onclick="location.href='http://127.0.0.1:8000/update-product'"><i class="fas fa-plus"></i> Add Quantity</button>
            <button class="add-product-button" onclick="location.href='http://127.0.0.1:8000/expenses'"><i class="fas fa-money-bill"></i> Expense</button>
            <button class="add-product-button" onclick="location.href='http://127.0.0.1:8000/deliveries'"><i class="fas fa-box"></i> Delivery Confirmation</button>
        </div>
    </div>

</body>
</html>
