@extends('layouts.app')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-shopping-cart me-2 text-primary"></i>My Cart</h2>
    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
    </a>
</div>

@if($carts->count() > 0)
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($carts as $cart)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $cart->product->name }}</div>
                                <small class="text-muted">{{ $cart->product->category->name }}</small>
                            </td>
                            <td><strong class="text-primary">${{ number_format($cart->product->price, 2) }}</strong></td>
                            <td style="width:150px">
                                <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="quantity" class="form-control" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->stock }}" onchange="this.form.submit()">
                                    </div>
                                </form>
                            </td>
                            <td><strong>${{ number_format($cart->product->price * $cart->quantity, 2) }}</strong></td>
                            <td>
                                <form action="{{ route('cart.remove', $cart->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Remove item?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><i class="fas fa-receipt me-2 text-primary"></i>Order Summary</h5>
                @foreach($carts as $cart)
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">{{ $cart->product->name }} x{{ $cart->quantity }}</span>
                    <span>${{ number_format($cart->product->price * $cart->quantity, 2) }}</span>
                </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between mb-4">
                    <span class="fw-bold">Total</span>
                    <strong class="text-primary fs-5">${{ number_format($total, 2) }}</strong>
                </div>
                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 py-2" onclick="return confirm('Place order for all items?')">
                        <i class="fas fa-check-circle me-2"></i>Checkout ({{ $carts->count() }} items)
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@else
<div class="text-center py-5">
    <i class="fas fa-shopping-cart fa-4x text-muted mb-3 d-block"></i>
    <h4 class="text-muted">Your cart is empty!</h4>
    <a href="{{ route('home') }}" class="btn btn-primary mt-3">
        <i class="fas fa-store me-2"></i>Start Shopping
    </a>
</div>
@endif
@endsection