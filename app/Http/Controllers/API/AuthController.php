<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PersonalAccessToken;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'nullable|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'The provided credentials are incorrect.'
            ], 401);
        }

        // Create token manually for MongoDB compatibility
        $deviceName = $request->device_name ?? $request->ip();
        $plainTextToken = Str::random(40);
        
        $accessToken = PersonalAccessToken::create([
            'name' => $deviceName,
            'token' => hash('sha256', $plainTextToken),
            'abilities' => ['*'],
            'tokenable_type' => get_class($user),
            'tokenable_id' => $user->_id,
        ]);

        // Format token as Sanctum expects: {id}|{plaintext}
        $token = $accessToken->_id . '|' . $plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $user->_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
                'token' => $token
            ]
        ]);
    }

    public function logout(Request $request)
    {
        // Find and delete the current token
        $tokenId = $request->bearerToken();
        
        if ($tokenId && strpos($tokenId, '|') !== false) {
            [$id, $token] = explode('|', $tokenId, 2);
            
            $accessToken = PersonalAccessToken::find($id);
            if ($accessToken && hash_equals($accessToken->token, hash('sha256', $token))) {
                $accessToken->delete();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->_id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ]
            ]
        ]);
    }

    public function register(Request $request)
    {
        try {
            // Use Jetstream's CreateNewUser action for validation and user creation
            $createNewUser = app(CreateNewUser::class);
            
            // Validate and create user using Jetstream's logic
            $user = $createNewUser->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
                'role' => $request->role,
                'terms' => $request->terms ?? true, // For API, assume terms accepted if not provided
            ]);

            // Create token manually for MongoDB compatibility (same as login method)
            $deviceName = $request->device_name ?? $request->ip();
            $plainTextToken = Str::random(40);
            
            $accessToken = PersonalAccessToken::create([
                'name' => $deviceName,
                'token' => hash('sha256', $plainTextToken),
                'abilities' => ['*'],
                'tokenable_type' => get_class($user),
                'tokenable_id' => $user->_id,
            ]);

            // Format token as Sanctum expects: {id}|{plaintext}
            $token = $accessToken->_id . '|' . $plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Registration successful',
                'data' => [
                    'user' => [
                        'id' => $user->_id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role,
                    ],
                    'token' => $token
                ]
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.'
            ], 500);
        }
    }
}