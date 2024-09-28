<?php

namespace App\Http\Controllers;

use App\Models\OrderItems;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function store(Request $request)
    {

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|in:1,2,3,4,5',
            'review_message' => 'nullable|string|max:1000',
        ]);


        $hasOrderedProduct = OrderItems::whereHas('order', function($query) {
            $query->where('ordered_by', Auth::id())->where('status', 'delivered');
        })->where('product_id', $validated['product_id'])->exists();

        if (!$hasOrderedProduct) {
            return redirect()->back()->with('error', 'You cannot review a product you haven\'t ordered or received yet.');
        }

  
        Reviews::create([
            'user_id' => Auth::id(),
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'review_message' => $validated['review_message'],
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }

    // display all reviews for admin
    public function index()
    {
        $reviews = Reviews::with('user', 'product')->paginate(10);
        return view('reviews.index', compact('reviews'));
    }


    public function show($id)
    {
        $review = Reviews::with('user', 'product')->findOrFail($id);
        return view('reviews.show', compact('review'));
    }


}
