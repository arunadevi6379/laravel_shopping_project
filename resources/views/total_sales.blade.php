<?php
session_start();
$conn = new mysqli("localhost", "root", "", "toys");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update SQL query to join tables based on product name
$query = "SELECT 
            ol.order_id,
            p.name AS product_name, 
            op.quantity, 
            ol.order_date, 
            (p.price * op.quantity) AS total_price 
          FROM order_product op
          JOIN products p ON op.product_name = p.name  -- Joining by product_name
          JOIN order_list ol ON op.order_id = ol.order_id";  // Correct join with order_list

// Execute the query
$result_total = $conn->query($query);

// Check if the query is successful
if ($result_total === false) {
    echo "Error executing query: " . $conn->error;
    exit();
}

// Fetch all results
$sales_data = $result_total->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Sales</title>
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
    <h1>Total Sales</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Date Ordered</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sales_data as $sale): ?>
                <tr>
                    <td><?php echo htmlspecialchars($sale['order_id']); ?></td>
                    <td><?php echo htmlspecialchars($sale['product_name']); ?></td>
                    <td><?php echo $sale['quantity']; ?></td>
                    <td><?php echo $sale['order_date']; ?></td>
                    <td>₹<?php echo number_format($sale['total_price'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="http://127.0.0.1:8000/admin/dashboard" class="btn btn-secondary">Back to Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
