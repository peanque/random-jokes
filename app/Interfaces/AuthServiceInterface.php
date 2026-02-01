<?php

namespace App\Interfaces;

use App\Dto\UserDto;
use App\Models\User;

interface AuthServiceInterface
{
    public function register(UserDto $userDto): User;

    public function login(string $email, string $password): array;

    public function logout(): void;
}