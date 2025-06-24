<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<style>
.content{
    padding-top: 50px; 
}
    </style>
<body>
    @include('navbar_admin')
    <div class="content">

    <h1 class="text-center mt-5">Confirmed Deliveries</h1>
    <div class="text-center">
            <a href="{{ route('order-status') }}" class="btn btn-primary mt-3">Go to Order Status</a>
        </div>
    <div class="container mt-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Delivered On</th>
                    <th>Username</th>
                    <th>Total Amount</th>
                    <th>Courier Service</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deliveries as $delivery)
                    <tr>
                        <td>{{ $delivery->id }}</td>
                        <td>{{ $delivery->delivered_on }}</td>
                        <td>{{ $delivery->username }}</td>
                        <td>{{ $delivery->total_amount }}</td>
                        <td>{{ $delivery->courier_service }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Button to redirect to Order Status page -->
        
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
