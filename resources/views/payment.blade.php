<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script>
        function toggleBankDetailsForm() {
            var bankForm = document.getElementById('bank-details-form');
            var paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            if (paymentMethod === 'bank') {
                bankForm.style.display = 'block';
            } else {
                bankForm.style.display = 'none';
            }
        }
    </script>
</head>
<body>
@include('navbar') 
    <div class="container mt-5">
        <h1 class="text-center" style="margin-top:100px">Payment Details</h1>
        <h3>Total Amount: ₹{{ $total_amount }}</h3>
        <form method="POST" action="{{ route('payment.process') }}">
            @csrf
            <input type="hidden" name="total_amount" value="{{ $total_amount }}">
            <input type="hidden" name="username" value="{{ $username }}">
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $address) }}" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $phone) }}" required>
            </div>
            <div class="mb-3">
                <label>Payment Method</label><br>
                <input type="radio" id="cod" name="payment_method" value="cod" required onclick="toggleBankDetailsForm()" {{ old('payment_method') == 'cod' ? 'checked' : '' }}>
                <label for="cod">Cash on Delivery</label><br>
                <input type="radio" id="bank" name="payment_method" value="bank" required onclick="toggleBankDetailsForm()" {{ old('payment_method') == 'bank' ? 'checked' : '' }}>
                <label for="bank">Bank Transfer</label>
            </div>
            <div id="bank-details-form" style="display: none;">
                <div class="mb-3">
                    <label for="account_number" class="form-label">Account Number (16 digits)</label>
                    <input type="text" class="form-control" id="account_number" name="account_number" maxlength="16" value="{{ old('account_number') }}">
                </div>
                <div class="mb-3">
                    <label for="cvv" class="form-label">CVV (3 digits)</label>
                    <input type="text" class="form-control" id="cvv" name="cvv" maxlength="3" value="{{ old('cvv') }}">
                </div>
                <div class="mb-3">
                    <label for="expiry_date" class="form-label">Expiry Date</label>
                    <input type="month" class="form-control" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-success">Confirm Payment</button>
        </form>
    </div>
</body>
</html>