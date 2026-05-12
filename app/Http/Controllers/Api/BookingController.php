<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = \App\Models\Booking::with(['user', 'service.hotel', 'service.cooperative', 'service.transport', 'service.place'])
            ->where('is_deleted', false)
            ->get();
        return \App\Http\Resources\BookingResource::collection($bookings);
    }

    public function myBookings(Request $request)
    {
        $user = $request->user();
        $bookings = \App\Models\Booking::with(['user', 'service.hotel', 'service.cooperative', 'service.transport', 'service.place'])
            ->where('user_id', $user->id)
            ->where('is_deleted', false)
            ->get();
        return \App\Http\Resources\BookingResource::collection($bookings);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $booking = \App\Models\Booking::create($validated);
        return new \App\Http\Resources\BookingResource($booking);
    }

    public function show(\App\Models\Booking $booking)
    {
        if ($booking->is_deleted) return response()->json(['message' => 'Booking not found'], 404);
        return new \App\Http\Resources\BookingResource($booking->load(['user', 'service']));
    }

    public function update(Request $request, \App\Models\Booking $booking)
    {
        $validated = $request->validate([
            'start_date' => 'sometimes|date|after:today',
            'end_date' => 'sometimes|date|after:start_date',
        ]);

        $booking->update($validated);
        return new \App\Http\Resources\BookingResource($booking);
    }

    public function updateStatus(Request $request, \App\Models\Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $booking->update(['status' => $validated['status']]);
        return response()->json(['message' => 'Status updated successfully', 'booking' => new \App\Http\Resources\BookingResource($booking)]);
    }

    public function destroy(\App\Models\Booking $booking)
    {
        $booking->update(['is_deleted' => true]);
        return response()->json(['message' => 'Booking cancelled successfully']);
    }
}
