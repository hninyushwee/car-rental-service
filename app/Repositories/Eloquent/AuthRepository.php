<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interface\AuthInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthInterface
{
    public function register(array $data): array
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Auto-login after registration
        Auth::login($user);

        return ['user' => $user];
    }

    public function login(array $data): ?array
    {
        // true = remember me cookie
        if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']], true)) {
            return null;
        }

        return ['user' => Auth::user()];
    }

    public function logout($user): bool
    {
        Auth::guard('web')->logout();
        return true;
    }
}