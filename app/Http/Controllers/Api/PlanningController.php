<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plannings = \App\Models\Planning::with('planningItems.place')
            ->where('user_id', auth()->id())
            ->where('is_deleted', false)
            ->get();
        return \App\Http\Resources\PlanningResource::collection($plannings);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $planning = \App\Models\Planning::create($validated);
        return new \App\Http\Resources\PlanningResource($planning);
    }

    public function show(\App\Models\Planning $planning)
    {
        if ($planning->is_deleted) return response()->json(['message' => 'Planning not found'], 404);
        return new \App\Http\Resources\PlanningResource($planning->load('planningItems.place'));
    }

    public function update(Request $request, \App\Models\Planning $planning)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
        ]);

        $planning->update($validated);
        return new \App\Http\Resources\PlanningResource($planning);
    }

    public function destroy(\App\Models\Planning $planning)
    {
        $planning->update(['is_deleted' => true]);
        return response()->json(['message' => 'Planning soft-deleted successfully']);
    }
}
