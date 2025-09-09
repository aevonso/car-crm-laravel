<?php

namespace App\Http\Requests\Api\Car;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'model_id' => 'required|exists:car_models,id',
            'color_id' => 'required|exists:colors,id',
            'comfort_category_id' => 'required|exists:comfort_categories,id',
            'driver_id' => 'required|exists:drivers,id',
            'license_plate' => [
                'required',
                'string',
                'max:20',
                Rule::unique('cars', 'license_plate')
            ],
            'vin_code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('cars', 'vin_code')
            ],
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'required|integer|min:0',
            'is_active' => 'sometimes|boolean',
            'features' => 'nullable|array'
        ];
    }

    public function messages(): array
    {
        return [
            'model_id.required' => 'ID модели обязателен',
            'model_id.exists' => 'Указанная модель не существует',
            
            'color_id.required' => 'ID цвета обязателен',
            'color_id.exists' => 'Указанный цвет не существует',
            
            'comfort_category_id.required' => 'ID категории комфорта обязателен',
            'comfort_category_id.exists' => 'Указанная категория комфорта не существует',
            
            'driver_id.required' => 'ID водителя обязателен',
            'driver_id.exists' => 'Указанный водитель не существует',
            
            'license_plate.required' => 'Госномер обязателен',
            'license_plate.unique' => 'Автомобиль с таким госномером уже существует',
            'license_plate.max' => 'Госномер не должен превышать 20 символов',
            
            'vin_code.unique' => 'Автомобиль с таким VIN-кодом уже существует',
            'vin_code.max' => 'VIN-код не должен превышать 50 символов',
            
            'year.required' => 'Год выпуска обязателен',
            'year.min' => 'Год выпуска должен быть не менее 1900',
            'year.max' => 'Год выпуска не может быть больше текущего',
            
            'mileage.required' => 'Пробег обязателен',
            'mileage.min' => 'Пробег не может быть отрицательным',
            
            'is_active.boolean' => 'Статус активности должен быть true или false'
        ];
    }
}