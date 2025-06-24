<div class="order-item">
<img src="http://localhost:8080/FULLSTACK/uploads/{{ $item->product_image }}" alt="{{ $item->product_name }}">

    <div class="order-details">
        <h5 class="m-0">{{ $item->product_name }}</h5>
        <p class="mb-1">Quantity: {{ $item->quantity }}</p>
    </div>
    <div class="order-actions">
        <p class="canceled-date">• Canceled on: {{ \Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</p>
 </div>
</div>