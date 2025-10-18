<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\RepresentativeLocation;
use Carbon\Carbon;

class RepresentativeController extends Controller
{
    public function index(Request $request)
{
    $query = User::where('role', 'like', '%representative%');
    
    // Search functionality
    if ($request->has('search')) {
        $searchTerm = $request->search;
        $query->where(function($q) use ($searchTerm) {
            $q->where('name', 'like', "%{$searchTerm}%")
              ->orWhere('email', 'like', "%{$searchTerm}%");
        });
    }
    
    // Role filter
    if ($request->has('role') && $request->role !== '') {
        $query->where('role', $request->role);
    }
    
    // Pagination
    $representatives = $query->orderBy('created_at', 'desc')
                            ->paginate(9);
    
    // Get statistics for dashboard
    $totalRepresentatives = User::where('role', 'like', '%representative%')->count();
    $activeRepresentatives = User::where('role', 'like', '%representative%')
                                ->count();
    $lastAdded = User::where('role', 'like', '%representative%')
                    ->latest()
                    ->first();
    
    $data = [
        'representatives' => $representatives,
        'totalRepresentatives' => $totalRepresentatives,
        'activeRepresentatives' => $activeRepresentatives,
        'lastAdded' => $lastAdded,
        'search' => $request->search,
        'roleFilter' => $request->role
    ];
    
    return view('representative.admin.index')->with($data);
}

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:representative',
        ]);

        // Create a new User instance and save data to it
        $representative = new User;
        $representative->name = $request->input('name');
        $representative->email = $request->input('email');
        $representative->password = Hash::make($request->input('password'));
        $representative->role = $request->input('role');
        $representative->save();

        // Redirect to the representatives index route after saving
        return redirect()->route('representatives.show')->with('success', 'Representative added successfully.');
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
            'role' => 'required|in:representative',
        ]);

        // Find the representative
        $representative = User::findOrFail($id);

        // Update the representative's data
        $representative->name = $request->input('name');
        $representative->email = $request->input('email');
        $representative->role = $request->input('role');
        if ($request->filled('password')) {
            $representative->password = Hash::make($request->input('password'));
        }
        $representative->save();

        // Redirect to the representatives index route after updating
        return redirect()->route('representatives.show')->with('success', 'Representative updated successfully.');
    }

    public function destroy($id)
    {
        // Find the representative
        $representative = User::findOrFail($id);

        // Delete therepresentative
        $representative->delete();

        // Redirect to the representatives index route after deleting
        return redirect()->route('representatives.show')->with('success', 'Representative deleted successfully.');
    }

    public function showRepresentativeDetails(Request $request, $id)
    {
        $representative = User::where('role', 'representative')->findOrFail($id);
        
        // Build doctor query with date range filter
        $doctorQuery = Doctor::where('representative_id', $id);
        
        if ($request->has('start_date') && $request->start_date) {
            $doctorQuery->whereDate('created_at', '>=', Carbon::parse($request->start_date));
        }
        
        if ($request->has('end_date') && $request->end_date) {
            $doctorQuery->whereDate('created_at', '<=', Carbon::parse($request->end_date));
        }

        $doctors = $doctorQuery->get();
        $doctor_count = $doctors->count();

        // Fetch locations that are not linked to a doctor ID (non-numeric type)
        $locationsQuery = RepresentativeLocation::where('user_id', $id)
            ->whereRaw('type REGEXP "^[a-zA-Z]+$"') // Only non-numeric types
            ->orderBy('created_at', 'desc');

        // Apply date filters to locations if provided
        if ($request->has('start_date') && $request->start_date) {
            $locationsQuery->whereDate('created_at', '>=', Carbon::parse($request->start_date));
        }
        if ($request->has('end_date') && $request->end_date) {
            $locationsQuery->whereDate('created_at', '<=', Carbon::parse($request->end_date));
        }

        $locations = $locationsQuery->get();

        // Fetch locations linked to doctors (type matches doctor ID)
        $doctorLocations = RepresentativeLocation::where('user_id', $id)
            ->whereIn('type', $doctors->pluck('id')->toArray())
            ->orderBy('created_at', 'desc')
            ->get()
            ->keyBy('type'); // Key by type (doctor ID) for easy lookup

        return view('representative.admin.details', compact('representative', 'doctors', 'locations', 'doctor_count', 'doctorLocations'));
    }

    public function destroyDoctor($id)
    {
        // Find the doctor by ID
        $doctor = Doctor::findOrFail($id);

        // Check if the doctor is linked to any patients
        $linkedPatients = \App\Models\Patient::where('doctor', $doctor->id);

        if ($linkedPatients->count() > 0) {
            // Set the doctor column to NULL for linked patients
            $linkedPatients->update(['doctor' => null]);
        }

        // Delete the doctor
        $doctor->delete();

        // Redirect back to the previous route with a success message
        return redirect()->back()->with('success', 'Doctor deleted successfully.');
        // return redirect()->route('representatives.show')->with('success', 'Representative deleted successfully.');
    }
}
