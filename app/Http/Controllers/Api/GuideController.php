<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guides = \App\Models\Guide::with('user')->where('is_deleted', false)->get();
        return \App\Http\Resources\GuideResource::collection($guides);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'language' => 'required|string|max:255',
            'experience' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|string',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $guide = \App\Models\Guide::create($validated);

        return new \App\Http\Resources\GuideResource($guide);
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Guide $guide)
    {
        if ($guide->is_deleted) {
            return response()->json(['message' => 'Guide not found'], 404);
        }
        return new \App\Http\Resources\GuideResource($guide);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\Guide $guide)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'language' => 'sometimes|string|max:255',
            'experience' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'image' => 'nullable|string',
            'description' => 'sometimes|string',
        ]);

        $guide->update($validated);

        return new \App\Http\Resources\GuideResource($guide);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Guide $guide)
    {
        $guide->update(['is_deleted' => true]);
        return response()->json(['message' => 'Guide soft-deleted successfully']);
    }
}
