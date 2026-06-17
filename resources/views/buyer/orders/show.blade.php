@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Order #{{ $order->order_number }}</h1>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Back to Orders</a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Shipping To:</h5>
                    @php $addr = json_decode($order->shipping_address, true); @endphp
                    <p>
                        {{ Auth::user()->name }}<br>
                        {{ $addr['address'] ?? '' }}<br>
                        {{ $addr['city'] ?? '' }}, {{ $addr['state'] ?? '' }} {{ $addr['zip'] ?? '' }}<br>
                        {{ $addr['country'] ?? '' }}
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                    <p><strong>Total Amount:</strong> <span class="text-accent fs-4 fw-bold">${{ $order->total_amount }}</span></p>
                </div>
            </div>
            
            <hr>
            
            <h5>Items</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product ? $item->product->name : 'Product Removed' }}</td>
                            <td>${{ $item->price }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ $item->price * $item->quantity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
