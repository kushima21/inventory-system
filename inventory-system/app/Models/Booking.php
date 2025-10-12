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
        'booking_status',
    ];
}
