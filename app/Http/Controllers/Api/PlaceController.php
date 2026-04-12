<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $places = \App\Models\Place::where('is_deleted', false)->get();
        return \App\Http\Resources\PlaceResource::collection($places);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'image' => 'required|string',
            'description' => 'required|string',
            'category' => 'nullable|string',
            'coordinates' => 'nullable|string',
        ]);

        $place = \App\Models\Place::create($validated);
        return new \App\Http\Resources\PlaceResource($place);
    }

    public function show(\App\Models\Place $place)
    {
        if ($place->is_deleted) return response()->json(['message' => 'Place not found'], 404);
        return new \App\Http\Resources\PlaceResource($place);
    }

    public function update(Request $request, \App\Models\Place $place)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'address' => 'sometimes|string',
            'image' => 'sometimes|string',
            'description' => 'sometimes|string',
            'category' => 'sometimes|string',
            'coordinates' => 'sometimes|string',
        ]);

        $place->update($validated);
        return new \App\Http\Resources\PlaceResource($place);
    }

    public function destroy(\App\Models\Place $place)
    {
        $place->update(['is_deleted' => true]);
        return response()->json(['message' => 'Place soft-deleted successfully']);
    }
}
