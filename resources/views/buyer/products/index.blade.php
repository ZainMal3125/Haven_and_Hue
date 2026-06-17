@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">{{ $category->name }}</h1>
    <p class="text-center text-muted mb-5">{{ $category->description }}</p>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach($products as $product)
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <img src="{{ $product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : 'https://placehold.co/300x300?text=No+Image' }}" class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit($product->description, 50) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fs-5 fw-bold text-accent">${{ $product->price }}</span>
                        <a href="{{ route('product.show', $product) }}" class="btn btn-sm btn-outline-secondary">View</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
