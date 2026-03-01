<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $total = $carts->sum(fn($cart) => $cart->product->price * $cart->quantity);

        return view('customer.cart', compact('carts', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->quantity > $product->stock) {
            return back()->with('error', 'Not enough stock! Only ' . $product->stock . ' left.');
        }

        // Check if product already in cart
        $cart = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cart) {
            $newQuantity = $cart->quantity + $request->quantity;
            if ($newQuantity > $product->stock) {
                return back()->with('error', 'Not enough stock!');
            }
            $cart->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        if ($request->quantity > $cart->product->stock) {
            return back()->with('error', 'Not enough stock! Only ' . $cart->product->stock . ' left.');
        }

        $cart->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Cart updated!');
    }

    public function remove(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }
        $cart->delete();
        return back()->with('success', 'Item removed from cart!');
    }

    public function checkout()
    {
        $carts = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        foreach ($carts as $cart) {
            if ($cart->quantity > $cart->product->stock) {
                return redirect()->route('cart.index')
                    ->with('error', $cart->product->name . ' only has ' . $cart->product->stock . ' left!');
            }
        }

        foreach ($carts as $cart) {
            Order::create([
                'user_id' => auth()->id(),
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'total_price' => $cart->product->price * $cart->quantity,
                'status' => 'pending',
            ]);

            $cart->product->update([
                'stock' => $cart->product->stock - $cart->quantity
            ]);
        }

        // Clear cart after checkout
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('customer.orders')->with('success', 'Order placed successfully!');
    }
}