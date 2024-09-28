<?php

namespace App\Http\Middleware;

use App\Models\Orders;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckOrderCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $productId = $request->input('product_id'); // Assuming product ID is passed in the request

        // Check if the user has ordered this product and if the order status is 'completed' or 'delivered'
        $hasOrderedProduct = Orders::where('ordered_by', $user->id)
            ->whereHas('orderItems', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->where('status', 'completed') // Adjust status according to your implementation
            ->exists();

        if ($hasOrderedProduct) {
            return $next($request); // Allow to proceed if conditions are met
        }

        return redirect()->back()->with('error', 'You can only review products that you have ordered and are delivered.');
    }
}
