<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = \App\Models\Service::with(['cooperative', 'place', 'hotel', 'transport'])
            ->where('is_deleted', false)
            ->get();
        return \App\Http\Resources\ServiceResource::collection($services);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'cooperative_id' => 'required|exists:cooperatives,id',
            'place_id' => 'required|exists:places,id',
            'guide_id' => 'required|exists:guides,id',
            'hotel_id' => 'required|exists:hotels,id',
            'transport_id' => 'required|exists:transports,id',
            'price' => 'required|integer',
        ]);

        $service = \App\Models\Service::create($validated);
        return new \App\Http\Resources\ServiceResource($service);
    }

    public function show(\App\Models\Service $service)
    {
        if ($service->is_deleted) return response()->json(['message' => 'Service not found'], 404);
        return new \App\Http\Resources\ServiceResource($service->load(['cooperative', 'place', 'hotel', 'transport']));
    }

    public function update(Request $request, \App\Models\Service $service)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'availability' => 'sometimes|boolean',
            'price' => 'sometimes|integer',
        ]);

        $service->update($validated);
        return new \App\Http\Resources\ServiceResource($service);
    }

    public function destroy(\App\Models\Service $service)
    {
        $service->update(['is_deleted' => true]);
        return response()->json(['message' => 'Service soft-deleted successfully']);
    }
}
