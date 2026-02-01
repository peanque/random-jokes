<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\AuthServiceInterface;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Dto\UserDto;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private AuthServiceInterface $authService,
    ) {}

    public function register(RegisterRequest $request)
    {
        $userDto = new UserDto($request->name, $request->email, $request->password);
        $user = $this->userRepository->create($userDto);

        return new UserResource($user);
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = $this->authService->login($request->email, $request->password);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }

        return response()->json([
            'user' => new UserResource($user['user']),
            'token' => $user['token'],
        ]);
    }

    public function logout()
    {
        $this->authService->logout();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
