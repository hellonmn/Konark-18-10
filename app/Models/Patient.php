<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'age',
        'gender',
        'source',
        'doctor',
        'medical_history',
        'appointment_date',
        'appointment_time',
        'services',
        'coupon',
        'discount',
        'amount',
        'payment_status',
    ];
    
    public function serviceList()
    {
        return Service::whereIn('id', $this->services)->get();
    }


    public function services()
    {
        return $this->belongsToMany(Service::class, 'patient_service', 'patient_id', 'service_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
