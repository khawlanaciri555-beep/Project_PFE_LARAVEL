<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = \App\Models\Hotel::with('user')->where('is_deleted', false)->get();
        return \App\Http\Resources\HotelResource::collection($hotels);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:hotel,resort,apartment,villa,riad,other',
            'phone' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'image' => 'required|string',
            'price' => 'required|integer',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $hotel = \App\Models\Hotel::create($validated);
        return new \App\Http\Resources\HotelResource($hotel);
    }

    public function show(\App\Models\Hotel $hotel)
    {
        if ($hotel->is_deleted) return response()->json(['message' => 'Hotel not found'], 404);
        return new \App\Http\Resources\HotelResource($hotel);
    }

    public function update(Request $request, \App\Models\Hotel $hotel)
    {
        $validated = $request->validate([
            'type' => 'sometimes|in:hotel,resort,apartment,villa,riad,other',
            'phone' => 'sometimes|string',
            'email' => 'sometimes|email',
            'address' => 'sometimes|string',
            'image' => 'sometimes|string',
            'price' => 'sometimes|integer',
            'description' => 'sometimes|string',
            'availability' => 'sometimes|boolean',
        ]);

        $hotel->update($validated);
        return new \App\Http\Resources\HotelResource($hotel);
    }

    public function destroy(\App\Models\Hotel $hotel)
    {
        $hotel->update(['is_deleted' => true]);
        return response()->json(['message' => 'Hotel soft-deleted successfully']);
    }
}
