<?php
session_start();
$conn = new mysqli("localhost", "root", "", "toys");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch today's sales
$date_today = date('Y-m-d');
$today_sales_query = "SELECT SUM(op.rate * op.quantity) AS total_today_sales
                      FROM order_product op
                      JOIN order_list ol ON op.order_id = ol.order_id
                      WHERE DATE(ol.order_date) = ?";
$stmt = $conn->prepare($today_sales_query);

if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error); // Debugging line to show the SQL error
}

$stmt->bind_param("s", $date_today);
$stmt->execute();
$result_today = $stmt->get_result();
$today_sales = $result_today->fetch_assoc()['total_today_sales'] ?? 0;
$stmt->close();

// Fetch total sales
$total_sales_query = "SELECT SUM(op.rate * op.quantity) AS total_sales
                      FROM order_product op
                      JOIN order_list ol ON op.order_id = ol.order_id";
$result_total = $conn->query($total_sales_query);
$total_sales = $result_total->fetch_assoc()['total_sales'] ?? 0;

// Fetch total customers
$total_customers_query = "SELECT COUNT(DISTINCT username) AS total_customers FROM page";
$result_customers = $conn->query($total_customers_query);
$total_customers = $result_customers->fetch_assoc()['total_customers'] ?? 0;

// Fetch total products
$total_products_query = "SELECT COUNT(*) AS total_products FROM products";
$result_products = $conn->query($total_products_query);
$total_products = $result_products->fetch_assoc()['total_products'] ?? 0;

// Fetch top 10 products by quantity ordered
$top_products_query = "SELECT op.product_name, SUM(op.quantity) AS total_ordered
                       FROM order_product op
                       GROUP BY op.product_name
                       ORDER BY total_ordered DESC
                       LIMIT 10";
$result_top_products = $conn->query($top_products_query);

// Fetch top 10 royal customers
$top_customers_query = "SELECT ol.username, COUNT(*) AS order_count
                        FROM order_list ol
                        GROUP BY ol.username
                        ORDER BY order_count DESC
                        LIMIT 10";
$result_top_customers = $conn->query($top_customers_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient( to left,darkviolet,indigo,blue,green,yellow,orange,red); /* Baby pink background */
            color: black; /* Text color */
        }
        .card {
            margin: 20px;
            background-color: rgba(255, 255, 255, 0.9);
        }
        .btn-large {
            font-size: 1.5em; /* Bigger font size */
            height: 120px; /* Increase button height */
            display: flex;
            flex-direction: column; /* Stack icon above text */
            justify-content: center;
            align-items: center;
            text-align: center;
            width: 100%; /* Make the buttons full width of their container */
            padding: 20px;
            margin-bottom: 20px; /* Space between buttons */
            border-radius: 10px;
        }

        .btn-large i {
            font-size: 2.5em; /* Increase icon size */
            margin-bottom: 10px; /* Space between icon and text */
        }

        .search-input {
            margin-bottom: 20px;
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
        .customer-table th {
            background: linear-gradient(to right, darkviolet, red, blue); /* Gradient for header */
            color: black; /* Black text for header */
        }
        .view-button {
            background-color: darkviolet; /* Orange color for view button */
            color: white;
            border: none;
        }
        h1 {
            text-align: center;
            margin-top: 80px; /* Space below the heading */
        }
    </style>
</head>
<body>
@include('navbar_admin')
 

    <div class="container mt-5">
        <h1><i class="fas fa-user"></i> Admin Dashboard</h1>

        <div class="row">
            <div class="col-md-3">
                <a href="{{ route('admin.today-sales') }}" class="btn btn-primary btn-large">
                    <i class="fas fa-shopping-bag"></i> Today's Sales <br> <strong>₹<?php echo number_format($today_sales, 2); ?></strong>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.total-sales') }}" class="btn btn-success btn-large">
                    <i class="fas fa-shopping-bag"></i> Total Sales <br> <strong>₹<?php echo number_format($total_sales, 2); ?></strong>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.allCustomers') }}" class="btn btn-warning btn-large">
                    <i class="fas fa-users"></i> Total Customers <br> <strong><?php echo $total_customers; ?></strong>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.totalProducts') }}" class="btn btn-info btn-large">
                    <i class="fas fa-box"></i> Total Products <br> <strong><?php echo $total_products; ?></strong>
                </a>
            </div>
        </div>

        <h3>Top 10 Products</h3>
        <input type="text" class="form-control search-input" id="productSearch" placeholder="Search for products...">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Total Ordered</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="topProductsBody">
                <?php 
                if ($result_top_products->num_rows > 0) {
                    while ($row = $result_top_products->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td><?php echo $row['total_ordered']; ?></td>
                            <td>
    <a href="{{ route('product.details', ['name' =>($row['product_name'])]) }}" class="btn view-button">
        <i class="fas fa-eye"></i> View
    </a>
</td>

                        </tr>
                    <?php endwhile; 
                } else {
                    echo "<tr><td colspan='3'>No products found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Top 10 Royal Customers</h3>
        <input type="text" class="form-control search-input" id="customerSearch" placeholder="Search for customers...">
        <table class="table table-striped customer-table">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Order Count</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="topCustomersBody">
                <?php 
                if ($result_top_customers->num_rows > 0) {
                    while ($row = $result_top_customers->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo $row['order_count']; ?></td>
                            <td>
    <a href="{{ route('admin.customer.details', ['username' => $row['username']]) }}" class="btn view-button">
        <i class="fas fa-eye"></i> View
    </a>
</td>

                        </tr>
                    <?php endwhile; 
                } else {
                    echo "<tr><td colspan='3'>No customers found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById('productSearch').addEventListener('keyup', function() {
            let input = this.value.toLowerCase();
            let rows = document.querySelectorAll('#topProductsBody tr');
            rows.forEach(row => {
                let productName = row.cells[0].textContent.toLowerCase();
                row.style.display = productName.includes(input) ? '' : 'none';
            });
        });

        document.getElementById('customerSearch').addEventListener('keyup', function() {
            let input = this.value.toLowerCase();
            let rows = document.querySelectorAll('#topCustomersBody tr');
            rows.forEach(row => {
                let customerName = row.cells[0].textContent.toLowerCase();
                row.style.display = customerName.includes(input) ? '' : 'none';
            });
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

</body>
</html>

<?php
$conn->close();
?>
