<?php

namespace App\Services;

use App\Models\Car;
use App\Models\Employee;
use Illuminate\Support\Carbon;
use App\Exceptions\EmployeePositionException;
use App\Exceptions\NoComfortCategoriesException;

class CarAvailabilityService
{
 
    public function getAvailableCars(Employee $employee, Carbon $startTime, Carbon $endTime, array $filters = [])
    {
        if (!$employee->position) {
            throw new EmployeePositionException(
                "Employee #{$employee->id} does not have a position assigned"
            );
        }

        if (!$employee->position->relationLoaded('comfortCategories')) {
            $employee->position->load('comfortCategories');
        }

        if ($employee->position->comfortCategories->isEmpty()) {
            throw new NoComfortCategoriesException(
                "Position '{$employee->position->name}' has no comfort categories assigned"
            );
        }

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

        return $query->get();
    }
}