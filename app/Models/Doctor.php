<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'sp_id',
        'clinic_name',
        'clinic_location',
        'gpay_number',
        'upi',
        'representative',
        'meeting_purpose',
        'feedback',
        'by_team',
    ];



    public function patients()
    {
        return $this->hasMany(Patient::class, 'doctor');
    }

    public function totalOpg()
    {
        $lastPatient = $this->patients()->latest('created_at')->first();

        if ($lastPatient) {
            // Calculate the absolute number of days and cast to an integer
            return (int) abs(now()->diffInDays($lastPatient->created_at));
        }

        // If no patients, calculate from the doctor's creation date and cast to an integer
        return (int) abs(now()->diffInDays($this->created_at));
    }
    
    public function daysInactive()
    {
        $lastPatient = $this->patients()->latest('created_at')->first();

        if ($lastPatient) {
            // Calculate the absolute number of days and cast to an integer
            return (int) abs(now()->diffInDays($lastPatient->created_at));
        }

        // If no patients, calculate from the doctor's creation date and cast to an integer
        return (int) abs(now()->diffInDays($this->created_at));
    }

    public function exportDaysInactive()
    {
        // Assuming you are calculating inactivity based on the last patient appointment
        $lastAppointmentDate = $this->patients()->latest('created_at')->value('created_at');

        if ($lastAppointmentDate) {
            $lastAppointment = \Carbon\Carbon::parse($lastAppointmentDate);
            return $lastAppointment->diffInDays(now());
        } else {
            // If the doctor has no patients, return a high number or a default value
            return 'No appointments';
        }
    }






}
