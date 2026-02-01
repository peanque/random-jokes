<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);
});

test('can get random jokes', function () {
    $response = $this->actingAs($this->user)->get('/api/v1/random-jokes');

    $response->assertStatus(200);
    $response->assertJsonStructure([
        '*' => [
            'id',
            'type',
            'setup',
            'punchline'
        ]
    ]);
});

test('unauthenticated user cannot get random jokes', function () {
    $response = $this->getJson('/api/v1/random-jokes');

    $response->assertStatus(401);
    $response->assertJson(['message' => 'Unauthenticated.']);
});

test('random jokes returns 3 jokes', function () {
    $response = $this->actingAs($this->user)->getJson('/api/v1/random-jokes');

    $response->assertStatus(200);
    $response->assertJsonCount(3);
});