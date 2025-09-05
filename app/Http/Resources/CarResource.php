<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'model' => $this->carModel->name,
            'brand' => $this->carModel->brand->name,
            'color' => $this->color->name,
            'license_plate' => $this->license_plate,
            'year' => $this->year,
            'mileage' => $this->mileage,
            'comfort_category' => [
                'id' => $this->comfortCategory->id,
                'name' => $this->comfortCategory->name,
                'level' => $this->comfortCategory->level
            ],
            'driver' => [
                'id' => $this->driver->id,
                'name' => $this->driver->employee->first_name . ' ' . $this->driver->employee->last_name,
                'license_number' => $this->driver->license_number
            ],
            'features' => $this->features,
            'is_active' => $this->is_active
        ];
    }
}