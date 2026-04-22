<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Hotel::with('user')->where('is_deleted', false);
        
        // If owner filter is provided or if we want to show only owned hotels in specific contexts
        if ($request->has('owner_id')) {
            $query->where('user_id', $request->owner_id);
        }

        $hotels = $query->get();
        return \App\Http\Resources\HotelResource::collection($hotels);
    }

    /**
     * Return hospitals owned by the authenticated user.
     */
    public function myHotels(Request $request)
    {
        $hotels = \App\Models\Hotel::where('user_id', $request->user()->id)
            ->where('is_deleted', false)
            ->get();
        return \App\Http\Resources\HotelResource::collection($hotels);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:hotel,resort,apartment,villa,riad,other',
            'phone' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'image' => 'required|string',
            'price' => 'required|integer',
            'description' => 'required|string',
        ]);

        // Automatically assign to authenticated user
        $validated['user_id'] = $request->user()->id;

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
        // Security: Check if user owns this hotel
        if ($hotel->user_id !== $request->user()->id && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized access to this hotel'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string',
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

    public function destroy(Request $request, \App\Models\Hotel $hotel)
    {
        // Security: Check if user owns this hotel
        if ($hotel->user_id !== $request->user()->id && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized access'], 403);
        }

        $hotel->update(['is_deleted' => true]);
        return response()->json(['message' => 'Hotel soft-deleted successfully']);
    }
}
