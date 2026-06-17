@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>My Products</h1>
        <a href="{{ route('seller.products.create') }}" class="btn btn-primary-custom">Add New Product</a>
    </div>

    @if($products->count() > 0)
    <table class="table table-bordered bg-white shadow-sm">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                    <img src="{{ $product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : 'https://placehold.co/50x50' }}" width="50" height="50" class="img-thumbnail">
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>${{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    <!-- Add edit/delete links here -->
                    <form action="{{ route('seller.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->links() }}
    @else
        <p>You haven't added any products yet.</p>
    @endif
</div>
@endsection
