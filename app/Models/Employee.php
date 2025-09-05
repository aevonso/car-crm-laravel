<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'first_name',
        'last_name',
        'patronymic',
        'phone',
        'position_id'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
  public function position(): BelongsTo 
    {
        return $this->belongsTo(Position::class);
    }
    public function driver() {
        return $this->hasOne(Driver::class);
    }
}
