<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    public function index()
    {
       $reviews = Review::with('user')->latest()->paginate(9);
       $averageRating = Review::avg('rating');
       $totalReviews = Review::count();
      return view('components.front.reviews.index', compact('reviews', 'averageRating', 'totalReviews'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
            'occasion_type' => 'nullable|string',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'occasion_type' => $request->occasion_type,
            'show_on_home' => true, 
        ]);

        return back()->with('success', 'شكراً لك! تم إرسال تقييمك بنجاح.');
    }
}