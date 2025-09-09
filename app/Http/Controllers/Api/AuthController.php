<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function register(RegisterRequest $request): JsonResponse {
        $result = $this->authService->register($request->validated());

        return response()->json([
            'message' => 'Пользователь успешно создан',
            'data' => [
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60 // Исправлено на expires_in
            ]
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse {
        $result = $this->authService->login($request->validated());

        if(!$result) {
            return response()->json([
                'message' => 'Учетные данные неверны'
            ], 401);
        }

        return response()->json([
            'message' => 'Успешно авторизован',
            'data' => [
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60
            ]
        ]);
    }

    public function logout(): JsonResponse {
        $this->authService->logout();

        return response()->json([
            'message' => 'Вы успешно вышли'
        ]);
    }

    public function refresh(): JsonResponse {
        $token = $this->authService->refresh();

        return response()->json([
            'message' => 'Token refreshed',
            'data' => [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60
            ]
        ]);
    }
    
    public function me(): JsonResponse {
        $user = JWTAuth::user()->load('employee.position');
        return response()->json([
            'data' => new UserResource($user)
        ]);
    }
}