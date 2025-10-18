<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Coupon;
use App\Models\Service;
use App\Exports\PatientsExport;
use Maatwebsite\Excel\Facades\Excel;

class PatientController extends Controller
{
    public function index(Request $request){
        $query = Patient::query()->orderBy('created_at', 'desc');

        // Filter by date range if provided
        if ($request->has('date_filter')) {
            switch ($request->input('date_filter')) {
                case 'last_day':
                    $query->where('appointment_date', '>=', now()->subDay());
                    break;
                case 'last_7_days':
                    $query->where('appointment_date', '>=', now()->subDays(7));
                    break;
                case 'last_30_days':
                    $query->where('appointment_date', '>=', now()->subDays(30));
                    break;
                case 'last_month':
                    $query->whereMonth('appointment_date', now()->subMonth()->month)
                        ->whereYear('appointment_date', now()->subMonth()->year);
                    break;
                case 'last_year':
                    $query->whereYear('appointment_date', now()->subYear()->year);
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        }

        $filter = $request->input('date_filter');

        $services = Service::get();
        $doctors = Doctor::get();
        $patients = $query->get();
        $data = compact('patients', 'filter', 'services', 'doctors');
        return view('patients.index')->with($data);
    }

    public function getPatients($doctorId) {
        $patients = Patient::where('doctor', $doctorId)->get();
        $events = [];

        foreach ($patients as $patient) {
            $events[] = [
                'title' => $patient->name,
                'start' => $patient->appointment_date,
            ];
        }

        return response()->json($events);
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->route('patients.show')->with('success', 'Patient deleted successfully.');
    }
    
public function uploadPatients(Request $request)
{
    // Validate the uploaded file
    $request->validate([
        'file' => 'required|file|mimes:csv,txt', // Ensure a file is uploaded and it's a CSV or text file
    ]);

    $file = $request->file('file');

    // Process the uploaded file
    $path = $file->getRealPath();
    $data = array_map('str_getcsv', file($path));

    // Remove the header row
    $headers = array_shift($data);

    foreach ($data as $row) {
        // Skip rows that don't have complete data
        if (count($row) < 9) {
            continue;
        }

        // Validate each row of data
        $validator = \Validator::make([
            'name' => $row[0],
            'phone' => $row[1],
            'email' => $row[2],
            'age' => $row[3],
            'appointment_date' => $row[8],
            'appointment_time' => $row[9],
        ], [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'age' => 'required|integer',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|string',
        ]);

        // If validation fails, skip the row
        if ($validator->fails()) {
            continue;
        }
        if($row[6] != "Doctor"){
            $doctor = null;
        }else{
            $doctor = $row[6];
        }
        // Insert the data into the database
        $patient = new Patient([
            'name' => $row[0],
            'phone' => $row[1],
            'email' => $row[2],
            'age' => $row[3],
            'gender' => $row[4] ?? null,
            'source' => $row[5] ?? "Social Media/Google",
            'doctor' => $doctor,
            'medical_history' => $row[7] ?? null,
            'appointment_date' => $row[8],
            'appointment_time' => $row[9],
            'services' => $row[10] ?? null,
            'coupon' => $row[11] ?? null,
            'discount' => $row[12] ?? null,
            'amount' => $row[13] ?? null,
            'payment_status' => $row[14] ?? null,
        ]);

        $patient->save();
    }

    return redirect()->route('patients.show')->with('success', 'Patients uploaded successfully.');
}


    public function export()
    {
        return Excel::download(new PatientsExport, 'patients.xlsx');
    }

    public function edit($id){
        $doctors = Doctor::get();
        $services = Service::get();
        $coupons = Coupon::get();
        $patient = Patient::find($id);
        $data = compact('patient', 'doctors', 'services', 'coupons');
        return view('patients.edit')->with($data);
    }

    public function generalUpdate(Request $request, $id){

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:12',
            'email' => 'nullable|email',
            'age' => 'nullable|numeric',
            'gender' => 'nullable|string',
            'medical_history' => 'nullable|string',
        ]);

        $patient = Patient::find($id);

        if($patient){
            $patient->name = $validatedData['name'];
            $patient->phone = $validatedData['phone'];
            $patient->email = $validatedData['email'];
            $patient->age = $validatedData['age'];
            $patient->gender = $validatedData['gender'];
            $patient->medical_history = $validatedData['medical_history'];
            $patient->save();
        }else{
            return redirect()->route('patients.show');
        }
        return redirect()->route('patients.show');
    }
    
    public function financeUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'coupon' => 'nullable|string',
            'discount' => 'nullable|string',
            'amount' => 'nullable|string',
        ]);
    
        $patient = Patient::find($id);
    
        if ($patient) {
            
            if($validatedData['coupon'] == 'No coupon'){
                $patient->coupon = null;
            }else{
                $patient->coupon = $validatedData['coupon'];
            }
            $patient->discount = $validatedData['discount'];
            $patient->amount = $validatedData['amount'];
            $patient->save();
    
            return redirect()->route('patients.show')->with('success', 'Finance details updated successfully.');
        } else {
            return redirect()->route('patients.show')->with('error', 'Patient not found.');
        }
    }


    public function additionalUpdate(Request $request, $id){

        $validatedData = $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|string',
            'selected_services' => 'required|string',
        ]);

        // $selectedServiceIdsArray = explode(",", $validatedData['selected_services']);
        // return $selectedServiceIdsArray;
        $patient = Patient::find($id);

        if($patient){
            $patient->appointment_date = $validatedData['appointment_date'];
            $patient->appointment_time = $validatedData['appointment_time'];
            $patient->services = $validatedData['selected_services'];
            $patient->save();
        }else{
            return redirect()->route('patients.show')->with('success', 'Additional details updation failed.');
        }
        return redirect()->route('patients.show')->with('success', 'Additional details updated successfully.');
    }

    public function marketingUpdate(Request $request, $id){

        $validatedData = $request->validate([
            'source' => 'required|string',
            'doctor' => 'nullable|string',
        ]);

        $patient = Patient::find($id);

        if($patient){
            if($validatedData['source'] == 'Social Media / Google'){
                $patient->source = $validatedData['source'];
                $patient->doctor = null;
                $patient->save();
            }else if($validatedData['source'] == 'Doctor'){
                $patient->source = $validatedData['source'];
                $patient->doctor = $validatedData['doctor'];
                $patient->save();
                
            }
        }else{
            return redirect()->route('patients.show');
        }
        return redirect()->route('patients.show');
    }
}
