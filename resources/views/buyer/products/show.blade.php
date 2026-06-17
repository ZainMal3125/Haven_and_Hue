@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6 mb-4">
            @if($product->primaryImage)
                <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" class="img-fluid rounded shadow-sm mb-3 w-100" style="max-height: 500px; object-fit: cover;" alt="{{ $product->name }}">
            @else
                <img src="https://placehold.co/600x600?text=No+Image" class="img-fluid rounded shadow-sm mb-3 w-100" alt="{{ $product->name }}">
            @endif
            
            <div class="row row-cols-4 g-2">
                @foreach($product->images as $image)
                <div class="col">
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail" alt="{{ $product->name }}">
                </div>
                @endforeach
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h1 class="display-5 text-dark fw-bold">{{ $product->name }}</h1>
            <p class="text-muted fs-5">Category: <a href="{{ route('category.show', $product->category) }}" class="text-decoration-none text-accent">{{ $product->category->name }}</a></p>
            <h2 class="text-accent mb-4">${{ $product->price }}</h2>

            <p class="lead">{{ $product->description }}</p>

            <table class="table table-bordered mt-4">
                <tbody>
                    <tr>
                        <th class="bg-light">Material</th>
                        <td>{{ $product->material_type }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Dimensions</th>
                        <td>{{ $product->dimensions }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Stock</th>
                        <td>{{ $product->stock > 0 ? $product->stock . ' available' : 'Out of Stock' }}</td>
                    </tr>
                </tbody>
            </table>

            <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-4">
                @csrf
                <div class="input-group mb-3 w-50">
                    <span class="input-group-text">Qty</span>
                    <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}">
                </div>
                <button type="submit" class="btn btn-primary-custom btn-lg w-100 shadow-sm" {{ $product->stock == 0 ? 'disabled' : '' }}>
                    {{ $product->stock == 0 ? 'Out of Stock' : 'Add to Cart' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mt-5">
        <h3 class="mb-4 text-accent">Related Products</h3>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach($relatedProducts as $related)
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <img src="{{ $related->primaryImage ? asset('storage/' . $related->primaryImage->image_path) : 'https://placehold.co/300x300?text=No+Image' }}" class="card-img-top" alt="{{ $related->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h6 class="card-title">{{ $related->name }}</h6>
                        <p class="card-text text-accent fw-bold">${{ $related->price }}</p>
                        <a href="{{ route('product.show', $related) }}" class="btn btn-sm btn-outline-secondary stretched-link">View</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
