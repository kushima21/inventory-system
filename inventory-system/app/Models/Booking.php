<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking_tbl'; // if your table is booking_tbl

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
    'booking_status',
];

}
