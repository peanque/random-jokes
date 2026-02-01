<?php

namespace App\Interfaces;

interface JokeServiceInterface
{
    public function getRandomJoke(): array;
}