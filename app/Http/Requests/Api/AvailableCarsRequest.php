<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AvailableCarsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'model' => 'sometimes|string|max:255',
            'comfort_category' => 'sometimes|exists:comfort_categories,id',
            'brand' => 'sometimes|string|max:255'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            
            'model.string' => 'Модель должна быть строкой',
            'model.max' => 'Модель не должна превышать 255 символов',
            
            'comfort_category.exists' => 'Указанная категория комфорта не существует',
            
            'brand.string' => 'Бренд должен быть строкой',
            'brand.max' => 'Бренд не должен превышать 255 символов'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'start_time' => 'время начала',
            'end_time' => 'время окончания',
            'model' => 'модель',
            'comfort_category' => 'категория комфорта',
            'brand' => 'бренд'
        ];
    }
}