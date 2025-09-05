<?php

namespace App\Services;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthService {
    public function register(array $data): array {
        //создание пользака
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        //создание сотрудника

        $employee = Employee::create([
            'user_id' => $user->id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'position_id' => $data['position_id'],
            'phone' => $data['phone'] ?? null,
        ]);

        $token = JWTAuth::fromUser($user);

        return [
            'user' => $user->load('employee.position'),
            'token' => $token
        ];
    }

    public function login(array $credentials): ?array {
        if(!$token = JWTAuth::attempt($credentials)) {
            return null;
        }

        $user = auth()->user()->load('employee.position');

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function logout(): void {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function refresh(): string {
        return JWTAuth::refresh(JWTAuth::getToken());
    }
}