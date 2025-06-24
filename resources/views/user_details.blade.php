<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>

<body>

<div class="container mt-5">
    <h1>User Details</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $user->id }}</p>
            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone:</strong> {{ $user->phone }}</p>
            <p><strong>Address:</strong> {{ $user->address }}</p>
            <p><strong>Password:</strong> {{ $user->password }}</p>
            <p><strong>Confirm Password:</strong> {{ $user->confirmpassword }}</p>
            <p><strong>Ordered Products:</strong> {{ $user->ordered_products }}</p>
            <p><strong>Canceled Products:</strong> {{ $user->canceled_products }}</p>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Back to Manage Users</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
