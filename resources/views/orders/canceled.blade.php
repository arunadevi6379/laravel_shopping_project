<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canceled Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
        }

        .order-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .order-item img {
            width: 80px;
            height: auto;
            margin-right: 15px;
        }

        .order-details {
            flex-grow: 1;
            text-align: center;
        }

        .order-actions {
            text-align: right;
        }

        .canceled-date {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    @include('navbar') <!-- Include your navigation bar here -->

    <div class="container mt-5">
        <h1 class="text-center" style="margin-top: 80px;">My Canceled Orders</h1>
        @if(count($canceled_orders_by_date) > 0)
            @foreach ([$today => 'Today', $yesterday => 'Yesterday'] as $date => $label)
                @if(isset($canceled_orders_by_date[$date]))
                    <h3>{{ $label }}</h3>
                    @foreach ($canceled_orders_by_date[$date] as $item)
                        @include('orders.partials.order-item', ['item' => $item])
                    @endforeach
                @endif
            @endforeach

            @foreach ($canceled_orders_by_date as $date => $items)
                @if ($date !== $today && $date !== $yesterday)
                    <h3>{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</h3>
                    @foreach ($items as $item)
                        @include('orders.partials.order-item', ['item' => $item])
                    @endforeach
                @endif
            @endforeach
        @else
            <p>You have no canceled orders.</p>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
