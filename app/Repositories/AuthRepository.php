<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthRepository
{
    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function attemptLogin(array $credentials)
    {
        return Auth::attempt($credentials);
    }

    public function getAuthenticatedUser()
    {
        return Auth::user();
    }
}
