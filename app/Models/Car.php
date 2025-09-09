<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'color_id',
        'comfort_category_id',
        'driver_id',
        'license_plate',
        'vin_code',
        'year',
        'mileage',
        'is_active',
        'features'
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean'
    ];

    public function driver(): BelongsTo 
    {
        return $this->belongsTo(Driver::class);
    }

    public function carModel(): BelongsTo 
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }

    public function color(): BelongsTo 
    {
        return $this->belongsTo(Color::class);
    }

    public function comfortCategory(): BelongsTo 
    {
        return $this->belongsTo(ComfortCategory::class, 'comfort_category_id');
    }

    public function bookings(): HasMany 
    {
        return $this->hasMany(Booking::class);
    }
}