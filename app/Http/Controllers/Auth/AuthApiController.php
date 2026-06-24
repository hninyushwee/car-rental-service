<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use App\Repositories\Interface\AuthInterface;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

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

        return $this->successResponse($result['user'],'User registered successfully',201);

    }

    public function login(LoginRequest $request)
    {
        $result = $this->authRepo->login($request->validated());

        if (!$result) {
            return $this->errorResponse('Invalid email or password credentials',401);
        }

        // return $this->successResponse($result['user'],'User logged in successfully',200);
        return response()->json([
            'success' => true,
            'message' => 'Login authenticated successful',
            'access_token' => $result['access_token'],
            'token_type' => $result['token_type'],
            'user' => $result['user'],
        ], 200);
    }   

    public function logout(Request $request)
    {
        if (!$request->user()) {
            return $this->errorResponse('Unauthenticated or missing valid token.',401);
        }

        $logout = $this->authRepo->logout($request->user());

        if ($logout) {
            return $this->successResponse('Logged out successfully.');
        }
        return $this->errorResponse('Unable to process logout connection.');
    } 
}