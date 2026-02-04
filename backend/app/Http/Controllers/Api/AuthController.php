<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => null,
        ]);

        // Generate verification token
        $token = Str::random(60);
        
        // Store token in cache for 24 hours
        cache()->put('email_verification_' . $token, $user->id, now()->addHours(24));

        // TODO: Send verification email with token
        // Mail::to($user->email)->send(new VerifyEmail($token));

        return response()->json([
            'message' => 'Registration successful. Please check your email to verify your account.',
            'user' => $user,
        ], 201);
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $userId = cache()->get('email_verification_' . $request->token);

        if (!$userId) {
            return response()->json([
                'message' => 'Invalid or expired verification token.',
            ], 400);
        }

        $user = User::find($userId);
        
        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
            ], 404);
        }

        $user->email_verified_at = now();
        $user->save();

        // Remove verification token from cache
        cache()->forget('email_verification_' . $request->token);

        // Create token for authenticated session
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Email verified successfully.',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['User not found.'],
            ]);
        }

        if (!$user->email_verified_at) {
            return response()->json([
                'message' => 'Please verify your email first.',
            ], 403);
        }

        // Generate login token
        $loginToken = Str::random(60);
        cache()->put('login_token_' . $loginToken, $user->id, now()->addMinutes(15));

        // TODO: Send login link via email
        // Mail::to($user->email)->send(new LoginLink($loginToken));

        return response()->json([
            'message' => 'Login link sent to your email.',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }
}

