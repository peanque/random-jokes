<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Middleware\EnsureUserIsAuthenticated;
use Illuminate\Http\Request;
use App\Interfaces\JokeServiceInterface;

class JokesController extends Controller
{
    public function __construct(
        private JokeServiceInterface $jokeService,
    ) {}

    public function showJokes()
    {
        $jokes = $this->jokeService->getRandomJoke();

        return view('jokes', ['jokes' => $jokes]);
    }
}
