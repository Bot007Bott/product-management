@extends('layouts.app')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-box me-2 text-primary"></i>My Orders</h2>
    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b, #d97706)">
            <i class="fas fa-clock"></i>
            <h3>{{ $orders->where('status', 'pending')->count() }}</h3>
            <p>Pending</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #1a73e8, #0d47a1)">
            <i class="fas fa-spinner"></i>
            <h3>{{ $orders->where('status', 'processing')->count() }}</h3>
            <p>Processing</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #10b981, #059669)">
            <i class="fas fa-check-circle"></i>
            <h3>{{ $orders->where('status', 'completed')->count() }}</h3>
            <p>Completed</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #ef4444, #dc2626)">
            <i class="fas fa-times-circle"></i>
            <h3>{{ $orders->where('status', 'cancelled')->count() }}</h3>
            <p>Cancelled</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>
                        <div class="fw-bold">{{ $order->product->name }}</div>
                        <small class="text-muted">${{ number_format($order->product->price, 2) }} each</small>
                    </td>
                    <td><span class="badge bg-secondary">x{{ $order->quantity }}</span></td>
                    <td><strong class="text-primary">${{ number_format($order->total_price, 2) }}</strong></td>
                    <td>
                        @if($order->status == 'pending')
                            <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Pending</span>
                        @elseif($order->status == 'processing')
                            <span class="badge bg-info"><i class="fas fa-spinner me-1"></i>Processing</span>
                        @elseif($order->status == 'completed')
                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>Completed</span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Cancelled</span>
                        @endif
                    </td>
                    <td><small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small></td>
                    <td>
                        @if($order->status == 'pending')
                            <form action="{{ route('customer.order.cancel', $order->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Cancel this order?')">
                                    <i class="fas fa-times me-1"></i>Cancel
                                </button>
                            </form>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-box fa-3x mb-3 d-block"></i>
                        <h6>No orders yet!</h6>
                        <a href="{{ route('home') }}" class="btn btn-primary mt-2">Start Shopping</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection