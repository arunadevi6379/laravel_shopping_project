<?php
session_start();

// Create connection to the database
$conn = new mysqli("localhost", "root", "", "toys");

// Check for database connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get the total quantity of each product from the products table
$query = "SELECT name, SUM(quantity) AS total_count 
          FROM products 
          GROUP BY name";

// Execute the query
$result_products = $conn->query($query);

// Check if the query was successful
if (!$result_products) {
    die("Query failed: " . $conn->error); // Error handling in case query fails
}

// Fetch results as associative array
$products_data = $result_products->fetch_all(MYSQLI_ASSOC);

// Check if the data was fetched properly
if (!$products_data) {
    echo "No data found or error fetching data.";
}

// Close the connection to the database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        h1 {
            text-align: center;
        }

        body {
            background-color: white; /* Baby pink background */
        }

        table {
            color: black;
        }

        .table th {
            background: linear-gradient(to right, darkviolet, red, blue); /* Gradient for header */
            color: black; /* Black text for header */
        }

        .table td {
            background-color: #D3D3D3; /* Light grey for rows */
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1>Total Products</h1>

    <!-- Check if products_data is not empty before displaying the table -->
    <?php if (!empty($products_data)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Total Quantity</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through each product and display its data -->
                <?php foreach ($products_data as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo $product['total_count']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <!-- If no products are found, display a message -->
        <p>No products found in the products table.</p>
    <?php endif; ?>

    <a href="http://127.0.0.1:8000/admin/dashboard" class="btn btn-secondary">Back to Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
