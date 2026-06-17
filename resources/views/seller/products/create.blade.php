@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Add New Product</h1>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price ($)</label>
                        <input type="number" name="price" step="0.01" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stock Quantity</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Material Type</label>
                        <input type="text" name="material_type" class="form-control" placeholder="e.g. Teak Wood">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dimensions</label>
                        <input type="text" name="dimensions" class="form-control" placeholder="e.g. 10x10x5 inches">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Images (Multiple)</label>
                    <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary-custom">Create Product</button>
            </form>
        </div>
    </div>
</div>
@endsection
