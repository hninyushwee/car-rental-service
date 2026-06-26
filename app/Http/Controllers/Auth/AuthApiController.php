<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Interface\AuthInterface;
use Illuminate\Http\Request;

class AuthApiController extends Controller
{
    protected $authRepo;

    public function __construct(AuthInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authRepo->register($request->validated());

        $request->session()->regenerate();

        return $this->successResponse($result['user'], 'User registered successfully', 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authRepo->login($request->validated());

        if (!$result) {
            return $this->errorResponse('Invalid email or password credentials.', 401);
        }

        $request->session()->regenerate();

        return $this->successResponse($result['user'], 'Login authenticated successfully', 200);
    }

    public function logout(Request $request)
    {
        if (!$request->user()) {
            return $this->errorResponse('Unauthenticated or missing valid token.', 401);
        }

        $this->authRepo->logout($request->user());

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->successResponse(null, 'Logged out successfully.');
    }
}