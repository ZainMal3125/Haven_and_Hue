@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Edit Product</h1>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('seller.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price ($)</label>
                        <input type="number" name="price" step="0.01" class="form-control" value="{{ $product->price }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stock Quantity</label>
                        <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ $product->description }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Material Type</label>
                        <input type="text" name="material_type" class="form-control" value="{{ $product->material_type }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dimensions</label>
                        <input type="text" name="dimensions" class="form-control" value="{{ $product->dimensions }}">
                    </div>
                </div>
                
                <div class="mb-3">
                     <p>Current Images:</p>
                     @foreach($product->images as $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" width="80" class="img-thumbnail me-2">
                     @endforeach
                </div>

                <button type="submit" class="btn btn-primary-custom">Update Product</button>
            </form>
        </div>
    </div>
</div>
@endsection
