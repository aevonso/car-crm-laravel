<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'license_number',
        'licence_category',
        'license_expiry_date',
        'is_active'
    ];

    protected $casts = [
        'license_expiry_date' => 'date',
        'is_active' => 'boolean'
    ];

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class);
    }

    public function car(): HasOne {
        return $this->hasOne(Car::class);
    }
    
}
