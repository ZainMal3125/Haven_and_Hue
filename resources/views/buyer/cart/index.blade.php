@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Shopping Cart</h1>
    
    @if($cartItems->count() > 0)
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    @foreach($cartItems as $item)
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-2">
                            <img src="{{ $item->product->primaryImage ? asset('storage/' . $item->product->primaryImage->image_path) : 'https://placehold.co/150x150?text=No+Image' }}" class="img-fluid rounded" alt="{{ $item->product->name }}">
                        </div>
                        <div class="col-md-4">
                            <h5 class="mb-1"><a href="{{ route('product.show', $item->product) }}" class="text-dark text-decoration-none">{{ $item->product->name }}</a></h5>
                            <p class="text-muted small mb-0">Price: ${{ $item->product->price }}</p>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="form-control me-2 text-center" onchange="this.form.submit()">
                            </form>
                        </div>
                        <div class="col-md-2 text-end">
                            <span class="fw-bold">${{ $item->product->price * $item->quantity }}</span>
                        </div>
                        <div class="col-md-1 text-end">
                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">&times;</button>
                            </form>
                        </div>
                    </div>
                    @if(!$loop->last) <hr> @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">Order Summary</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal</span>
                        <span class="fw-bold">${{ $total }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fs-5 fw-bold">Total</span>
                        <span class="fs-5 fw-bold text-accent">${{ $total }}</span>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn btn-primary-custom w-100">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="alert alert-info py-5 text-center">
            <h3>Your cart is empty</h3>
            <a href="{{ route('home') }}" class="btn btn-outline-primary mt-3">Continue Shopping</a>
        </div>
    @endif
</div>
@endsection
