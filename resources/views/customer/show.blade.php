@extends('layouts.app')

@section('content')
<div class="page-header">
    <h2><i class="fas fa-shopping-cart me-2 text-primary"></i>Product Details</h2>
    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-5 mb-4">
                <div class="card h-100">
                    <div class="product-img" style="height:220px">
                        <i class="fas fa-box-open text-primary" style="font-size:5rem;opacity:0.3"></i>
                    </div>
                    <div class="card-body">
                        <span class="badge-category mb-2 d-inline-block">{{ $product->category->name }}</span>
                        <h4 class="fw-bold">{{ $product->name }}</h4>
                        <p class="text-muted">{{ $product->description }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="product-price">${{ number_format($product->price, 2) }}</span>
                            @if($product->stock == 0)
                                <span class="badge bg-danger">Out of Stock</span>
                            @elseif($product->stock <= 5)
                                <span class="badge bg-warning text-dark">Only {{ $product->stock }} left!</span>
                            @else
                                <span class="badge bg-success">{{ $product->stock }} in stock</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 mb-4">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4"><i class="fas fa-clipboard-list me-2 text-primary"></i>Order Details</h5>

                        {{-- Add to Cart Form --}}
                        <form action="{{ route('cart.add') }}" method="POST" class="mb-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="quantity" class="form-control" min="1" max="{{ $product->stock }}" value="1" required>
                                <small class="text-muted">Max: {{ $product->stock }} items</small>
                            </div>
                            <button type="submit" class="btn btn-outline-primary w-100 mb-2">
                                <i class="fas fa-cart-plus me-2"></i>Add to Cart
                            </button>
                        </form>

                        {{-- Direct Order Form --}}
                        <form action="{{ route('customer.order') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <div class="card bg-light mb-3">
                                <div class="card-body py-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Price per item</span>
                                        <strong>${{ number_format($product->price, 2) }}</strong>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-bold">Total</span>
                                        <strong class="text-primary" id="total">${{ number_format($product->price, 2) }}</strong>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fas fa-check-circle me-2"></i>Buy Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const price = {{ $product->price }};
    document.querySelector('[name="quantity"]').addEventListener('input', function() {
        const total = (this.value * price).toFixed(2);
        document.getElementById('total').textContent = '$' + total;
    });
</script>
@endsection