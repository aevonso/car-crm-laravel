<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCarRequest;
use App\Http\Requests\Api\UpdateCarRequest;
use App\Http\Resources\CarResource;
use App\Http\Resources\CarCollection;
use App\Services\CarService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CarController extends Controller
{
    public function __construct(private CarService $carService) 
    {
    }

    public function index(): JsonResponse
{
    try {
        $cars = $this->carService->getAllCars();

        return response()->json([
            'success' => true,
            'data' => new CarCollection($cars)
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Ошибка при загрузке автомобилей',
            'error_details' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}

public function show($id): JsonResponse
{
    try {
        $car = $this->carService->getCarById($id);
        
        $car->load([
            'comfortCategory', 
            'driver.employee.user',
            'carModel.brand', 
            'color'
        ]);

        return response()->json([
            'success' => true,
            'data' => new CarResource($car)
        ]);

    } catch (ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Автомобиль не найден'
        ], 404);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Ошибка при загрузке автомобиля',
            'error_details' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}

    public function store(StoreCarRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $car = $this->carService->createCar($validated);
            $car->load(['comfortCategory', 'driver.employee.user', 'carModel.brand', 'color']);

            return response()->json([
                'success' => true,
                'message' => 'Автомобиль успешно создан',
                'data' => new CarResource($car)
            ], 201);

        } catch (\Exception $e) {
            Log::error('CarController store error: ' . $e->getMessage(), [
                'data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Ошибка при создании автомобиля',
                'error_details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function update(UpdateCarRequest $request, $id): JsonResponse
    {
        try {
            $validated = $request->validated();
            $car = $this->carService->updateCar($id, $validated);
            $car->load(['comfortCategory', 'driver.employee.user', 'carModel.brand', 'color']);

            return response()->json([
                'success' => true,
                'message' => 'Автомобиль успешно обновлен',
                'data' => new CarResource($car)
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Автомобиль не найден'
            ], 404);
            
        } catch (\Exception $e) {
            Log::error('CarController update error: ' . $e->getMessage(), [
                'car_id' => $id,
                'data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Ошибка при обновлении автомобиля',
                'error_details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->carService->deleteCar($id);

            return response()->json([
                'success' => true,
                'message' => 'Автомобиль успешно удален'
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Автомобиль не найден'
            ], 404);
            
        } catch (\Exception $e) {
            Log::error('CarController destroy error: ' . $e->getMessage(), [
                'car_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Ошибка при удалении автомобиля',
                'error_details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function getAvailableCars(): JsonResponse
    {
        try {
            $cars = $this->carService->getAvailableCars();

            return response()->json([
                'success' => true,
                'data' => new CarCollection($cars)
            ]);

        } catch (\Exception $e) {
            Log::error('CarController getAvailableCars error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Ошибка при загрузке доступных автомобилей',
                'error_details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}