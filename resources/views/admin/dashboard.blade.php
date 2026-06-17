@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3 h-100" style="background-color: #8B7355 !important;">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text display-6">{{ $stats['users'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3 h-100" style="background-color: #A68B6C !important;">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text display-6">{{ $stats['products'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3 h-100" style="background-color: #D2B48C !important;">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text display-6">{{ $stats['orders'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3 h-100" style="background-color: #E5BA73 !important;">
                <div class="card-body">
                    <h5 class="card-title">Revenue</h5>
                    <p class="card-text display-6">${{ number_format($stats['revenue'], 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">Quick Links</div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action">Manage Users</a>
                    <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action">Manage Products</a>
                    <a href="{{ route('admin.orders.index') }}" class="list-group-item list-group-item-action">View All Orders</a>
                    <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action">Manage Categories</a>
                </div>
            </div>
        </div>
        <!-- Add more widgets/charts here -->
    </div>
</div>
@endsection
