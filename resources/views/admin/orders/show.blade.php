@extends('layouts.app')

@section('content')
<h2>Order Details</h2>
<table class="table table-bordered">
    <tr><th>Order ID</th><td>{{ $order->id }}</td></tr>
    <tr><th>Customer</th><td>{{ $order->user->name }}</td></tr>
    <tr><th>Product</th><td>{{ $order->product->name }}</td></tr>
    <tr><th>Quantity</th><td>{{ $order->quantity }}</td></tr>
    <tr><th>Total Price</th><td>${{ $order->total_price }}</td></tr>
    <tr><th>Status</th><td>{{ $order->status }}</td></tr>
</table>
<a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back</a>
@endsection