<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'place_id' => 'required|exists:places,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $rating = Rating::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'place_id' => $validated['place_id'],
            ],
            [
                'rating' => $validated['rating'],
            ]
        );

        return response()->json([
            'message' => 'Rating saved successfully',
            'rating' => $rating,
        ]);
    }
}
