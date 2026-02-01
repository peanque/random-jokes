<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\AuthServiceInterface;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Dto\UserDto;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Interfaces\JokeServiceInterface;

class AuthController extends Controller
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private AuthServiceInterface $authService,
    ) {}

    public function showLoginForm()
    {
        return view('login');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = $this->userRepository->findByEmail($request->email);
        } catch (ModelNotFoundException $e) {
            return back()->withErrors([
                'email' => 'These credentials do not match our records.',
            ])->withInput($request->only('email'));
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'These credentials do not match our records.',
            ])->withInput($request->only('email'));
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        session(['auth_token' => $token]);

        return redirect()->intended('/jokes');
    }

    public function register(RegisterRequest $request)
    {
        $userDto = new UserDto($request->name, $request->email, $request->password);
        $user = $this->userRepository->create($userDto);

        $token = $user->createToken('auth_token')->plainTextToken;

        session(['auth_token' => $token]);

        return redirect()->route('login.show')->with('success', 'Registration successful! Please log in.');
    }
}

