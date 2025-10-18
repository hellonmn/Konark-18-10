<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Check user role and redirect representatives
        if (Auth::check() && Auth::user()->role == "representative") {
            return redirect()->route('representative.location');
        }elseif (Auth::check() && Auth::user()->role == "admin") {
            
            // Proceed with dashboard logic for admins
        $fromDate = null;
        $toDate = null;
        $isDateFilterActive = false;

        // Handle date filters
        if ($request->has('fromDate') && $request->has('toDate')) {
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
        }

        $patientsQuery = Patient::query();
        if ($fromDate && $toDate) {
            $patientsQuery->whereBetween('appointment_date', [$fromDate, $toDate]);
            $isDateFilterActive = true;
        }
        $patients = $patientsQuery->get();

        // Map patient services
        $patientsWithServices = $patients->map(function ($patient) {
            $serviceIds = json_decode($patient->services, true);
            $services = Service::whereIn('id', $serviceIds ?: [])->pluck('name')->toArray();
            $patient->service_names = $services;
            return $patient;
        });

        // Calculate total revenue
        $totalRevenue = $patients->sum('amount');

        // Gender distribution
        $genderDistribution = $patients->groupBy('gender')->map->count();

        // Age group distribution
        $ageGroups = [
            'Under 18' => 0,
            '18-30' => 0,
            '31-45' => 0,
            '46-60' => 0,
            '61 and above' => 0,
        ];
        foreach ($patients as $patient) {
            $age = (int) $patient->age;
            if ($age < 18) {
                $ageGroups['Under 18']++;
            } elseif ($age >= 18 && $age <= 30) {
                $ageGroups['18-30']++;
            } elseif ($age >= 31 && $age <= 45) {
                $ageGroups['31-45']++;
            } elseif ($age >= 46 && $age <= 60) {
                $ageGroups['46-60']++;
            } else {
                $ageGroups['61 and above']++;
            }
        }

        // Monthly statistics
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $newPatientsThisMonth = Patient::whereYear('appointment_date', $currentYear)
            ->whereMonth('appointment_date', $currentMonth)
            ->count();
        $revenueThisMonth = Patient::whereYear('appointment_date', $currentYear)
            ->whereMonth('appointment_date', $currentMonth)
            ->sum('amount');

        // Monthly revenue for line chart
        $monthlyRevenue = Patient::selectRaw('YEAR(appointment_date) as year, MONTH(appointment_date) as month, SUM(amount) as total')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
        $monthlyLabels = $monthlyRevenue->map(function ($row) {
            return $row->year . '-' . str_pad($row->month, 2, '0', STR_PAD_LEFT);
        })->toArray();
        $monthlyValues = $monthlyRevenue->pluck('total')->toArray();

        // Recent Appointments
        $recentAppointments = Patient::orderBy('appointment_date', 'desc')->take(5)->get();

        // Current month and year
        $currentDate = Carbon::now();
        $previousMonth = $currentDate->copy()->subMonth()->format('m');
        $previousYear = $currentDate->copy()->subMonth()->format('Y');
        $nextMonth = $currentDate->copy()->addMonth()->format('m');
        $nextYear = $currentDate->copy()->addMonth()->format('Y');

        // Initialize patient count for the current month
        $patientsCount = Patient::whereMonth('appointment_date', $currentMonth)
            ->whereYear('appointment_date', $currentYear)
            ->count();

        return view('dashboard', compact(
            'patientsWithServices',
            'totalRevenue',
            'genderDistribution',
            'ageGroups',
            'newPatientsThisMonth',
            'revenueThisMonth',
            'recentAppointments',
            'monthlyLabels',
            'monthlyValues',
            'fromDate',
            'toDate',
            'isDateFilterActive',
            'patientsCount',
            'currentMonth',
            'currentYear',
            'previousMonth',
            'previousYear',
            'nextMonth',
            'nextYear'
        ));
        }else{
            abort(403, "Access denied");
        }

        
    }

    public function getPatientCount(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $patientsCount = Patient::whereYear('appointment_date', $year)
            ->whereMonth('appointment_date', $month)
            ->count();

        return response()->json(['patientsCount' => $patientsCount]);
    }
}
