<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

      /**
 * @OA\Post(
 *     path="/api/logini",
 *     tags={"Auth"},
 *     summary="Login user and get Sanctum token",
 *     description="Authenticate a user with email and password, and receive an API token.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Login successful",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="user", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="user@example.com")
 *             ),
 *             @OA\Property(property="token", type="string", example="1|i2kXhX0qDfx7A...")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Invalid credentials"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error (missing email or password)"
 *     )
 * )
 */
    public function logini(Request $request){
          $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Attempt authentication
    if (!Auth::attempt($credentials)) {
        return response()->json([
            'message' => 'The provided credentials are incorrect.'
        ], 401);
    }

    $user = Auth::user();

    // Optional: Delete previous tokens if you want only one token per user
    $user->tokens()->delete();

    // Create new Sanctum token
    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
    }

    /**
 * @OA\Get(
 *     path="/api/user",
 *     tags={"Auth"},
 *     summary="Get authenticated user",
 *     description="Returns the authenticated user's details. Requires Bearer token.",
 *     security={{"sanctum":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Authenticated user details",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="user@example.com"),
 *             @OA\Property(property="created_at", type="string", example="2025-07-27T10:00:00Z")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthenticated"
 *     )
 * )
 */

    public function getUser(Request $request){
        return $request->user();
    }

    public function logouti(Request $request){
            $user = $request->user(); 

    if ($user) {
        $user->currentAccessToken()->delete(); 
    }

    return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
