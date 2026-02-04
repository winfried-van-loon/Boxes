<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserConnectionController extends Controller
{
    /**
     * Display a listing of user connections
     */
    public function index(Request $request)
    {
        $connections = $request->user()->connections()
            ->with('connectedUser')
            ->get();

        return response()->json($connections);
    }

    /**
     * Generate QR code for connection
     */
    public function generateQrCode(Request $request)
    {
        $user = $request->user();
        $token = Str::random(32);

        // Store token for 15 minutes
        cache()->put('connection_token_' . $token, $user->id, now()->addMinutes(15));

        // Generate connection URL
        $connectionUrl = config('app.url') . '/api/connections/connect?token=' . $token;

        // Generate QR code
        $qrCode = QrCode::size(300)
            ->generate($connectionUrl);

        return response()->json([
            'token' => $token,
            'url' => $connectionUrl,
            'qr_code' => base64_encode($qrCode),
        ]);
    }

    /**
     * Connect with another user using token
     */
    public function connect(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $userId = cache()->get('connection_token_' . $request->token);

        if (!$userId) {
            return response()->json([
                'message' => 'Invalid or expired connection token.',
            ], 400);
        }

        if ($userId == $request->user()->id) {
            return response()->json([
                'message' => 'You cannot connect with yourself.',
            ], 400);
        }

        // Check if connection already exists
        $existingConnection = UserConnection::where(function ($query) use ($userId, $request) {
            $query->where('user_id', $request->user()->id)
                ->where('connected_user_id', $userId);
        })->orWhere(function ($query) use ($userId, $request) {
            $query->where('user_id', $userId)
                ->where('connected_user_id', $request->user()->id);
        })->first();

        if ($existingConnection) {
            return response()->json([
                'message' => 'Connection already exists.',
                'connection' => $existingConnection,
            ], 400);
        }

        // Create connection
        $connection = UserConnection::create([
            'user_id' => $request->user()->id,
            'connected_user_id' => $userId,
            'status' => 'pending',
        ]);

        // Remove token from cache
        cache()->forget('connection_token_' . $request->token);

        return response()->json([
            'message' => 'Connection request sent.',
            'connection' => $connection->load('connectedUser'),
        ], 201);
    }

    /**
     * Accept connection request
     */
    public function accept(UserConnection $connection)
    {
        if ($connection->connected_user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        $connection->update(['status' => 'accepted']);

        return response()->json([
            'message' => 'Connection accepted.',
            'connection' => $connection->load('user'),
        ]);
    }

    /**
     * Reject connection request
     */
    public function reject(UserConnection $connection)
    {
        if ($connection->connected_user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        $connection->update(['status' => 'rejected']);

        return response()->json([
            'message' => 'Connection rejected.',
        ]);
    }

    /**
     * Remove connection
     */
    public function destroy(UserConnection $connection)
    {
        if ($connection->user_id !== auth()->id() && $connection->connected_user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        $connection->delete();

        return response()->json([
            'message' => 'Connection removed.',
        ]);
    }
}

