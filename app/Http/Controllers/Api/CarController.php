<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AvailableCarsRequest;
use App\Http\Resources\CarResource;
use App\Services\CarAvailabilityService;
use Illuminate\Http\JsonResponse;

class CarController extends Controller
{
    public function __construct(private CarAvailabilityService $carAvailabilityService) {

    }

   public function getAvailableCars(AvailableCarsRequest $request): JsonResponse
{

    
    try {
        // Добавьте проверку JWT аутентификации
        if (!auth()->check()) {
            return response()->json([
                'message' => 'Token is invalid or expired'
            ], 401);
        }

        if (!auth()->user()->employee) {
            return response()->json([
                'message' => 'Employee profile not found. Please contact HR.'
            ], 404);
        }

        $availableCars = $this->carAvailabilityService->getAvailableCars(
            auth()->user()->employee,
            $request->date('start_time'),
            $request->date('end_time'),
            $request->only(['model','comfort_category', 'brand'])
        );

        return response()->json([
            'data' => CarResource::collection($availableCars)
        ]);

    } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
        return response()->json([
            'message' => 'Token expired',
            'error' => $e->getMessage()
        ], 401);
        
    } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
        return response()->json([
            'message' => 'Token invalid',
            'error' => $e->getMessage()
        ], 401);
        
    } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
        return response()->json([
            'message' => 'Token error',
            'error' => $e->getMessage()
        ], 401);
        
    } catch (EmployeePositionException $e) {
        return response()->json([
            'message' => 'Не удается получить доступ к каталогу автомобилей',
            'error' => $e->getMessage(),
            'resolution' => 'Пожалуйста, свяжитесь с вашим менеджером, чтобы назначить должность'
        ], 400);

    } catch (NoComfortCategoriesException $e) {
        return response()->json([
            'message' => 'Нет доступных машин для вашей должности',
            'error' => $e->getMessage(),
            'resolution' => 'Пожалуйста, свяжитесь с администратором, чтобы настроить категории комфорта для вашего должности'
        ], 403);
    }
}
}
