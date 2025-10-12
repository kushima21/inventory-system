<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentBundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'quantity',
        'price',
        'created_at',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
