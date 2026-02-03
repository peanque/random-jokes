<?php

namespace App\Services;

use App\Interfaces\AuthServiceInterface;
use App\Dto\UserDto;
use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserDto $userDto): User
    {
        return $this->userRepository->create($userDto);
    }

    public function login(string $email, string $password): array
    {
        try {
            $user = $this->userRepository->findByEmail($email);
        } catch (ModelNotFoundException $e) {
            throw ValidationException::withMessages([
                'email' => 'Authentication Failed'
            ]);
        }

        if (!Hash::check($password, $user->password)) {
            throw new \Exception('Invalid credentials');
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
