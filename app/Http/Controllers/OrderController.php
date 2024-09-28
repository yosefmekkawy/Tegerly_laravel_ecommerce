<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\OrderItems;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show($id)
    {

        $order = Orders::with('items.product')->where('id', $id)->where('ordered_by', Auth::id())->firstOrFail();


        $total = 0;
        foreach ($order->items as $item) {
            $total += $item->quantity * $item->price;
        }
        $order=OrderResource::make($order)->resolve();


        return view('orders.show', compact('order', 'total'));
    }
    public function index()
    {
        $user = Auth::user();

        if ($user->type === 'client') {

            $orders = Orders::where('ordered_by', $user->id)->with('items.product')->paginate(10);
        } elseif ($user->type === 'seller') {

            $orders = Orders::whereHas('items.product', function($query) use ($user) {
                $query->where('published_by', $user->id);
            })->with('items.product')->paginate(10);
        } elseif ($user->type === 'admin') {

            $orders = Orders::with('items.product')->paginate(10);
        }
        $ordersArr=OrderResource::collection($orders)->resolve();

        return view('orders.index', compact('orders', 'ordersArr'));
    }


    public function checkout()
    {

        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();


        $total = 0;
        if ($cart) {
            foreach ($cart->items as $item) {
                $total += $item->quantity * $item->product->price;
            }
        }
        $cart=CartResource::make($cart)->resolve();


        return view('orders.checkout', compact('cart', 'total'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'address' => 'required|string|max:255',
        ]);


        $cart = Cart::with('items.product')->where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }


        $order = Orders::create([
            'address' => $request->address,
            'ordered_by' => Auth::id(),
            'status' => 'pending',
        ]);


        foreach ($cart->items as $item) {
            OrderItems::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }


        $cart->items()->delete();


        return redirect()->to('/')->with('success', 'Order placed successfully!');
    }
}
