<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtAuthenticate
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            
            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                    'status' => 'error'
                ], 404);
            }
            
            if (!$user->employee) {
                return response()->json([
                    'message' => 'Employee profile not found for this user',
                    'status' => 'error'
                ], 403);
            }
            
            $request->merge(['employee' => $user->employee]);
            
        } catch (TokenExpiredException $e) {
            return response()->json([
                'message' => 'Token expired',
                'status' => 'error'
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'message' => 'Token invalid',
                'status' => 'error'
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Token absent or invalid',
                'status' => 'error'
            ], 401);
        }

        return $next($request);
    }
}