@extends('layouts.app')

@section('content')
    <div class="hero">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name }}! 👋</h2>
                <p class="mb-0 opacity-75">Discover our latest products and great deals</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('customer.orders') }}" class="btn btn-light">
                    <i class="fas fa-box me-2"></i>My Orders
                </a>
            </div>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('home') }}">
                <div class="row g-3 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search text-primary"></i>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Search products..."
                                value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="category_id" class="form-select">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark mb-0">
            <i class="fas fa-store me-2 text-primary"></i>
            @if (request('search'))
                Results for "{{ request('search') }}"
            @elseif(request('category_id'))
                {{ $categories->find(request('category_id'))->name ?? 'Products' }}
            @else
                All Products
            @endif
            <span class="badge bg-primary ms-2">{{ $products->total() }}</span>
        </h4>
    </div>

    @if ($products->count() > 0)
        <div class="row">
            @foreach ($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card product-card h-100">
                        <div class="product-img">
                            <i class="fas fa-box-open text-primary" style="opacity:0.4"></i>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge-category">{{ $product->category->name }}</span>
                            </div>
                            <h6 class="fw-bold mb-1">{{ $product->name }}</h6>
                            <p class="text-muted small mb-2">{{ Str::limit($product->description, 60) }}</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="product-price">${{ number_format($product->price, 2) }}</span>
                                    @if ($product->stock == 0)
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @elseif($product->stock <= 5)
                                        <span class="badge bg-warning text-dark">Only {{ $product->stock }} left!</span>
                                    @else
                                        <span class="badge bg-success">In Stock</span>
                                    @endif
                                </div>
                                @if ($product->stock > 0)
                                    <a href="{{ route('customer.products.show', $product->id) }}"
                                        class="btn btn-primary w-100">
                                        <i class="fas fa-shopping-cart me-2"></i>Order Now
                                    </a>
                                @else
                                    <button class="btn btn-secondary w-100" disabled>Out of Stock</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-5 text-muted">
            <i class="fas fa-search fa-3x mb-3 d-block"></i>
            <h5>No products found!</h5>
            <a href="{{ route('home') }}" class="btn btn-primary mt-2">Clear filters</a>
        </div>
    @endif
@endsection
