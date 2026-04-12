<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmergencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emergencies = \App\Models\Emergency::where('is_deleted', false)->get();
        return \App\Http\Resources\EmergencyResource::collection($emergencies);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:police,ambulance,fire,other',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $emergency = \App\Models\Emergency::create($validated);
        return new \App\Http\Resources\EmergencyResource($emergency);
    }

    public function show(\App\Models\Emergency $emergency)
    {
        if ($emergency->is_deleted) return response()->json(['message' => 'Emergency not found'], 404);
        return new \App\Http\Resources\EmergencyResource($emergency);
    }

    public function destroy(\App\Models\Emergency $emergency)
    {
        $emergency->update(['is_deleted' => true]);
        return response()->json(['message' => 'Emergency soft-deleted successfully']);
    }
}
