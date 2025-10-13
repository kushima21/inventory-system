<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking_tbl'; // ✅ your actual table name

    protected $primaryKey = 'booking_id'; // ✅ your table's primary key

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'name',
        'contact_number',
        'address',
        'starting_date',
        'end_date',
        'gym_id',
        'equipment_id',
        'total_days',
        'total_price',
        'additional_total',
        'booking_status',
        'date_approved',
        'date_completed',
        'date_cancelled',
    ];

    public function gym()
{
    return $this->belongsTo(Gym::class, 'gym_id');
}

public function additionalEquipments()
{
    return $this->hasMany(AdditionalEquipment::class, 'booking_id');
}

public function selectedEquipment()
{
    // Assuming you save equipment IDs as JSON array in booking_tbl.equipment_id
    $equipmentIds = json_decode($this->equipment_id, true);

    if (!$equipmentIds || !is_array($equipmentIds)) return collect();

    return \App\Models\Equipment::whereIn('id', $equipmentIds)->get();
}
}
