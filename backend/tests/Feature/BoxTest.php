<?php

namespace Tests\Feature;

use App\Models\Box;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BoxTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_box(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/boxes', [
            'name' => 'Kitchen Box',
            'number' => 'K-001',
            'type' => 'Medium Cardboard',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'name',
            'number',
            'type',
            'user_id',
        ]);
        $this->assertDatabaseHas('boxes', [
            'name' => 'Kitchen Box',
            'number' => 'K-001',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_list_their_boxes(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Sanctum::actingAs($user);

        Box::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/boxes');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_user_can_update_their_box(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Sanctum::actingAs($user);

        $box = Box::factory()->create(['user_id' => $user->id]);

        $response = $this->putJson('/api/boxes/' . $box->id, [
            'name' => 'Updated Box Name',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('boxes', [
            'id' => $box->id,
            'name' => 'Updated Box Name',
        ]);
    }

    public function test_user_cannot_update_other_users_box(): void
    {
        $user1 = User::factory()->create(['email_verified_at' => now()]);
        $user2 = User::factory()->create(['email_verified_at' => now()]);
        
        Sanctum::actingAs($user1);

        $box = Box::factory()->create(['user_id' => $user2->id]);

        $response = $this->putJson('/api/boxes/' . $box->id, [
            'name' => 'Hacked Box',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_their_box(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Sanctum::actingAs($user);

        $box = Box::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson('/api/boxes/' . $box->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('boxes', ['id' => $box->id]);
    }

    public function test_user_can_filter_boxes_by_room(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Sanctum::actingAs($user);

        $room = Room::factory()->create(['user_id' => $user->id]);
        Box::factory()->count(2)->create(['user_id' => $user->id, 'current_room_id' => $room->id]);
        Box::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/boxes?current_room_id=' . $room->id);

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    public function test_user_can_search_boxes(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Sanctum::actingAs($user);

        Box::factory()->create(['user_id' => $user->id, 'name' => 'Kitchen Items']);
        Box::factory()->create(['user_id' => $user->id, 'name' => 'Bedroom Items']);

        $response = $this->getJson('/api/boxes?search=Kitchen');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    public function test_user_can_add_item_to_box(): void
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        Sanctum::actingAs($user);

        $box = Box::factory()->create(['user_id' => $user->id]);

        $response = $this->postJson('/api/boxes/' . $box->id . '/items', [
            'name' => 'Spatula',
            'quantity' => 2,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('box_items', [
            'box_id' => $box->id,
            'name' => 'Spatula',
            'quantity' => 2,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_boxes(): void
    {
        $response = $this->getJson('/api/boxes');
        $response->assertStatus(401);
    }
}

