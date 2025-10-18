<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessSetting;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BusinessSettingController extends Controller
{
    public function index(){
        $settings = BusinessSetting::where('user_id', Auth::user()->id)->first();
        $data = compact('settings');
        return view('business.settings')->with($data);
    }

    public function generalUpdate(Request $request){
        $validatedData = $request->validate([
            'business_name' => 'nullable|string',
            'isNullLogo' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:20480',
        ]);

        $settings = BusinessSetting::where('user_id', Auth::user()->id)->first();

        if ($settings) {
            if ($validatedData['isNullLogo'] === null || strtolower($validatedData['isNullLogo']) === 'yes') {
                $settings->business_name = $validatedData['business_name'];
                $settings->logo = null;
                $settings->save();
            }else{

                if ($request->hasFile('logo')) {
                    // \Log::info('File received');

                    $randomFileName = Str::random(40) . '.' . $request->file('logo')->getClientOriginalExtension();
                    // \Log::info('Generated File Name: ' . $randomFileName);

                    $imagePath = $request->file('logo')->storeAs('business/general/logo', $randomFileName, 'public');
                    // \Log::info('Stored File Path: ' . $imagePath);

                    $validatedData['logo'] = $randomFileName;
                } else {
                    // \Log::info('No file received');
                }

                $settings->business_name = $validatedData['business_name'];
                $settings->logo = $validatedData['logo'];
                $settings->save();
            }

        } else {

            if ($validatedData['isNullLogo'] === null || strtolower($validatedData['isNullLogo']) === 'yes') {
                $generalsetting = new BusinessSetting;
                $generalsetting->user_id = Auth::user()->id;
                $generalsetting->business_name = $validatedData['business_name'];
                $generalsetting->logo = null;
                $generalsetting->save();
            }else{

                if ($request->hasFile('logo')) {
                    // \Log::info('File received');

                    $randomFileName = Str::random(40) . '.' . $request->file('logo')->getClientOriginalExtension();
                    // \Log::info('Generated File Name: ' . $randomFileName);

                    $imagePath = $request->file('logo')->storeAs('business/general/logo', $randomFileName, 'public');
                    // \Log::info('Stored File Path: ' . $imagePath);

                    $validatedData['logo'] = $randomFileName;
                } else {
                    // \Log::info('No file received');
                }

                $generalsetting = new BusinessSetting;
                $generalsetting->user_id = Auth::user()->id;
                $generalsetting->business_name = $validatedData['business_name'];
                $generalsetting->logo = $validatedData['logo'];
                $generalsetting->save();
            }


        }



        // Redirect or return success response
        return redirect()->back()->with('success', 'Settings saved successfully!');
    }
}
