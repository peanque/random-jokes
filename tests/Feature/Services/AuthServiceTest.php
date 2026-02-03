<?php

use App\Dto\UserDto;
use App\Models\User;
use App\Repository\UserRepository;
use app\Interfaces\UserRepositoryInterface;
use App\Services\AuthService;
use League\Config\Exception\ValidationException;

function createAuthService(): array
{
    $userRepository = Mockery::mock(UserRepositoryInterface::class);
    $authService = new AuthService($userRepository);
    return [$authService, $userRepository];
}

describe('register', function () {
    test('user can register', function () {
        [$authService, $userRepository] = createAuthService();
        $userDto = new UserDto(
            name: 'Poldo Pablito',
            email: 'poldo.pablito@gmail.com',
            password: '@koSiP0ld0'
        );

        $expectedUser = new User([
            'id' => 1,
            'name' => 'Poldo Pablito',
            'email' => 'poldo.pablito@gmail.com'
        ]);

        $userRepository
            ->shouldReceive('create')
            ->once()
            ->with($userDto)
            ->andReturn($expectedUser);

        $result = $authService->register($userDto);

        expect($result)->toBeInstanceOf(User::class)
            ->and($result->email)->toBe('poldo.pablito@gmail.com')
            ->and($result->name)->toBe('Poldo Pablito');
    });

    test('auth service fails when repository throws an error', function () {
        [$authService, $userRepository] = createAuthService();

        $userRepository->shouldReceive('create')
            ->once()
            ->andThrow(new \Illuminate\Validation\ValidationException(
                validator([], ['name' => 'required'])
            ));

        $userDto = new UserDto('', 'poldo@gmail.com', 'password');

        expect(fn() => $authService->register($userDto))
            ->toThrow(\Illuminate\Validation\ValidationException::class);
    });
});
