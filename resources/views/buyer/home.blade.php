@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="jumbotron p-5 mb-4 bg-light rounded-3 text-center" style="background-color: #DBD0C0 !important;">
    <div class="container py-5">
        <h1 class="display-4 fw-bold text-white">Welcome to Haven&Hue</h1>
        <p class="col-md-8 fs-4 mx-auto text-white">Handcrafted wooden home decor for your sanctuary. Discover unique pieces that bring warmth and elegance to your space.</p>
        <a href="#featured" class="btn btn-lg btn-light mt-3 text-accent fw-bold shadow-sm">Shop Now</a>
    </div>
</div>

<div class="container" id="featured">
    <!-- Featured Products -->
    <h2 class="text-center mb-4 display-6 text-accent">Featured Items</h2>
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach($featuredProducts as $product)
        <div class="col">
            <div class="card h-100 shadow-sm border-0">
                <img src="{{ $product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : 'https://placehold.co/300x300?text=No+Image' }}" class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title text-dark">{{ $product->name }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit($product->description, 50) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fs-5 fw-bold text-accent">${{ $product->price }}</span>
                        <a href="{{ route('product.show', $product) }}" class="btn btn-sm btn-outline-secondary">View Details</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Categories Section -->
    <h2 class="text-center my-5 display-6 text-accent">Browse by Category</h2>
    <div class="row row-cols-2 row-cols-md-4 g-4 mb-5">
        @foreach($categories as $category)
        <div class="col">
            <div class="card bg-secondary-custom text-center h-100 border-0 py-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-0">
                        <a href="{{ route('category.show', $category) }}" class="text-decoration-none text-dark fw-bold stretched-link">
                            {{ $category->name }}
                        </a>
                    </h5>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
