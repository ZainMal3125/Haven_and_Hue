@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Orders Management</h1>
    </div>

    @if($orders->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered bg-white shadow-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th>Order #</th>
                    <th>Buyer</th>
                    <th>Date</th>
                    <th>My Items Ordered</th>
                    <th>Total Order Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                    <td>
                        <ul class="mb-0 ps-3">
                            @foreach($order->items as $item)
                                <li>{{ $item->product ? $item->product->name : 'Product Removed' }} (x{{ $item->quantity }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>${{ $order->total_amount }}</td>
                    <td>
                        @php
                        $statusClass = 'warning';
                        if ($order->status === 'delivered') $statusClass = 'success';
                        elseif ($order->status === 'cancelled') $statusClass = 'danger';
                        elseif ($order->status === 'confirmed') $statusClass = 'info';
                        @endphp
                        <span class="badge bg-{{ $statusClass }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        @if($order->status === 'pending')
                            <form action="{{ route('seller.orders.confirm', $order) }}" method="POST" onsubmit="return confirm('Confirm this order?');" class="mb-0">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Confirm Order</button>
                            </form>
                        @else
                            <span class="text-muted small">Confirmed</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
    @else
    <p>No orders containing your products have been placed yet.</p>
    @endif
</div>
@endsection
