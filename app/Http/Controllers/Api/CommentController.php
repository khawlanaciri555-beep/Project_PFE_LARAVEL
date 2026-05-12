<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of comments for a specific place.
     */
    public function index($placeId)
    {
        $query = Comment::with('user');
        
        if ($placeId === 'general') {
            $query->whereNull('place_id');
        } else {
            $query->where('place_id', $placeId);
        }

        $comments = $query->latest()->get();

        return response()->json([
            'data' => $comments
        ]);
    }

    /**
     * Display a listing of latest testimonials for the home page.
     */
    public function testimonials()
    {
        $comments = Comment::with(['user', 'place', 'transport', 'cooperative', 'hotel'])
            ->latest()
            ->take(6)
            ->get();

        return response()->json([
            'data' => $comments
        ]);
    }

    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'place_id' => 'nullable|exists:places,id',
            'cooperative_id' => 'nullable|exists:cooperatives,id',
            'transport_id' => 'nullable|exists:transports,id',
            'hotel_id' => 'nullable|exists:hotels,id',
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'place_id' => $validated['place_id'] ?? null,
            'cooperative_id' => $validated['cooperative_id'] ?? null,
            'transport_id' => $validated['transport_id'] ?? null,
            'hotel_id' => $validated['hotel_id'] ?? null,
            'content' => $validated['content'],
        ]);

        return response()->json([
            'message' => 'Comment posted successfully',
            'data' => $comment->load(['user', 'place', 'cooperative', 'transport', 'hotel']),
        ], 201);
    }
}
