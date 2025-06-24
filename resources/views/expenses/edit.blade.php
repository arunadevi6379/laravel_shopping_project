<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Expense</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        .container {
            width: 50%;
            margin: 0 auto;
        }
        form {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }
        label {
            margin-bottom: 10px;
            font-size: 16px;
        }
        input[type="text"], input[type="number"], input[type="date"], input[type="radio"] {
            padding: 8px;
            margin: 8px 0 20px 0;
            border: 1px solid #ddd;
            font-size: 14px;
        }
        .btn {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Expense</h1>

    <form method="POST" action="{{ route('expenses.update', $expense->id) }}">
        @csrf
        @method('PUT')

        <label for="retailer_name">Retailer Name:</label>
        <input type="text" name="retailer_name" id="retailer_name" value="{{ $expense->retailer_name }}" required>

        <label for="amount">Amount:</label>
        <input type="number" name="amount" id="amount" value="{{ $expense->amount }}" required>

        <label>Payment Method:</label>
        <input type="radio" name="payment_method" value="PhonePe" {{ $expense->payment_method == 'PhonePe' ? 'checked' : '' }} required> PhonePe
        <input type="radio" name="payment_method" value="Paytm" {{ $expense->payment_method == 'Paytm' ? 'checked' : '' }} required> Paytm
        <input type="radio" name="payment_method" value="Cash on Delivery" {{ $expense->payment_method == 'Cash on Delivery' ? 'checked' : '' }} required> Cash on Delivery

        <label for="expense_date">Expense Date:</label>
        <input type="date" name="expense_date" id="expense_date" value="{{ $expense->expense_date }}" required>

        <button type="submit" class="btn">Update Expense</button>
    </form>
</div>

</body>
</html>
