<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        /* Ensure content starts below navbar */
        .content {
            margin-top: 100px; /* Adjust for the height of your navbar */
        }
        .order-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            position: relative;
        }
        .order-details {
            width: 100%; 
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .product {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            width: 100%;
        }
        .product img {
            width: 80px;
            height: auto;
            margin-right: 15px;
            flex-shrink: 0;
        }
        .product-info {
            flex-grow: 1;
            text-align: center;
        }
        .order-actions {
            position: relative;
            text-align: center;
            margin-left: 15px;
        }
        h1 {
            text-align: center;
            margin-top: 100px; /* Ensure the heading is below the navbar */
        }
    </style>
</head>
<body>
    @include('navbar') <!-- Include your navigation bar -->

    <div class="container mt-5 content">
        <h1 class="text-center" style="margin-top:100px">My Orders</h1>

        @if (session('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success_message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @foreach ($ordersCategorized as $category => $orders)
            @if (count($orders) > 0)
                <h3>{{ $category }}</h3>
                @foreach ($orders as $order)
                    <div class="order-item">
                        <div class="order-details">
                            @foreach ($order as $product)
                                <div class="product">
                                    <!-- Change image path to fetch from localhost/xampp/htdocs -->
                                    <img src="http://localhost:8080/FULLSTACK/uploads/{{ $product->product_image }}" alt="{{ $product->product_name }}">
                                    <div class="product-info">
                                        <h6 class="m-0">{{ $product->product_name }}</h6>
                                        <p>Quantity: {{ $product->quantity }}</p>
                                        <p>Price: ₹{{ $product->rate }}</p>
                                        <p>Total: ₹{{ $product->quantity * $product->rate }}</p>
                                    </div>

                                    <div class="order-actions">
                                        @if (strtolower($order[0]->delivered_status) == 'delivered')
                                            <button class="btn btn-success btn-sm" disabled>
                                                <i class="fas fa-check-circle"></i> Delivered
                                            </button>
                                        @else
                                            <form method="POST" action="{{ route('orders.cancel') }}" style="display:inline;">
                                                @csrf
                                                <input type="hidden" name="order_product_id" value="{{ $product->order_product_id }}">
                                                <input type="hidden" name="order_id" value="{{ $order[0]->order_id }}">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Cancel Product
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            <hr>
                            <p><strong>Total Amount: ₹{{ $order[0]->total_amount }}</strong></p>
                            <p>Delivery Status: {{ $order[0]->delivered_status }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        @endforeach

        @if (empty($ordersCategorized['Today']) && empty($ordersCategorized['Yesterday']) && empty($ordersCategorized['Older']))
            <p>You have no orders.</p>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
