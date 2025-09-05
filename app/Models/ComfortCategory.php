<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ComfortCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'level'];

    public function positions(): BelongsToMany {
        return $this->belongsToMany(Position::class, 'position_comfort_category');
    }

    public function cars() {
        return $this->hasMany(Car::class);
    }
}
