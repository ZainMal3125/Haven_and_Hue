@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Checkout</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">Shipping Information</div>
                <div class="card-body">
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Address Line</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Zip Code</label>
                                <input type="text" name="zip" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone }}" required>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">Order Summary</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush mb-3">
                        @foreach($cartItems as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            {{ $item->product->name }} (x{{ $item->quantity }})
                            <span>${{ $item->product->price * $item->quantity }}</span>
                        </li>
                        @endforeach
                    </ul>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold text-accent">${{ $total }}</span>
                    </div>
                    <button type="submit" form="checkout-form" class="btn btn-primary-custom w-100">Place Order (Simulate)</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
