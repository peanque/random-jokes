<?php

namespace App\Services;

use App\Interfaces\JokeServiceInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class JokeService implements JokeServiceInterface
{

    private string $apiUrl = 'https://official-joke-api.appspot.com/jokes/programming/4/';

    public function getRandomJoke(): array
    {
        $http = Http::timeout(5);
        $http = $http->withoutVerifying();

        $response = $http->get($this->apiUrl);

        $count = 3;
        $jokes = [];

        if (!$response->successful()) {
            $jokes = $this->getCachedJoke($count);
        } else {
            $jokeResponse = $response->json();

            $this->cacheRandomJoke($jokeResponse);

            $keys = array_rand($jokeResponse, $count);
            $jokes = array_map(fn($key) => $jokeResponse[$key], $keys);
        }

        return $jokes;
    }

    public function cacheRandomJoke(array $jokes): void
    {
        Cache::put('jokes', json_encode($jokes), now()->addMinutes(30));
    }

    public function getCachedJoke(int $count): array
    {
        $cachedJokes = Cache::get('jokes');

        if (! $cachedJokes) {
            return [];
        }

        $jokes = json_decode($cachedJokes, true);

        $keys = array_rand($jokes, $count);

        $randomJokes = array_map(fn($keys) => $jokes[$keys] , $keys);

        return $randomJokes;
    }
}
