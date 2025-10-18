<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\RepresentativeLocation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class RepresentativeLocationController extends Controller
{
    public function index(Request $request)
    {
        $id = Auth::user()->id;
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
        $locations = RepresentativeLocation::where('user_id', $id)->orderBy('created_at', 'desc')->get();

        return view('representative.index', compact('representative', 'doctors', 'locations', 'doctor_count'));
    }

    public function store2(Request $request)
{
    try {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $representative = new RepresentativeLocation([
            'user_id' => $request->user()->id,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'type' => 'manual',
        ]);
        

        $representative->save();

        return response()->json(['message' => 'Location saved successfully']);
    } catch (\Exception $e) {
        \Log::error('Error saving location: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to save location'], 500);
    }
}

public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'type' => 'required|in:In,Out',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        // Save representative location
        $location = new RepresentativeLocation();
        $location->user_id = Auth::user()->id;
        $location->latitude = $request->latitude;
        $location->longitude = $request->longitude;
        $location->type = $request->type;
        $location->save();

        return response()->json(['message' => 'Location saved successfully']);
    }
}
