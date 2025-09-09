<?php

namespace App\Services;

use App\Models\Car;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class CarService
{
    public function getAllCars()
    {
        try {
            return Car::with([
                'comfortCategory', 
                'driver.employee', 
                'carModel.brand', 
                'color'
            ])->where('is_active', true)->get();
            
        } catch (\Exception $e) {
            Log::error('Ошибка при получении автомобилей: ' . $e->getMessage());
            throw new \Exception('Ошибка сервера при получении автомобилей');
        }
    }

    public function getCarById($id)
    {
        try {
            $car = Car::with([
                'comfortCategory', 
                'driver.employee', 
                'carModel.brand', 
                'color',
                'bookings.employee'
            ])->find($id);

            if (!$car) {
                throw new ModelNotFoundException('Автомобиль не найден');
            }

            return $car;
            
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Ошибка при получении автомобиля: ' . $e->getMessage());
            throw new \Exception('Ошибка сервера при получении автомобиля');
        }
    }

    public function createCar(array $data)
    {
        try {
            return Car::create($data);
            
        } catch (\Exception $e) {
            Log::error('Ошибка при создании автомобиля: ' . $e->getMessage());
            throw new \Exception('Ошибка сервера при создании автомобиля');
        }
    }

    public function updateCar($id, array $data)
    {
        try {
            $car = Car::find($id);

            if (!$car) {
                throw new ModelNotFoundException('Автомобиль не найден');
            }

            $car->update($data);
            return $car;
            
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Ошибка при обновлении автомобиля: ' . $e->getMessage());
            throw new \Exception('Ошибка сервера при обновлении автомобиля');
        }
    }

    public function deleteCar($id)
    {
        try {
            $car = Car::find($id);

            if (!$car) {
                throw new ModelNotFoundException('Автомобиль не найден');
            }

            $car->update(['is_active' => false]);
            return true;
            
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Ошибка при удалении автомобиля: ' . $e->getMessage());
            throw new \Exception('Ошибка сервера при удалении автомобиля');
        }
    }
}