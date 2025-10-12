<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalEquipment extends Model
{
    use HasFactory;

    protected $table = 'additional_equipments'; // or your actual table name

    protected $fillable = [
        'booking_id',
        'equipment_name',
        'quantity',
        'price',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
