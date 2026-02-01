<?php

namespace App\Dto;

class UserDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}