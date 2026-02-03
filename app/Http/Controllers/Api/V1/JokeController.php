<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\JokeServiceInterface;

class JokeController extends Controller
{
    public function __construct(
        private JokeServiceInterface $jokeService,
    ) {}

    public function getRandomJoke()
    {
        try {
            $jokes = $this->jokeService->getRandomJoke();
            return response()->json($jokes);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
