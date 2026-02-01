<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);
});

test('user can login', function () {
    $response = $this->postJson('/api/v1/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'user' => [
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
        ],
        'token'
    ]);
});

test('login requires email and password', function () {
    $this->postJson('/api/v1/login')
        ->assertStatus(422)
        ->assertJsonValidationErrors(['email', 'password']);
});

test('user returns invalid credentials', function () {
    $response = $this->postJson('/api/v1/login', [
        'email' => 'test@example.com',
        'password' => 'wrong_password',
    ]);

    $response->assertStatus(401);
    $response->assertJson(['message' => 'Invalid credentials']);
});
