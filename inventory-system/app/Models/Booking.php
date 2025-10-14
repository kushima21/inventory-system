<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking_tbl'; // ✅ must match your DB table name
    protected $primaryKey = 'booking_id'; // ✅ use booking_id instead of id
    public $timestamps = true; // ✅ if you have created_at and updated_at

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
        'cancel_reason'
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class, 'gym_id', 'id');
    }

    public function additionalEquipments()
    {
        return $this->hasMany(\App\Models\AdditionalEquipment::class, 'booking_id', 'booking_id');
    }
}
