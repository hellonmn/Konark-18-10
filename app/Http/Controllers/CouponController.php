<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function index(){
        $coupons = Coupon::get();
        $data = compact('coupons');
        return view('coupons.index')->with($data);
    }

    public function store(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|min:3|max:15',
                'expiry' => 'nullable|date',
                'is_fix' => 'nullable|boolean',
                'percentage' => 'nullable|numeric|between:0,100',
                'amount' => 'nullable|numeric',
                'min' => 'nullable|numeric',
                'max' => 'nullable|numeric',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed: ', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        if($validatedData['amount'] != null){
            $validatedData['is_fix'] = true;
        }else{
            $validatedData['is_fix'] = false;
        }

        // return $validatedData;
        // // Create the doctor
        Coupon::create($validatedData);

        // Redirect or return success response
        return redirect()->back()->with('success', 'Coupon created successfully!');
    }

    public function edit($id)
    {
        $coupon = Coupon::find($id);
        if($coupon){
            $data = compact('coupon');
            return view('coupons.edit')->with($data);
        };
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|min:3|max:15',
            'expiry' => 'nullable|date',
            'percentage' => 'nullable|numeric|between:0,100',
            'amount' => 'nullable|numeric',
            'min' => 'nullable|numeric',
            'max' => 'nullable|numeric',
        ]);
        $coupon = Coupon::find($id);

        if($coupon){
            $coupon->name = $validatedData['name'];
            $coupon->code = $validatedData['code'];
            $coupon->expiry = $validatedData['expiry'];
            $coupon->percentage = $validatedData['percentage'] ?? null;
            $coupon->amount = $validatedData['amount'] ?? null;
            $coupon->min = $validatedData['min'] ?? null;
            $coupon->max = $validatedData['max'] ?? null;
            $coupon->save();
        }

        // Redirect or return success response
        return redirect()->back()->with('success', 'Coupon updated successfully!');
    }

    public function destroy(Request $request)
    {
        $validatedData = $request->validate([
            'coupon_id' => 'required|string',
        ]);

        $coupon = Coupon::find($validatedData['coupon_id']);
        if ($coupon) {
            $coupon->delete();  // Use delete() instead of destroy()
            return redirect()->back()->with('success', 'Coupon deleted successfully!');
        }

        return redirect()->back()->with('error', 'Coupon not found!');
    }


    public function validateCoupon(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'couponCode' => 'required|string',
        ]);
    
        $couponCode = $request->input('couponCode');
    
        // Fetch the coupon from the database
        $coupon = Coupon::where('code', $couponCode)->first();
    
        if ($coupon) {
            // Check if the coupon is still valid
            if ($coupon->expiry >= now()) {
                return response()->json([
                    'valid' => true,
                    'coupon' => $coupon,
                    'min' => $coupon->min,  // Minimum eligible amount
                    'max' => $coupon->max   // Maximum discount amount
                ]);
            } else {
                return response()->json([
                    'valid' => false,
                    'message' => 'Coupon code has expired.',
                ], 400);
            }
        } else {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid coupon code.',
            ], 400);
        }
    }

}
