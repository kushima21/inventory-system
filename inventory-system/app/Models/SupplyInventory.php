<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyInventory extends Model
{
    use HasFactory;

    // ✅ Table name (optional kung pareho lang sa plural name)
    protected $table = 'supply_inventory';

    // ✅ Primary key
    protected $primaryKey = 'id';

    // ✅ Fields nga pwede ma-fill during mass assignment
    protected $fillable = [
        'supply_name',
        'quantity',
    ];

    // ✅ Automatic timestamps (created_at, updated_at)
    public $timestamps = true;
}
