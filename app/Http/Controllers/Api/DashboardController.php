<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Favorite;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Get statistics for the dashboard.
     */
    public function stats()
    {
        $user = Auth::user();
        
        if ($user->role === 'tourist' || $user->role === 'customer') {
            return response()->json([
                'favorites' => Favorite::where('user_id', $user->id)->count(),
                'bookings' => Booking::where('user_id', $user->id)->where('is_deleted', false)->count(),
                'pending' => 0, // Mocked as no status field yet
                'rating' => 4.8, // Mocked
                'services' => 0,
                'requests' => 0,
                'clients' => 0,
            ]);
        }
        
        // For providers (hotel, coop, transport)
        // Get services owned by this provider
        $serviceIds = [];
        if ($user->role === 'hotel') {
            $serviceIds = Service::whereIn('hotel_id', $user->hotels()->pluck('id'))->pluck('id');
        } elseif ($user->role === 'cooperative' || $user->role === 'coop') {
            $serviceIds = Service::whereIn('cooperative_id', $user->cooperatives()->pluck('id'))->pluck('id');
        } elseif ($user->role === 'transport') {
            $serviceIds = Service::whereIn('transport_id', $user->transports()->pluck('id'))->pluck('id');
        }

        $bookingsCount = Booking::whereIn('service_id', $serviceIds)->where('is_deleted', false)->count();

        return response()->json([
            'favorites' => 0,
            'bookings' => $bookingsCount,
            'pending' => 0, // Mocked
            'rating' => 4.9, // Mocked
            'services' => count($serviceIds),
            'requests' => $bookingsCount,
            'clients' => Booking::whereIn('service_id', $serviceIds)->distinct('user_id')->count(),
        ]);
    }

    public function profile()
    {
        $user = Auth::user();
        $profile = null;

        if ($user->role === 'hotel') {
            $profile = $user->hotels()->with('services')->first();
        } elseif ($user->role === 'coop' || $user->role === 'cooperative') {
            $profile = $user->cooperatives()->with('services')->first();
        } elseif ($user->role === 'transport') {
            $profile = $user->transports()->with('services')->first();
        }

        return response()->json([
            'user' => $user,
            'profile' => $profile
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'bio' => $request->description,
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $path = 'providers';
            if ($user->role === 'hotel') $path = 'hotels';
            elseif ($user->role === 'transport') $path = 'transports';
            elseif ($user->role === 'coop' || $user->role === 'cooperative') $path = 'cooperatives';
            
            $imagePath = $request->file('image')->store($path, 'public');
        }

        if ($user->role === 'hotel') {
            $updateData = $request->only(['phone', 'address', 'description', 'price', 'type']);
            if ($imagePath) $updateData['image'] = $imagePath;
            $user->hotels()->first()?->update($updateData);
        } elseif ($user->role === 'coop' || $user->role === 'cooperative') {
            $updateData = $request->only(['name', 'phone', 'address', 'description']);
            if ($imagePath) $updateData['image'] = $imagePath;
            $user->cooperatives()->first()?->update($updateData);
        } elseif ($user->role === 'transport') {
            $updateData = $request->only(['phone', 'description', 'type']);
            if ($imagePath) $updateData['image'] = $imagePath;
            $user->transports()->first()?->update($updateData);
        }

        return response()->json([
            'message' => 'Profile updated successfully',
            'image' => $imagePath
        ]);
    }

    public function updateGallery(Request $request)
    {
        $user = Auth::user();
        $gallery = $request->input('gallery', []);

        if ($user->role === 'hotel') {
            $user->hotels()->first()?->update(['gallery' => $gallery]);
        } elseif ($user->role === 'coop' || $user->role === 'cooperative') {
            $user->cooperatives()->first()?->update(['gallery' => $gallery]);
        } elseif ($user->role === 'transport') {
            $user->transports()->first()?->update(['gallery' => $gallery]);
        }

        return response()->json(['message' => 'Gallery updated successfully']);
    }
}
