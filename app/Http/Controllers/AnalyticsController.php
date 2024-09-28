<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\OrderItems;
use App\Models\Products;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    public function index()
    {
        $user = Auth::user();


        if ($user->type === 'admin') {

            $totalProducts = Products::count();
            $mostSoldProduct = Products::withCount('orderItems')
                ->orderBy('order_items_count', 'desc')
                ->first();
            $totalUsers = User::count();
            $highestRatedProduct = Products::withAvg('reviews', 'rating')
                ->orderBy('reviews_avg_rating', 'desc')
                ->first();


            return view('admin.dashboard.analytics', [
                'totalProducts' => $totalProducts,
                'mostSoldProduct' => $mostSoldProduct,
                'totalUsers' => $totalUsers,
                'highestRatedProduct' => $highestRatedProduct,
            ]);


        } elseif ($user->type === 'seller') {

            $sellerProducts = Products::where('published_by', $user->id)->get();


            $mostSoldSellerProduct = Products::where('published_by', $user->id)
                ->withCount('orderItems') // Ensure 'orderItems' relation exists
                ->orderBy('order_items_count', 'desc')
                ->first();


            $highestRatedSellerProduct = Products::where('published_by', $user->id)
                ->withAvg('reviews', 'rating') // Ensure 'reviews' relation exists
                ->orderBy('reviews_avg_rating', 'desc')
                ->first();


            $sellerOrders = OrderItems::whereHas('product', function ($query) use ($user) {
                $query->where('published_by', $user->id);
            })->count();

            return view('admin.dashboard.analytics', [
                'mostSoldProduct' => $mostSoldSellerProduct,
                'highestRatedProduct' => $highestRatedSellerProduct,
                'sellerOrders' => $sellerOrders,
            ]);
        }


        return redirect()->route('home');
    }
}
