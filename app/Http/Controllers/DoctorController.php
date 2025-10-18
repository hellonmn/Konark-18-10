<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use App\Models\Service;
use App\Models\RepresentativeLocation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Exports\DoctorsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Sendpulse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DoctorController extends Controller
{
    
    use Sendpulse;
    
    public function index(Request $request)
    {
        $query = Doctor::query();
    
            $fromDate = null;
            $toDate = null;
        // Apply search filter if present
        if($request->has('fromDate') && $request->has('toDate')){
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
        }
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%")
                  ->orWhere('clinic_name', 'like', "%$search%")
                  ->orWhere('clinic_location', 'like', "%$search%");
        }
    
        // Apply sorting if present
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            switch ($sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'clinic_name_asc':
                    $query->orderBy('clinic_name', 'asc');
                    break;
                case 'clinic_name_desc':
                    $query->orderBy('clinic_name', 'desc');
                    break;
                default:
                    break;
            }
        }
        
        $opg = 0;
        $cbct = 0;
        $abc = null;
        $isDateFilterActive = null;

        
        
    
        $doctors = $query->where('status', 'active')->orWhereNull('status')->get();

        foreach ($doctors as $doctor) {
            $doctor->inactiveDays = $this->getInactiveDaysForDoctor($doctor->id);
        
            // Reset counters per doctor
            $opg = 0;
            $cbct = 0;
            if($request->has('fromDate') && $request->has('toDate')){
                $abc = Doctor::with(['patients' => function ($query) use ($fromDate, $toDate) {
                    $query->whereBetween('appointment_date', [$fromDate, $toDate]);
                }])->find($doctor->id);
                $isDateFilterActive = true;
            } else {
                $abc = Doctor::with('patients')->find($doctor->id);
                $isDateFilterActive = false;
            }
        
            foreach($abc->patients as $patient){
                foreach(json_decode($patient->services) as $service){
                    $fetchService = Service::find($service);
                    if($fetchService){
                        if($fetchService->type == 'OPG'){
                            $opg++;
                        } else if($fetchService->type == 'CBCT'){
                            $cbct++;
                        }
                    }
                }
            }
        
            $doctor->opgCount = $opg;
            $doctor->cbctCount = $cbct;
        }

        

    
        return view('doctors.index', compact('doctors', 'abc', 'isDateFilterActive', 'fromDate', 'toDate'));
    }
    
    
    // public function index(Request $request)
    // {
    //     $query = Doctor::query();
    
    //         $fromDate = null;
    //         $toDate = null;
    //     // Apply search filter if present
    //     if($request->has('fromDate') && $request->has('toDate')){
    //         $fromDate = $request->input('fromDate');
    //         $toDate = $request->input('toDate');
    //     }
    //     if ($request->has('search')) {
    //         $search = $request->input('search');
    //         $query->where('name', 'like', "%$search%")
    //               ->orWhere('clinic_name', 'like', "%$search%")
    //               ->orWhere('clinic_location', 'like', "%$search%");
    //     }
    
    //     // Apply sorting if present
    //     if ($request->has('sort')) {
    //         $sort = $request->input('sort');
    //         switch ($sort) {
    //             case 'name_asc':
    //                 $query->orderBy('name', 'asc');
    //                 break;
    //             case 'name_desc':
    //                 $query->orderBy('name', 'desc');
    //                 break;
    //             case 'clinic_name_asc':
    //                 $query->orderBy('clinic_name', 'asc');
    //                 break;
    //             case 'clinic_name_desc':
    //                 $query->orderBy('clinic_name', 'desc');
    //                 break;
    //             default:
    //                 break;
    //         }
    //     }
        
    //     $opg = 0;
    //     $cbct = 0;
        
        
    
    //     $doctors = $query->where('status', 'active')->orWhereNull('status')->get();

    //     foreach ($doctors as $doctor) {
    //         $doctor->inactiveDays = $this->getInactiveDaysForDoctor($doctor->id);
    //         if($request->has('fromDate') && $request->has('toDate')){
    //             $abc = Doctor::with(['patients' => function ($query) use ($fromDate, $toDate) {
    //             // Apply date range filter on patients
    //                 $query->whereBetween('appointment_date', [$fromDate, $toDate]);
    //             }])->find($doctor->id);
    //             $isDateFilterActive = true;
    //         }else{
    //             $abc = Doctor::with('patients')->find($doctor->id);
    //             $isDateFilterActive = false;
    //         }
    //         foreach($abc->patients as $patient){
    //             foreach(json_decode($patient->services) as $service){
    //               $fetchService = Service::find($service);
    //               if($fetchService){
    //                   if($fetchService->type == 'OPG'){
    //                         $opg++;
    //                   }else if($fetchService->type == 'CBCT'){
    //                         $cbct++;
    //                   }
    //               }
    //             }
    //         }
    //         $doctor->opgCount = $opg;
    //         $doctor->cbctCount = $cbct;
    //     }
        

    
    //     return view('doctors.index', compact('doctors', 'abc', 'isDateFilterActive', 'fromDate', 'toDate'));
    // }
    
    public function customIndex(Request $request)
    {
        $query = Doctor::query();
    
        // Apply search filter if present
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%")
                  ->orWhere('clinic_name', 'like', "%$search%")
                  ->orWhere('clinic_location', 'like', "%$search%");
        }
    
        // Apply sorting if present
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            switch ($sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'clinic_name_asc':
                    $query->orderBy('clinic_name', 'asc');
                    break;
                case 'clinic_name_desc':
                    $query->orderBy('clinic_name', 'desc');
                    break;
                default:
                    break;
            }
        }
    
        $doctors = $query->where('status', 'inactive')->get();
    
        return view('doctors.unapproved', compact('doctors'));
    }

    public function edit($id){
        $doctor = Doctor::find($id);
        $data = compact('doctor');
        return view('doctors.edit')->with($data);
    }
    
    public function approve(Request $request, $id){

        $validatedData = $request->validate([
            'id' => 'required|string',
        ]);

        $doctor = Doctor::find($id);

        if($doctor){
            $doctor->status = null;
            $doctor->save();
        }else{
            return redirect()->route('doctors.custom.show');
        }
        return redirect()->route('doctors.custom.show')->with('success', 'Doctor approved successfully!');
    }
    
    public function generalUpdate(Request $request, $id){

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:15',
            'email' => 'nullable|string',
            'clinic_name' => 'required|string|max:255',
            'clinic_location' => 'nullable|string|max:255',
            'gpay_number' => 'nullable|string|max:255',
            'upi' => 'nullable|string|max:255',
        ]);

        $doctor = Doctor::find($id);

        if($doctor){
            $doctor->name = $validatedData['name'];
            $doctor->phone = $validatedData['phone'];
            $doctor->email = $validatedData['email'];
            $doctor->clinic_name = $validatedData['clinic_name'];
            $doctor->clinic_location = $validatedData['clinic_location'];
            $doctor->gpay_number = $validatedData['gpay_number'];
            $doctor->upi = $validatedData['upi'];
            $doctor->save();
        }else{
            return redirect()->route('doctors.custom.show');
        }
        return redirect()->route('doctors.custom.show')->with('success', 'Doctor updated successfully!');
    }
    
    public function store(Request $request)
    {
        // Validate the incoming request data
        Log::info('Validating');

        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|min:10|max:15',
                'email' => 'required|string',
                'clinic_name' => 'required|string|max:255',
                'clinic_location' => 'required|string|max:255',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480', // Validate image
            ]);

            \Log::info('Validated');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed: ', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        // Handle the file upload if there is an image
        if ($request->hasFile('profile_picture')) {
            \Log::info('File received');

            $randomFileName = Str::random(40) . '.' . $request->file('profile_picture')->getClientOriginalExtension();
            \Log::info('Generated File Name: ' . $randomFileName);

            $imagePath = $request->file('profile_picture')->storeAs('doctor/profile', $randomFileName, 'public');
            \Log::info('Stored File Path: ' . $imagePath);

            $validatedData['profile_picture'] = $randomFileName;
        } else {
            \Log::info('No file received');
        }


        // return $validatedData['profile_picture'];
        // // Create the doctor
        // Doctor::create($validatedData);

        $doctor = new Doctor;
        $doctor->name = $validatedData['name'];
        $doctor->phone = $validatedData['phone'];
        $doctor->email = $validatedData['email'];
        $doctor->clinic_name = $validatedData['clinic_name'];
        $doctor->clinic_location = $validatedData['clinic_location'];
        $doctor->profile_picture = $validatedData['profile_picture'] ?? null;
        $doctor->save();
        
        $doctorPhone = 91 . $validatedData['phone'];
        
        $doctorData = [
            'timestamp' => now()->timestamp,
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $doctorPhone,
            'type' => 'newDoctor'
        ];
    
        // Convert data to JSON format
        $doctorJsonData = json_encode($doctorData);
    
        // Define patient webhook URL
        $patientWebhookUrl = 'https://events.sendpulse.com/events/id/d1fe7942f34d4cd6de484cc9ce77c133/8635691'; // Replace with actual patient webhook URL
        
        $doctorWebhookUrl = 'https://events.sendpulse.com/events/id/d1fe7942f34d4cd6de484cc9ce77c133/8635691';
        
        $accessToken = $this->getSendPulseAccessToken();
        
        $doctorContactId = $this->createContact($doctorPhone, $validatedData['name'], $accessToken);
        
        if($doctorContactId != null){
            $doctorContactId = $this->setUserVariable($doctorContactId, 'Clinic Name', $validatedData['clinic_name'], $accessToken);
            $doctorContactId = $this->setUserVariable($doctorContactId, 'Name', $validatedData['name'], $accessToken);
        }
        
        
        // Send patient data to the patient webhook
        $this->sendWebhookRequest($doctorWebhookUrl, $doctorJsonData);
        
        
        // Redirect or return success response
        return redirect()->back()->with('success', 'Doctor created successfully!');
    }
    
    
    public function showCalendar($id)
    {
        $inactiveDays = $this->getInactiveDaysForDoctor($id);
        // Fetch the appointments for the doctor
        $appointments = Patient::where('doctor', $id)->get();
        return view('doctors.calendar', compact('appointments', 'inactiveDays'));
    }

    public function destroy($id)
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

    // Redirect back with a success message
    return redirect()->route('doctors.show')->with('success', 'Doctor deleted successfully.');
}


    public function export()
    {
        return Excel::download(new DoctorsExport, 'doctors.xlsx');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:15',
            'email' => 'required|string',
            'clinic_name' => 'required|string|max:255',
            'clinic_location' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480', // Validate image
        ]);


        // return $request;
        $doctor = Doctor::find($id);
        $doctor->name = $request->input('name');
        $doctor->phone = $request->input('phone');
        $doctor->email = $request->input('email');
        $doctor->clinic_name = $request->input('clinic_name');
        $doctor->clinic_location = $request->input('clinic_location');
        $doctor->save();

        return redirect()->route('doctors.show')->with('success', 'Doctor updated successfully.');
    }


    public function getOpgCbctCountForDoctor($doctorId, $fromDate, $toDate)
    {
        // Find the doctor by their ID
        $doctor = Doctor::with(['patients' => function ($query) use ($fromDate, $toDate) {
            // Apply date range filter on patients
            $query->whereBetween('appointment_date', [$fromDate, $toDate]);
        }])->find($doctorId);

    
            return $doctor;
    }
    
    public function getInactiveDaysForDoctor($doctorId)
    {
        // Find the doctor by their ID
        $doctor = Doctor::with('patients')->find($doctorId);
    
        if ($doctor) {
            // Fetch the number of inactive days for this doctor
            $inactiveDays = $doctor->daysInactive();
            return $inactiveDays;
        } else {
            echo "Doctor not found.";
        }
    }
    
    public function collaborateShow(Request $request)
    {
        $representatives = User::where('role', 'representative')->get();
        $data = compact('representatives');
        if ($request->has('geolocation_error')) {
            session()->flash('geolocation_error', $request->query('geolocation_error'));
        }
        return view('collaborate.index')->with($data);
    }
    
    public function collabFormStore(Request $request)
    {
        // Validation rules
        $rules = [
            'doctor_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|regex:/^[0-9]{10}$/',
            'email' => 'required|email|max:255',
            'clinic_name' => 'required|string|max:255',
            'clinic_location' => 'required|string|max:255',
            // 'gpay_number' => 'required|string|max:255',
            // 'upi' => 'required|string|max:255',
            'representative' => 'required|exists:users,id',
            // 'meeting_purpose' => 'required|string|max:255',
            'feedback' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Prepend country code to phone
        $phone = '91' . $request->phone;

        // Save doctor data
        $doctor = new Doctor();
        $doctor->name = $request->doctor_name;
        $doctor->phone = $phone;
        $doctor->email = $request->email;
        $doctor->clinic_name = $request->clinic_name;
        $doctor->clinic_location = $request->clinic_location;
        // $doctor->gpay_number = $request->gpay_number;
        // $doctor->upi = $request->upi;
        $doctor->representative_id = $request->representative;
        // $doctor->meeting_purpose = $request->meeting_purpose;
        $doctor->feedback = $request->feedback;
        $doctor->save();

        // Save representative location
        $location = new RepresentativeLocation();
        $location->user_id = Auth::user()->id;
        $location->latitude = $request->latitude;
        $location->longitude = $request->longitude;
        $location->type = $doctor->id;
        $location->save();

        // Store doctor name in session for thank you page
        Session::flash('name', $request->doctor_name);

        // Prepare webhook data
        $doctorData = [
            'timestamp' => now()->timestamp,
            'name' => $request->doctor_name,
            'email' => $request->email,
            'phone' => $phone,
            'type' => 'newDoctor'
        ];
        $doctorJsonData = json_encode($doctorData);

        // Webhook URLs
        $doctorWebhookUrl = 'https://events.sendpulse.com/events/id/d1fe7942f34d4cd6de484cc9ce77c133/8635691';

        // SendPulse integration
        $accessToken = $this->getSendPulseAccessToken();
        $doctorContactId = $this->createContact($phone, $request->doctor_name, $accessToken);

        if ($doctorContactId) {
            $this->setUserVariable($doctorContactId, 'Clinic Name', $request->clinic_name, $accessToken);
            $this->setUserVariable($doctorContactId, 'Name', $request->doctor_name, $accessToken);
        }

        // Send webhook request
        $this->sendWebhookRequest($doctorWebhookUrl, $doctorJsonData);

        return redirect()->route('doctors.collaborate.thankyou');
    }
    
    public function thankyou(Request $request)
    {
        $name = $request->session()->get('name');

        // Check if data exists (optional)
        if (!$name) {
            // abort(404); // Or handle appropriately
            $name = "name";
        }
    
        // Pass data to the view
        return view('collaborate.thankyou')->with('name', $name);
        
    }
    
    // Method to handle the uploaded CSV file
    public function uploadDoctors(Request $request)
{
    $file = $request->file('file');

    // Check if a file is uploaded
    if (!$file) {
        return redirect()->back()->with('error', 'Please upload a file.');
    }

    // Process the uploaded file
    $path = $file->getRealPath();
    $data = array_map('str_getcsv', file($path));

    // Remove the header row
    $headers = array_shift($data);

    // Iterate through rows and save to database
    foreach ($data as $row) {
        if (count($row) < 3) {
            continue; // Skip rows that don't have complete data
        }

        $doctor = new Doctor([
            'name' => $row[0],
            'clinic_name' => $row[1],
            'email' => $row[2],
            'phone' => $row[3],
            'clinic_location' => $row[4] ?? null,
            'gpay_number' => is_numeric($row[5]) ? $row[5] : null, // Ensure gpay_number is either an integer or null
            'upi' => $row[6] ?? null,
            'representative' => $row[7] ?? null,
            'meeting_purpose' => $row[8] ?? null,
            'feedback' => $row[9] ?? null,
        ]);
        $doctor->save();
    }

    return redirect()->route('doctors.show');
}

    
    private function sendWebhookRequest($url, $jsonData)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ]);
    
        $response = curl_exec($ch);
    
        if ($response === false) {
            die(curl_error($ch));
        }
    
        curl_close($ch);
    }


}
