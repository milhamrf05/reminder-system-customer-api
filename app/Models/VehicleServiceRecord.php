<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleServiceRecord extends Model
{
    use HasFactory;

    protected $table = 'vehicle_service_records';

    protected $fillable = [
        'chassis_number',
        'license_plate_number',
        'interval_to_now_id',
        'last_service',
        'customer_name',
        'customer_phone_number',
        'vehicle_model',
        'delivery_date',
        'service_advisor_name',
        'program_name',
        'sales_branch',
    ];

    protected $dates = [
        'last_service',
        'delivery_date',
    ];

    public function intervalToNow()
    {
        return $this->belongsTo(IntervalToNow::class);
    }

}
