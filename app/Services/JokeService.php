<?php

namespace App\Services;

use App\Interfaces\JokeServiceInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class JokeService implements JokeServiceInterface
{

    private string $apiUrl = 'https://official-joke-api.appspot.com/jokes/programming/ten/';

    public function getRandomJoke(): array
    {
        $http = Http::timeout(5);
        $http = $http->withoutVerifying();

        $response = $http->get($this->apiUrl);

        $count = 3;

        if (!$response->successful()) {
            $jokes = $this->getCachedJoke($count);
        }

        $jokes = $response->json();

        if (! is_array($jokes) || empty($jokes)) {
            $jokes = $this->getCachedJoke($count);
        } else {
             $this->cacheRandomJoke($jokes);
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
        $jokes = json_decode($cachedJokes, true);

        $keys = array_rand($jokes, $count);

        $randomJokes = array_map(fn($keys) => $jokes[$keys] , $keys);

        return $randomJokes;
    }
}
