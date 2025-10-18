<?php

namespace App\Exports;

use App\Models\Doctor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DoctorsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Doctor::all()->map(function ($doctor) {
            return [
                'ID' => $doctor->id,
                'Name' => $doctor->name,
                'Phone' => $doctor->phone,
                'Email' => $doctor->email,
                'Profile Picture' => $doctor->profile_picture,
                'SP ID' => $doctor->sp_id,
                'Clinic Name' => $doctor->clinic_name,
                'Clinic Location' => $doctor->clinic_location,
                'GPay Number' => $doctor->gpay_number,
                'UPI' => $doctor->upi,
                'Representative' => $doctor->representative,
                'Meeting Purpose' => $doctor->meeting_purpose,
                'Feedback' => $doctor->feedback,
                'Konark Team' => $doctor->konark_team,
                'Inactive Days' => $this->getInactiveDaysForDoctor($doctor->id),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Phone',
            'Email',
            'Profile Picture',
            'SP ID',
            'Clinic Name',
            'Clinic Location',
            'GPay Number',
            'UPI',
            'Representative',
            'Meeting Purpose',
            'Feedback',
            'Konark Team',
            'Inactive Days',
        ];
    }

    public function getInactiveDaysForDoctor($doctorId)
    {
        // Find the doctor by their ID
        $doctor = Doctor::with('patients')->find($doctorId);
    
        if ($doctor) {
            // Fetch the number of inactive days for this doctor
            $inactiveDays = $doctor->exportDaysInactive();
    
            // Check if $inactiveDays is numeric
            if (is_numeric($inactiveDays)) {
                // Convert the inactive days to a positive integer and format the string
                $roundedDays = abs(round($inactiveDays));
                return $roundedDays . ' ' . ($roundedDays == 1 ? 'day' : 'days');
            } else {
                return 'Invalid data';
            }
        } else {
            return 'Doctor not found';
        }
    }



}
