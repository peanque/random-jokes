<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use App\Models\User;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    // create a sample json data for our Third-party API to Mock
    $this->mockJokesResponse = [
        [
            'id' => 1,
            'type' => 'programming',
            'setup' => 'Why do programmers prefer dark mode?',
            'punchline' => 'Because light attracts bugs!',
        ],
        [
            'id' => 2,
            'type' => 'programming',
            'setup' => 'How do you comfort a JavaScript bug?',
            'punchline' => 'You console it.',
        ],
        [
            'id' => 3,
            'type' => 'programming',
            'setup' => 'Why did the programmer quit his job?',
            'punchline' => "He didn't get arrays.",
        ],
        [
            'id' => 4,
            'type' => 'programming',
            'setup' => 'What do you call a programmer from Finland?',
            'punchline' => 'Nerdic.',
        ],
        [
            'id' => 5,
            'type' => 'programming',
            'setup' => 'Why do Java developers wear glasses?',
            'punchline' => 'Because they can\'t C#.',
        ],
        [
            'id' => 6,
            'type' => 'programming',
            'setup' => 'How many programmers does it take to change a light bulb?',
            'punchline' => 'None. That\'s a hardware problem.',
        ],
        [
            'id' => 7,
            'type' => 'programming',
            'setup' => 'Why do Python developers prefer snakes?',
            'punchline' => 'Because they\'re constrictors.',
        ],
        [
            'id' => 8,
            'type' => 'programming',
            'setup' => 'What\'s a programmer\'s favorite hangout place?',
            'punchline' => 'Foo Bar.',
        ],
        [
            'id' => 9,
            'type' => 'programming',
            'setup' => 'Why did the developer go broke?',
            'punchline' => 'Because he used up all his cache.',
        ],
        [
            'id' => 10,
            'type' => 'programming',
            'setup' => 'What do you call a programmer who doesn\'t comment code?',
            'punchline' => 'A developer.',
        ],
    ];
});

test('can get random jokes', function () {

    Http::fake([
        'official-joke-api.appspot.com/jokes/programming/ten/*' => Http::response($this->mockJokesResponse, 200),
    ]);

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

    $response->assertJsonCount(3);
});

test('unauthenticated user cannot get random jokes', function () {
    $response = $this->getJson('/api/v1/random-jokes');

    $response->assertStatus(401);
    $response->assertJson(['message' => 'Unauthenticated.']);
});

test('random jokes returns 3 jokes', function () {

    Http::fake([
        'official-joke-api.appspot.com/jokes/programming/ten/*' => Http::response($this->mockJokesResponse, 200),
    ]);

    $response = $this->actingAs($this->user)->getJson('/api/v1/random-jokes');

    $response->assertStatus(200);
    $response->assertJsonCount(3);
});

test('handles API failure gracefully', function () {
    Http::fake([
        'official-joke-api.appspot.com/jokes/programming/ten/*' => Http::response([], 500),
    ]);

    $response = $this->actingAs($this->user)->getJson('/api/v1/random-jokes');

    $response->assertStatus(500);
});

test('handles empty API response', function () {
    Http::fake([
        'official-joke-api.appspot.com/jokes/programming/ten/*' => Http::response([], 200),
    ]);

    $response = $this->actingAs($this->user)->getJson('/api/v1/random-jokes');

    $response->assertStatus(500);
});
