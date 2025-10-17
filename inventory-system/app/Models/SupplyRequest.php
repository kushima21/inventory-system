<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyRequest extends Model
{
    use HasFactory;

    protected $table = 'supply_requests';

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'date_needed',
        'supply_name',
        'quantity',
        'request_status',   // Default: Pending
        'date_approved',    // Nullable
        'date_completed',   // Nullable
        'date_cancelled',   // Nullable
        'date_declined',   // Nullable
        'reason',           // Nullable
        'created_at',           // Nullable
        'updated_at',           // Nullable
    ];
}
