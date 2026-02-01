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
        $jokes = $this->jokeService->getRandomJoke();
        return response()->json($jokes);
    }
}
