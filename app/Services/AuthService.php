<?php


namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->authRepository->createUser($data);

        return [
            'token' => $user->createToken('API Token')->accessToken
        ];
    }

    public function login(array $credentials)
    {
        if ($this->authRepository->attemptLogin($credentials)) {
            return [
                'token' => $this->authRepository->getAuthenticatedUser()->createToken('API Token')->accessToken
            ];
        }

        return null;
    }

    public function logout($user)
    {
        // Revoke current token
        $user->token()->revoke();
    }
}
