<?php

namespace App\Services;

use App\Interfaces\JokeServiceInterface;
use Illuminate\Support\Facades\Http;

class JokeService implements JokeServiceInterface
{

    private string $apiUrl = 'https://official-joke-api.appspot.com/jokes/programming/ten/';

    public function getRandomJoke(): array
    {
        $http = Http::timeout(5);
        $http = $http->withoutVerifying();

        $response = $http->get($this->apiUrl);

        if (!$response->successful()) {
            throw new \Exception('Failed to fetch jokes');
        }

        $jokes = $response->json();

        if (! is_array($jokes) || empty($jokes)) {
            throw new \Exception('Invalid joke response.');
        }

        $keys = array_rand($jokes, 3);
        
        return array_map(fn($key) => $jokes[$key], $keys);
    }
}