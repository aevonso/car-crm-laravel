<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarModel extends Model
{
    use HasFactory;

    protected $table = 'car_models'; 

    protected $fillable = [
        'brand_id',
        'name',
        'description'
    ];

    public function brand(): BelongsTo 
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function cars(): HasMany 
    {
        return $this->hasMany(Car::class, 'model_id');
    }
}