<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = ['equipment', 'quantity'];

    public function gyms()
    {
        return $this->belongsToMany(Gym::class, 'gym_equipment', 'equipment_id', 'gym_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
