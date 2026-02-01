<?php

namespace App\Interfaces;

use App\Dto\UserDto;
use App\Models\User;

interface UserRepositoryInterface
{
    public function create(UserDto $userDto): User;

    public function findByEmail(string $email): User;

    public function update(UserDto $userDto): User;

    public function delete(int $id): void;
}