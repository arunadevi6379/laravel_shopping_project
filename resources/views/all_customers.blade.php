<?php
session_start();
$conn = new mysqli("localhost", "root", "", "toys");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all customers
$customers_query = "SELECT username, email, phone FROM page"; // Assuming these columns exist
$result_customers = $conn->query($customers_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Customers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
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
    <h1 class="text-center">All Customers</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_customers->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                </tr>
            <?php endwhile; ?>
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
