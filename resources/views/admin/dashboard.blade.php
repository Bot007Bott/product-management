@extends('layouts.app')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard</h2>
    <span class="text-muted">Welcome back, {{ auth()->user()->name }}! 👋</span>
</div>

{{-- Stat Cards Row 1 --}}
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #1a73e8, #0d47a1)">
            <i class="fas fa-box-open"></i>
            <h3>{{ $totalProducts }}</h3>
            <p>Total Products</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #8b5cf6, #6d28d9)">
            <i class="fas fa-tags"></i>
            <h3>{{ $totalCategories }}</h3>
            <p>Categories</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #10b981, #059669)">
            <i class="fas fa-dollar-sign"></i>
            <h3>${{ number_format($totalRevenue, 2) }}</h3>
            <p>Total Revenue</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b, #d97706)">
            <i class="fas fa-clock"></i>
            <h3>{{ $pendingOrders }}</h3>
            <p>Pending Orders</p>
        </div>
    </div>
</div>

{{-- Stat Cards Row 2 --}}
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #06b6d4, #0891b2)">
            <i class="fas fa-users"></i>
            <h3>{{ $totalCustomers }}</h3>
            <p>Total Customers</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #ef4444, #dc2626)">
            <i class="fas fa-times-circle"></i>
            <h3>{{ $outOfStock }}</h3>
            <p>Out of Stock</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #ec4899, #db2777)">
            <i class="fas fa-shopping-cart"></i>
            <h3>{{ $totalOrders }}</h3>
            <p>Total Orders</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #14b8a6, #0f766e)">
            <i class="fas fa-exclamation-triangle"></i>
            <h3>{{ $lowStockProducts->count() }}</h3>
            <p>Low Stock Items</p>
        </div>
    </div>
</div>

<div class="row">
    {{-- Recent Orders --}}
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-body p-0">
                <div class="p-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-3"><i class="fas fa-shopping-cart me-2 text-primary"></i>Recent Orders</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->product->name }}</td>
                            <td><strong class="text-primary">${{ number_format($order->total_price, 2) }}</strong></td>
                            <td>
                                @if($order->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($order->status == 'processing')
                                    <span class="badge bg-info">Processing</span>
                                @elseif($order->status == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($order->status == 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No orders yet!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Low Stock Warning --}}
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><i class="fas fa-exclamation-triangle me-2 text-warning"></i>Low Stock Alert</h5>
                @forelse($lowStockProducts as $product)
                <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded" style="background:#fff7ed">
                    <div>
                        <div class="fw-bold small">{{ $product->name }}</div>
                        <small class="text-muted">{{ $product->category->name }}</small>
                    </div>
                    <span class="badge bg-warning text-dark">{{ $product->stock }} left</span>
                </div>
                @empty
                <div class="text-center py-3 text-muted">
                    <i class="fas fa-check-circle text-success fa-2x mb-2 d-block"></i>
                    All products well stocked!
                </div>
                @endforelse

                @if($outOfStock > 0)
                <div class="alert alert-danger mt-3 mb-0 py-2">
                    <i class="fas fa-times-circle me-2"></i>
                    <strong>{{ $outOfStock }}</strong> product(s) out of stock!
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection