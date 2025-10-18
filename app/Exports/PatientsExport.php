<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PatientsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Fetch the data you want to export
        return Patient::all();
    }

    public function headings(): array
    {
        // Define the headings for the columns
        return [
            'ID',
            'Name',
            'Phone',
            'Email',
            'Age',
            'Gender',
            'Source',
            'Medical History',
            'Appointment Date',
            'Appointment Time',
            'Doctor',
            'Services',
            'Coupon',
            'Discount',
            'Amount',
            'Payment Status',
            'Payment Date',
            'Payment Method',
            'Receipt ID',
        ];
    }
}
