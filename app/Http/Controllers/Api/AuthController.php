<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|string|in:admin,guide,tourist,customer,transport,hotel,cooperative,coop',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'place_id' => 'nullable|exists:places,id',
            'description' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'customer',
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'bio' => $validated['description'] ?? null,
        ]);

        // Handle Image Upload
        $imagePath = 'placeholder.jpg';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
            $imagePath = '/storage/' . $imagePath;
        }

        // Create provider record if applicable
        if ($user->role === 'hotel') {
             \App\Models\Hotel::create([
                 'user_id' => $user->id,
                 'name' => $user->name,
                 'phone' => $request->phone ?? '',
                 'email' => $user->email,
                 'address' => $request->address ?? '',
                 'description' => $request->description ?? '',
                 'place_id' => $request->place_id,
                 'type' => 'hotel',
                 'image' => $imagePath,
                 'price' => 0,
             ]);
        } elseif ($user->role === 'transport') {
            $docPath = null;
            if ($request->hasFile('licenseDoc')) {
                $docPath = $request->file('licenseDoc')->store('uploads/docs', 'public');
                $docPath = '/storage/' . $docPath;
            }

            \App\Models\Transport::create([
                'user_id' => $user->id,
                'phone' => $request->phone ?? '',
                'description' => $request->description ?? '',
                'place_id' => $request->place_id,
                'type' => 'car',
                'image' => $imagePath,
                'license_doc' => $docPath,
                'price' => 0,
            ]);
        } elseif ($user->role === 'cooperative' || $user->role === 'coop') {
            $certPath = null;
            if ($request->hasFile('certificate')) {
                $certPath = $request->file('certificate')->store('uploads/certs', 'public');
                $certPath = '/storage/' . $certPath;
            }

            \App\Models\Cooperative::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'phone' => $request->phone ?? '',
                'email' => $user->email,
                'address' => $request->address ?? '',
                'description' => $request->description ?? '',
                'place_id' => $request->place_id,
                'image' => $imagePath,
                'certificate' => $certPath,
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Les identifiants sont incorrects.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie'
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
