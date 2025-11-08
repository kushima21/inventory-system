<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentInventory extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'equipment_inventory';

    // Primary key
    protected $primaryKey = 'id';

    // Disable automatic timestamps since you customized them
    public $timestamps = false;

    // Fillable fields (for mass assignment)
    protected $fillable = [
        'equipment_name',
        'quantity',
        'created_at',
        'updated_at',
    ];
}
