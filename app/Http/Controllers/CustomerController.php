<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::with('category');

        // Search
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(8);

        return view('customer.home', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('customer.show', compact('product'));
    }

    public function order(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->quantity > $product->stock) {
            return back()->with('error', 'Not enough stock! Only ' . $product->stock . ' left.');
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' => $product->price * $request->quantity,
            'status' => 'pending',
        ]);

        $product->update(['stock' => $product->stock - $request->quantity]);

        return redirect()->route('customer.order.confirmation', $order->id);
    }

    public function myOrders()
    {
        $orders = Order::with('product')
            ->where('user_id', auth()->id())
            ->get();
        return view('customer.orders', compact('orders'));
    }

    public function confirmation(Order $order)
    {
        return view('customer.confirmation', compact('order'));
    }

    public function cancelOrder(Order $order)
    {
        // Make sure customer can only cancel their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Only pending orders can be cancelled
        if ($order->status !== 'pending') {
            return redirect()->route('customer.orders')->with('error', 'Only pending orders can be cancelled!');
        }

        // Restore stock
        $order->product->update([
            'stock' => $order->product->stock + $order->quantity
        ]);

        $order->update(['status' => 'cancelled']);

        return redirect()->route('customer.orders')->with('success', 'Order cancelled successfully!');
    }
}
