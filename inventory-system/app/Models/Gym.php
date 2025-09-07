<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    protected $table = 'gym_table'; // kung mao ni imong table name
    protected $fillable = ['package', 'price'];

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'gym_equipment', 'gym_id', 'equipment_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
