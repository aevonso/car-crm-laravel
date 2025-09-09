<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtCustom
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['error' => 'Пользователь не найден'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Токен истек'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Неверный токен'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Токен отсутствует'], 401);
        }

        return $next($request);
    }
}