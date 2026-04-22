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
            'title'       => 'required|string',
            'description' => 'sometimes|string|nullable',
            'price'       => 'sometimes|numeric|nullable',
            'type'        => 'sometimes|string|nullable',
            'hotel_id'    => 'sometimes|exists:hotels,id|nullable',
            'cooperative_id' => 'sometimes|exists:cooperatives,id|nullable',
            'transport_id'   => 'sometimes|exists:transports,id|nullable',
            'place_id'    => 'sometimes|exists:places,id|nullable',
            'image'       => 'sometimes|string|nullable',
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
