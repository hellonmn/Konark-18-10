<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Coupon;
use App\Sendpulse;

class PatientBookingFormController extends Controller
{
    use Sendpulse;
    
    public function doctorCampaign(){
        return view('doctorCamp');
    }
    
    public function doctorCampaignStore(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'd_name' => 'nullable|string',
                'd_phone' => 'nullable|string',
                'clinic_name' => 'nullable|string',
            ]);
            
            $doctor = new Doctor;
            $doctor->name = $validatedData['d_name'];
            $doctor->phone = isset($validatedData['d_phone']) ? $validatedData['d_phone'] : null;
            $doctor->clinic_name = isset($validatedData['clinic_name']) ? $validatedData['clinic_name'] : null;
            $doctor->status = 'inactive';
            $doctor->save();
            
            $doctorPhone = '91' . $validatedData['d_phone'];
    
            // Generation Access token
            $accessToken = $this->getSendPulseAccessToken();
    
            // Checking if patient contact exists on SendPulse
            $isContactExist = $this->isContactExist($doctorPhone, $accessToken);
    
            if ($isContactExist) {
                $doctorContactId = $this->getContactIdByPhone($doctorPhone, $accessToken);
            } else {
                $this->createContact($doctorPhone, $validatedData['d_name'], $accessToken);
                $doctorContactId = $this->getContactIdByPhone($doctorPhone, $accessToken);
                $this->setUserVariable($doctorContactId, 'name', $validatedData['d_name'], $accessToken);
            }
    
            // Send webhook
            $doctorData = [
                'timestamp' => now()->timestamp,
                'name' => $validatedData['d_name'],
                'email' => 'dummy@email.com',
                'phone' => $doctorPhone,
                'type' => 'doctor',
            ];
        
            $doctorJsonData = json_encode($doctorData);
            $doctorWebhookUrl = 'https://events.sendpulse.com/events/id/d1fe7942f34d4cd6de484cc9ce77c133/8635691';
            $this->sendWebhookRequest($doctorWebhookUrl, $doctorJsonData);
    
            $responseData = [
                'status' => 'success',
                'message' => 'Patient data saved successfully.',
                'redirectUrl' => 'whatsapp://send?phone=917696747696',
            ];
    
            // return response()->json($responseData);
            return view('thankyou');
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                // 'message' => 'An error occurred: ' . $e->getMessage(),
                'message' => 'An error occurred.',
            ], 500);
        }
    }
    
    public function index(Request $request){
        $phoneNumber = null;
        if($request->query('waId') != null){
            $waId = $request->query('waId');
        
            // Generation Access token
            $accessToken = $this->getSendPulseAccessToken();
        
            // Checking if patient contact exist on sendpulse
            $phoneNumber = $this->getPhoneByContactId($waId, $accessToken);
            $phoneNumber = $this->removeCountryCode($phoneNumber);
        }
        // return $phoneNumber;
        $doctors = Doctor::where('status', null)->get();
        $services = Service::get();
        $data = compact('services', 'doctors', 'phoneNumber');
        return view('welcome')->with($data);
    }
    
    public function removeCountryCode($phoneNumber)
    {
        // Check if the phone number starts with +91 and remove it
        if (substr($phoneNumber, 0, 2) === '91') {
            $phoneNumber = substr($phoneNumber, 2);
        }

        return $phoneNumber;
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|min:10|max:15',
                'email' => 'required|email|max:255',
                'age' => 'required|integer|min:0',
                'gender' => 'nullable|string|max:255',
                'source' => 'nullable|string|max:255',
                'medical_history' => 'nullable|string|max:255',
                'appointment_time' => 'nullable|string|max:255',
                'appointment_date' => 'nullable|string|max:255',
                'doctor' => 'nullable|string|max:255',
                'doctor_id' => 'nullable|integer',
                'service' => 'nullable|string|max:255',
                'coupon' => 'nullable|string|max:255',
                'couponHiddenInput' => 'nullable|string|max:255',
                'total_price' => 'nullable|numeric|min:0',
                'discount' => 'nullable|numeric|min:0',
                'selectedServiceIds' => 'nullable|string',
                'd_name' => 'nullable|string',
                'd_phone' => 'nullable|string',
                'clinic_name' => 'nullable|string',
                'isCustomDoctor' => 'nullable|string',
            ]);
    
            // Convert selected service IDs string to an array
            $selectedServiceIdsArray = explode(",", $validatedData['selectedServiceIds']);
    
            // Calculate the total price of selected services
            $totalPrice = $this->calculateTotalServicePrice($selectedServiceIdsArray);
    
            $discount = 0;
            $finalPrice = $totalPrice;
    
            // Check if the coupon hidden input is available
            if (!empty($validatedData['couponHiddenInput'])) {
                // Fetch coupon information if provided
                $coupon = Coupon::where('code', $validatedData['couponHiddenInput'])->first();
    
                // Calculate discount based on the coupon if applicable
                if ($coupon) {
                    if ($coupon->is_fix) {
                        $discount = $coupon->amount;
                        $discount_type = 'fix';
                    } else {
                        $discount = ($coupon->percentage / 100) * $totalPrice;
                        if ($coupon->max < $discount) {
                            $discount = $coupon->max;
                        }
                        $discount_type = 'percentage';
                    }
                    $finalPrice = $totalPrice - $discount;
                }
            }
    
            $patientPhone = $validatedData['phone'];
            if (substr($validatedData['phone'], 0, 2) !== '91') {
                $patientPhone = '91' . $validatedData['phone'];
            }
            
            $doctorId = null;
            if (isset($validatedData['isCustomDoctor']) && $validatedData['isCustomDoctor'] == 'yes') {
                if (isset($validatedData['d_name']) && $validatedData['d_name'] !=null ) {
                    $doctor = new Doctor;
                    $doctor->name = $validatedData['d_name'];
                    $doctor->phone = isset($validatedData['d_phone']) ? $validatedData['d_phone'] : null;
                    $doctor->clinic_name = isset($validatedData['clinic_name']) ? $validatedData['clinic_name'] : null;
                    $doctor->status = 'inactive';
                    $doctor->save();
            
                    $doctorId = $doctor->id;
                }
            }else{
                if(isset($validatedData['doctor_id']) && $validatedData['doctor_id'] > 0){
                    $doctorId = $validatedData['doctor_id'];
                }elseif($validatedData['doctor_id'] == 0){
                    $doctorId = null;
                }
            }
            
            
            
    
            // Save the patient data
            $patient = new Patient;
            $patient->name = $validatedData['name'];
            $patient->phone = $patientPhone;
            $patient->email = $validatedData['email'];
            $patient->age = $validatedData['age'];
            $patient->gender = $validatedData['gender'];
            $patient->source = $validatedData['source'];
            $patient->medical_history = $validatedData['medical_history'];
            $patient->doctor = $doctorId;
            $patient->appointment_time = $validatedData['appointment_time'];
            $patient->appointment_date = $validatedData['appointment_date'];
            $patient->services = json_encode($selectedServiceIdsArray);
            $patient->coupon = $validatedData['couponHiddenInput'];
            $patient->payment_status = 'Pending';
            $patient->amount = $finalPrice;
            $patient->discount = $discount;
            $patient->save();
    
            
            if ($doctorId > 0) {
                    $doctor = Doctor::find($validatedData['doctor_id']);
                    if($doctor){
                        $doctorPhone = '91' . $doctor->phone;
                    }
            }
            
    
            // Generation Access token
            $accessToken = $this->getSendPulseAccessToken();
    
            // Checking if patient contact exists on SendPulse
            $isContactExist = $this->isContactExist($patientPhone, $accessToken);
    
            if ($isContactExist) {
                $patientContactId = $this->getContactIdByPhone($patientPhone, $accessToken);
                $this->setUserVariable($patientContactId, 'Patient Name', $validatedData['name'], $accessToken);
                $this->setUserVariable($patientContactId, 'total_price', $finalPrice, $accessToken);
            } else {
                $this->createContact($patientPhone, $validatedData['name'], $accessToken);
                $patientContactId = $this->getContactIdByPhone($patientPhone, $accessToken);
                $this->setUserVariable($patientContactId, 'total_price', $finalPrice, $accessToken);
            }
    
            if (isset($validatedData['doctor_id'])) {
                if($validatedData['doctor_id'] != null){
                    $doctorContactId = $this->getContactIdByPhone($doctorPhone, $accessToken);
                    $this->setUserVariable($doctorContactId, 'lastPatientName', $validatedData['name'], $accessToken);
        
                    // Send webhook
                    $doctorData = [
                        'timestamp' => now()->timestamp,
                        'name' => $validatedData['name'],
                        'email' => 'dummy@email.com',
                        'phone' => $doctorPhone,
                        'type' => 'doctor',
                    ];
        
                    $doctorJsonData = json_encode($doctorData);
                    $doctorWebhookUrl = 'https://events.sendpulse.com/events/id/d1fe7942f34d4cd6de484cc9ce77c133/8635691';
                    $this->sendWebhookRequest($doctorWebhookUrl, $doctorJsonData);
                }
            }
    
            $patientData = [
                'timestamp' => now()->timestamp,
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $patientPhone,
                'type' => 'patient',
            ];
    
            $patientJsonData = json_encode($patientData);
            $patientWebhookUrl = 'https://events.sendpulse.com/events/id/d1fe7942f34d4cd6de484cc9ce77c133/8635691';
            $this->sendWebhookRequest($patientWebhookUrl, $patientJsonData);
    
            $responseData = [
                'status' => 'success',
                'message' => 'Patient data saved successfully.',
                'redirectUrl' => 'whatsapp://send?phone=917696747696',
            ];
    
            return response()->json($responseData);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function successPage(){
        return view('thank');
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

/**
 * Calculate the total price of selected services.
 *
 * @param array $selectedServiceIds
 * @return int
 */
    private function calculateTotalServicePrice(array $selectedServiceIds)
    {
        $totalPrice = 0;

        foreach ($selectedServiceIds as $selectedServiceId) {
            $service = Service::find($selectedServiceId);
            if ($service) {
                $totalPrice += $service->price;
            }
        }

        return $totalPrice;
    }

}
