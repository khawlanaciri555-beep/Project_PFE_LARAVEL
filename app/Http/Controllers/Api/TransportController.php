<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transports = \App\Models\Transport::with('user')->where('is_deleted', false)->get();
        return \App\Http\Resources\TransportResource::collection($transports);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:car,bus,taxi,plane',
            'price' => 'required|integer',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'phone' => 'required|integer',
        ]);

        $transport = \App\Models\Transport::create($validated);
        return new \App\Http\Resources\TransportResource($transport);
    }

    public function show(\App\Models\Transport $transport)
    {
        if ($transport->is_deleted) return response()->json(['message' => 'Transport not found'], 404);
        return new \App\Http\Resources\TransportResource($transport->load(['services', 'user']));
    }

    public function update(Request $request, \App\Models\Transport $transport)
    {
        $validated = $request->validate([
            'type' => 'sometimes|in:car,bus,taxi,plane',
            'price' => 'sometimes|integer',
            'description' => 'sometimes|string',
            'phone' => 'sometimes|integer',
            'availability' => 'sometimes|boolean',
        ]);

        $transport->update($validated);
        return new \App\Http\Resources\TransportResource($transport);
    }

    public function destroy(\App\Models\Transport $transport)
    {
        $transport->update(['is_deleted' => true]);
        return response()->json(['message' => 'Transport soft-deleted successfully']);
    }
}
