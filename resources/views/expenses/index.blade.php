<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        /* Basic Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 0;
            margin: 0;
        }

        /* Adjust navbar styling if needed */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            z-index: 9999;
        }

        .content {
            padding-top: 80px; /* Adjust based on navbar height */
        }

        .form-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], input[type="number"], input[type="date"], input[type="radio"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
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

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            margin: 0 5px;
            padding: 10px 15px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: black;
        }

        .pagination a.active {
            background-color: #28a745;
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

        .navbar-text {
            margin-right: 100px;
        }
    </style>
</head>
<body>
@include('navbar_admin')

    <!-- Content Section -->
    <div class="content">
    <h2 style="text-align:center">New Expense Form</h2>
        <!-- Form to add new expense -->
        <div class="form-container">
           
            <form method="POST" id="expenseForm">
                @csrf
                <label for="retailer_name">Retailer Name:</label>
                <input type="text" id="retailer_name" name="retailer_name" required style="width:100%">

                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" required step="0.01">

                <label>Payment Method:</label>
                <input type="radio" name="payment_method" value="PhonePe" required> PhonePe
                <input type="radio" name="payment_method" value="Paytm" required> Paytm
                <input type="radio" name="payment_method" value="Cash on Delivery" required> Cash on Delivery<br><br>

                <label for="expense_date">Expense Date:</label>
                <input type="date" id="expense_date" name="expense_date" required>

                <button type="submit"><i class="fas fa-plus"></i> Add Expense</button>
            </form>
        </div>

        <!-- Table to display existing expenses -->
        <div class="form-container" id="expenseTableContainer">
            <h2>Expenses List</h2>
            <table id="expenseTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Retailer Name</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Expense Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenses as $expense)
                        <tr>
                            <td>{{ $expense->id }}</td>
                            <td>{{ $expense->retailer_name }}</td>
                            <td>{{ $expense->amount }}</td>
                            <td>{{ $expense->payment_method }}</td>
                            <td>{{ $expense->expense_date }}</td>
                            <td>
                                <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination links -->
            <div class="pagination">
                {{ $expenses->links() }}
            </div>
        </div>
    </div>

    <!-- Script to handle form submission using AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#expenseForm').submit(function (e) {
                e.preventDefault();  // Prevent default form submission

                var formData = $(this).serialize();  // Get form data

                $.ajax({
                    url: '{{ route('expenses.store') }}',
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        // After successful submission, reload the table
                        $('#expenseTable').html(response.expensesHtml);
                        $('#expenseForm')[0].reset();  // Reset the form
                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>
</body>
</html>
