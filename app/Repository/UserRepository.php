<?php

namespace App\Repository;

use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use App\Dto\UserDto;

class UserRepository implements UserRepositoryInterface
{
    public function create(UserDto $userDto): User
    {
        return User::create($userDto->toArray());
    }

    public function findByEmail(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    public function update(UserDto $userDto): User
    {
        return User::where('id', $userDto->id)->update($userDto->toArray());
    }

    public function delete(int $id): void
    {
        User::where('id', $id)->delete();
    }
}