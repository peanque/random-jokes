<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

test('user can logout', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $response = $this->postJson('/api/v1/logout');

    $response->assertStatus(200)
        ->assertJson(['message' => 'Logged out successfully']);
});
