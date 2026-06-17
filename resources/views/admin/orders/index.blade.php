@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Orders Management (Admin)</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">Back to Dashboard</a>
    </div>

    @if($orders->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered bg-white shadow-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th>Order #</th>
                    <th>Buyer</th>
                    <th>Shipping Address</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><strong>{{ $order->order_number }}</strong></td>
                    <td>
                        {{ $order->user->name }}<br>
                        <small class="text-muted">{{ $order->user->email }}</small>
                    </td>
                    <td>{{ $order->shipping_address }}</td>
                    <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                    <td>
                        @php
                        $statusClass = 'warning';
                        if ($order->status === 'delivered') $statusClass = 'success';
                        elseif ($order->status === 'cancelled') $statusClass = 'danger';
                        elseif ($order->status === 'confirmed') $statusClass = 'info';
                        elseif ($order->status === 'processing') $statusClass = 'primary';
                        elseif ($order->status === 'shipped') $statusClass = 'secondary';
                        @endphp
                        <span class="badge bg-{{ $statusClass }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        @if($order->status === 'pending')
                            <span class="badge bg-light text-dark border"><i class="bi bi-hourglass-split"></i> Waiting for Seller</span>
                        @else
                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="d-flex gap-2 align-items-center">
                                @csrf
                                <select name="status" class="form-select form-select-sm" style="width: auto;">
                                    <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }} disabled>Confirmed</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary-custom">Update</button>
                            </form>
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
    <div class="alert alert-info">No orders have been placed in the system yet.</div>
    @endif
</div>
@endsection
