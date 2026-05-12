<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Planning;
use App\Models\PlanningItem;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ItineraryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'selectedPlaces' => 'required|array',
            'selectedPlaces.*.id' => 'required|exists:places,id',
            'activities' => 'array',
            'activities.*' => 'exists:services,id',
            'hotel_id' => 'nullable|exists:hotels,id',
            'transport_id' => 'nullable|exists:transports,id',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                // 1. Create Planning
                $planning = Planning::create([
                    'user_id' => auth()->id() ?? 1, // Fallback for testing if not auth
                    'start_date' => $request->startDate,
                    'end_date' => $request->endDate,
                ]);

                // 2. Create Planning Items
                foreach ($request->selectedPlaces as $place) {
                    PlanningItem::create([
                        'planning_id' => $planning->id,
                        'place_id' => $place['id'],
                        'time' => now()->toTimeString(), // Explicitly send only HH:MM:SS
                    ]);
                }

                // 3. Create Bookings for Activities
                if ($request->has('activities')) {
                    foreach ($request->activities as $serviceId) {
                        Booking::create([
                            'user_id' => auth()->id() ?? 1,
                            'service_id' => $serviceId,
                            'start_date' => $request->startDate,
                            'end_date' => $request->endDate,
                            'status' => 'pending',
                        ]);
                    }
                }

                // 4. Create Booking for Hotel (find the main service of the hotel)
                if ($request->hotel_id) {
                    $hotelService = Service::where('hotel_id', $request->hotel_id)->first();
                    if ($hotelService) {
                        Booking::create([
                            'user_id' => auth()->id() ?? 1,
                            'service_id' => $hotelService->id,
                            'start_date' => $request->startDate,
                            'end_date' => $request->endDate,
                            'status' => 'pending',
                        ]);
                    }
                }

                // 5. Create Booking for Transport
                if ($request->transport_id) {
                    $transportService = Service::where('transport_id', $request->transport_id)->first();
                    if ($transportService) {
                        Booking::create([
                            'user_id' => auth()->id() ?? 1,
                            'service_id' => $transportService->id,
                            'start_date' => $request->startDate,
                            'end_date' => $request->endDate,
                            'status' => 'pending',
                        ]);
                    }
                }

                return response()->json([
                    'message' => 'Itinerary and bookings created successfully',
                    'planning_id' => $planning->id
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating itinerary',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
