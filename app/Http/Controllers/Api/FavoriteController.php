<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favorites = \App\Models\Favorite::with('place')->where('user_id', auth()->id())->get();
        return \App\Http\Resources\FavoriteResource::collection($favorites);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'place_id' => 'required|exists:places,id',
        ]);

        $favorite = \App\Models\Favorite::firstOrCreate([
            'user_id' => auth()->id() ?? $request->user_id,
            'place_id' => $validated['place_id'],
        ]);

        return new \App\Http\Resources\FavoriteResource($favorite);
    }

    public function destroy(\App\Models\Favorite $favorite)
    {
        $favorite->delete();
        return response()->json(['message' => 'Favorite removed']);
    }
}
