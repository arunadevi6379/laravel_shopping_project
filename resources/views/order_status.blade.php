<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Status</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<style>
.content{
    padding-top: 50px; 
}
    </style>
<body>
    @include('navbar_admin')  <!-- Include your navbar here -->
<div class="content">
    <div class="container mt-5">
        <h2 class="text-center">Order Status</h2>

        <!-- Display success message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Display error message -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Orders table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Username</th>
                    <th>Total Amount</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Courier Service</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <form action="{{ route('order-status.confirm') }}" method="POST">
                            @csrf
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->username }}</td>
                            <td>{{ $order->total_amount }}</td>
                            <td>{{ $order->address }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>
                                <select name="courier_service" class="form-select">
                                    <option value="E-commerce" {{ old('courier_service') == 'E-commerce' ? 'selected' : '' }}>E-commerce</option>
                                    <option value="Post Service" {{ old('courier_service') == 'Post Service' ? 'selected' : '' }}>Post Service</option>
                                    <option value="Courier Boy" {{ old('courier_service') == 'Courier Boy' ? 'selected' : '' }}>Courier Boy</option>
                                </select>
                                @error('courier_service')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                <button type="submit" class="btn btn-success">Confirm Delivery</button>
                            </td>
                        </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
