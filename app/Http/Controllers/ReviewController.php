<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::where('media_type', 'text')
            ->orderBy('sort_order')
            ->latest()
            ->paginate(10);

        return view('dashboard.reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('dashboard.reviews.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateReview($request);
        $validated['media_path'] = '';
        $validated['media_type'] = 'text';
        $validated['poster_path'] = null;
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['rating'] = $validated['rating'] ?? 5;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Review::create($validated);

        return redirect()->route('reviews.index')->with('success', 'Review added successfully.');
    }

    public function edit(Review $review)
    {
        return view('dashboard.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $validated = $this->validateReview($request);
        $validated['media_path'] = $review->media_path ?: '';
        $validated['media_type'] = 'text';
        $validated['poster_path'] = null;
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['rating'] = $validated['rating'] ?? 5;
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $review->update($validated);

        return redirect()->route('reviews.index')->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('reviews.index')->with('success', 'Review deleted successfully.');
    }

    protected function validateReview(Request $request): array
    {
        return $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'badge' => ['nullable', 'string', 'max:80'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'review_text' => ['required', 'string', 'max:1200'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
