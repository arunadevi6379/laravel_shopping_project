<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<style>
   body {
        background-image: url('{{ asset('back.jpeg') }}');
        background-size: cover; /* Cover the entire viewport */
        background-position: center; /* Center the image */
        background-repeat: no-repeat; /* Prevent tiling */
        height: 100vh; /* Full height */
        margin: 0; 
    }
    h1 {
        color: white;
    }
</style>
<body>

<div class="container mt-5">
    <h1>Customer Details</h1>
    
    @if($customer)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $customer->username }}</h5>
                <p class="card-text">Email: {{ $customer->email }}</p>
                <p class="card-text">Phone: {{ $customer->phone }}</p>
                <p class="card-text">Address: {{ $customer->address }}</p>
                <p class="card-text">Total Orders: {{ $customer->ordered_products }}</p>
                <a href="http://127.0.0.1:8000/admin/dashboard" class="btn btn-primary">Back to Dashboard</a>
            </div>
        </div>
    @else
        <p>Customer not found.</p>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>