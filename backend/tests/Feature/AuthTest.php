<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'user' => [
                'id',
                'name',
                'email',
            ],
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'name' => 'John Doe',
        ]);
    }

    public function test_registration_requires_name(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    public function test_registration_requires_valid_email(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'invalid-email',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_registration_requires_unique_email(): void
    {
        User::factory()->create(['email' => 'john@example.com']);

        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_user_can_verify_email(): void
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'email_verified_at' => null,
        ]);

        $token = 'test_verification_token';
        Cache::put('email_verification_' . $token, $user->id, now()->addHours(24));

        $response = $this->postJson('/api/auth/verify-email', [
            'token' => $token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'user',
            'token',
        ]);

        $this->assertNotNull($user->fresh()->email_verified_at);
        $this->assertFalse(Cache::has('email_verification_' . $token));
    }

    public function test_email_verification_fails_with_invalid_token(): void
    {
        $response = $this->postJson('/api/auth/verify-email', [
            'token' => 'invalid_token',
        ]);

        $response->assertStatus(400);
    }

    public function test_user_can_request_login_link(): void
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'email_verified_at' => now(),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Login link sent to your email.',
        ]);
    }

    public function test_login_fails_for_unverified_email(): void
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'email_verified_at' => null,
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(403);
    }

    public function test_login_fails_for_nonexistent_user(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'nonexistent@example.com',
        ]);

        $response->assertStatus(422);
    }
}

