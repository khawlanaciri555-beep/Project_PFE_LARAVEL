<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CooperativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cooperatives = \App\Models\Cooperative::with('user')->where('is_deleted', false)->get();
        return \App\Http\Resources\CooperativeResource::collection($cooperatives);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'image' => 'required|string',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $cooperative = \App\Models\Cooperative::create($validated);
        return new \App\Http\Resources\CooperativeResource($cooperative);
    }

    public function show(\App\Models\Cooperative $cooperative)
    {
        if ($cooperative->is_deleted) return response()->json(['message' => 'Cooperative not found'], 404);
        return new \App\Http\Resources\CooperativeResource($cooperative->load('services'));
    }

    public function update(Request $request, \App\Models\Cooperative $cooperative)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'phone' => 'sometimes|string',
            'email' => 'sometimes|email',
            'address' => 'sometimes|string',
            'image' => 'sometimes|string',
            'description' => 'sometimes|string',
            'availability' => 'sometimes|boolean',
        ]);

        $cooperative->update($validated);
        return new \App\Http\Resources\CooperativeResource($cooperative);
    }

    public function destroy(\App\Models\Cooperative $cooperative)
    {
        $cooperative->update(['is_deleted' => true]);
        return response()->json(['message' => 'Cooperative soft-deleted successfully']);
    }
}
