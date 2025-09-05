<?php

namespace App\Services;

use App\Models\Car;
use App\Models\Employee;
use Illuminate\Support\Carbon;

class CarAvailabilityService
{
    public function getAvailableCars(Employee $employee, Carbon $startTime, Carbon $endTime, array $filters = [])
    {
        $availableCategoryIds = $employee->position->comfortCategories->pluck('id');

        $query = Car::with(['comfortCategory', 'driver.employee', 'carModel.brand', 'color'])
            ->whereIn('comfort_category_id', $availableCategoryIds)
            ->where('is_active', true)
            ->whereDoesntHave('bookings', function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->whereBetween('start_time', [$startTime, $endTime])
                      ->orWhereBetween('end_time', [$startTime, $endTime])
                      ->orWhere(function ($q2) use ($startTime, $endTime) {
                          $q2->where('start_time', '<=', $startTime)
                             ->where('end_time', '>=', $endTime);
                      });
                })->whereIn('status', ['approved', 'pending']);
            });

        if (isset($filters['model'])) {
            $query->whereHas('carModel', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['model'] . '%');
            });
        }

        if (isset($filters['comfort_category'])) {
            $query->where('comfort_category_id', $filters['comfort_category']);
        }

        if (isset($filters['brand'])) {
            $query->whereHas('carModel.brand', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['brand'] . '%');
            });
        }

        return $query->get();
    }
}