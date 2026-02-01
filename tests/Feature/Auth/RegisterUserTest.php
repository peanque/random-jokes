<?php

test('user can register', function () {
    $response = $this->post('/api/v1/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(201);
    $response->assertJsonStructure([
        'data' => [
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
        ]
    ]);
});
