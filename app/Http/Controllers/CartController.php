<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        $total=0;
        $cart = Cart::with('items.product.images')->where('user_id', Auth::id())->first();

        if ($cart) {

            foreach ($cart->items as $item) {
                $total += $item->quantity * $item->product->price;
            }
        }

        $cart= CartResource::make($cart)->resolve();
        return view('cart.index', compact('total'))->with(['cart'=>$cart]);
    }

    // Add item to cart
    public function add(Request $request, $productId)
    {
        $product = Products::findOrFail($productId);
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {

            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {

            $cart->items()->create([
                'product_id' => $productId,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Item added to cart!');
    }


    public function remove($itemId)
    {
        $cartItem = CartItems::findOrFail($itemId);

        if ($cartItem->cart->user_id == Auth::id()) {
            $cartItem->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }


    public function update(Request $request)
    {

        foreach ($request->quantities as $itemId => $quantity) {
            $cartItem = CartItems::find($itemId);
            if ($cartItem) {
                $cartItem->quantity = $quantity;
                $cartItem->save();
            }
        }


        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }



    public function clear()
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }
}
