<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function comfortCategories(): BelongsToMany {
        return $this->belongsToMany(ComfortCategory::class, 'postion_comfort_category');
    }

    public function employees() {
        return $this->hasMany(Employee::class);
    }
}
