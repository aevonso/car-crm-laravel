<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

 
    protected $fillable = [
        'employee_id',
        'car_id',
        'start_time',
        'end_time',
        'purpose',
        'destination',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public static function getStatuses(): array
    {
        return ['pending', 'approved', 'rejected', 'completed', 'cancelled'];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }


    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }


    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }


    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }


    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }


    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

 
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }


    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

 
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}