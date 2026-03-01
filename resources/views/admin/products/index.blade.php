@extends('layouts.app')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-box-open me-2 text-primary"></i>Products</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add Product
    </a>
</div>

{{-- Stat Cards --}}
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #1a73e8, #0d47a1)">
            <i class="fas fa-box-open"></i>
            <h3>{{ $products->total() }}</h3>
            <p>Total Products</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #10b981, #059669)">
            <i class="fas fa-check-circle"></i>
            <h3>{{ $products->filter(fn($p) => $p->stock > 0)->count() }}</h3>
            <p>In Stock</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b, #d97706)">
            <i class="fas fa-exclamation-triangle"></i>
            <h3>{{ $products->filter(fn($p) => $p->stock == 0)->count() }}</h3>
            <p>Out of Stock</p>
        </div>
    </div>
</div>

{{-- Search & Filter --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.products.index') }}">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-primary"></i>
                        </span>
                        <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="sort_by" class="form-select">
                        <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Sort By</option>
                        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Price</option>
                        <option value="stock" {{ request('sort_by') == 'stock' ? 'selected' : '' }}>Stock</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="sort_order" class="form-select">
                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i>
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        <div class="fw-bold">{{ $product->name }}</div>
                        <small class="text-muted">{{ Str::limit($product->description, 40) }}</small>
                    </td>
                    <td><span class="badge-category">{{ $product->category->name }}</span></td>
                    <td><strong class="text-primary">${{ number_format($product->price, 2) }}</strong></td>
                    <td>
                        @if($product->stock == 0)
                            <span class="badge bg-danger">Out of Stock</span>
                        @elseif($product->stock <= 5)
                            <span class="badge bg-warning text-dark">Only {{ $product->stock }} left</span>
                        @else
                            <span class="badge bg-success">{{ $product->stock }} left</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this product?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="fas fa-box-open fa-2x mb-2 d-block"></i>No products found!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-center mt-4">
    {{ $products->appends(request()->query())->links() }}
</div>
@endsection