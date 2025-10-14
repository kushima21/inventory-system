<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gym extends Model
{
    protected $table = 'gym_table';
    protected $fillable = ['package', 'price', 'default_items'];

    protected $casts = [
        'default_items' => 'array',
    ];

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'gym_equipment', 'gym_id', 'equipment_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
