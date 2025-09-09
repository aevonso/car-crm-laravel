<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $carId = $this->route('car');

        return [
            'model_id' => 'sometimes|exists:car_models,id',
            'color_id' => 'sometimes|exists:colors,id',
            'comfort_category_id' => 'sometimes|exists:comfort_categories,id',
            'driver_id' => 'sometimes|exists:drivers,id',
            'license_plate' => [
                'sometimes',
                'string',
                'max:20',
                Rule::unique('cars', 'license_plate')->ignore($carId)
            ],
            'vin_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('cars', 'vin_code')->ignore($carId)
            ],
            'year' => 'sometimes|integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'sometimes|integer|min:0',
            'is_active' => 'sometimes|boolean',
            'features' => 'nullable|array'
        ];
    }

    public function messages(): array
    {
        return [
            'model_id.exists' => 'Указанная модель не существует',
            'color_id.exists' => 'Указанный цвет не существует',
            'comfort_category_id.exists' => 'Указанная категория комфорта не существует',
            'driver_id.exists' => 'Указанный водитель не существует',
            'license_plate.unique' => 'Автомобиль с таким госномером уже существует',
            'license_plate.max' => 'Госномер не должен превышать 20 символов',
            'vin_code.unique' => 'Автомобиль с таким VIN-кодом уже существует',
            'vin_code.max' => 'VIN-код не должен превышать 50 символов',
            'year.min' => 'Год выпуска должен быть не менее 1900',
            'year.max' => 'Год выпуска не может быть больше текущего',
            'mileage.min' => 'Пробег не может быть отрицательным',
            'is_active.boolean' => 'Статус активности должен быть true или false'
        ];
    }
}