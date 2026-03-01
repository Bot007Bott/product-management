@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <div
                            style="width:80px;height:80px;background:linear-gradient(135deg,#10b981,#059669);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                            <i class="fas fa-check text-white" style="font-size:2rem"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-success mb-2">Order Placed Successfully!</h3>
                    <p class="text-muted mb-4">Thank you for your order. We'll process it shortly.</p>

                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3 text-start">Order Summary</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Order ID</span>
                                <strong>#{{ $order->id }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Product</span>
                                <strong>{{ $order->product->name }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Quantity</span>
                                <strong>x{{ $order->quantity }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Price each</span>
                                <strong>${{ number_format($order->product->price, 2) }}</strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">Total Paid</span>
                                <strong class="text-primary fs-5">${{ number_format($order->total_price, 2) }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-2 px-2">
                        <span class="text-muted">Status</span>
                        <span class="badge bg-warning text-dark px-3 py-2">
                            <i class="fas fa-clock me-1"></i>Pending
                        </span>
                    </div>
                    <div class="d-flex justify-content-between px-2">
                        <span class="text-muted">Date</span>
                        <strong>{{ $order->created_at->format('M d, Y h:i A') }}</strong>
                    </div>

                    <div class="d-flex gap-3 mt-4">
                        <a href="{{ route('customer.orders') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-box me-2"></i>My Orders
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-primary w-100">
                            <i class="fas fa-store me-2"></i>Keep Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
