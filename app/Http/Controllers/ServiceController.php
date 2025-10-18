<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;


class ServiceController extends Controller
{
    public function index(){
        $services = Service::get();
        $data = compact('services');
        return view('services.index')->with($data);
    }

    public function store(Request $request) {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'type' => 'required|max:255',
        ]);

        // Create a new Service instance and save data to it
        $service = new Service;
        $service->name = $request->input('name');
        $service->price = $request->input('price');
        $service->type = $request->input('type');
        $service->save(); // Corrected this line

        // Redirect to the services show route after saving
        return redirect()->route('services.show')->with('success', 'Service added successfully.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'type' => 'required|max:255',
        ]);


        // return $request;
        $service = Service::find($id)->first();
        $service->name = $request->input('name');
        $service->price = $request->input('price');
        $service->type = $request->input('type');
        $service->save();

        return redirect()->route('services.show')->with('success', 'Service updated successfully.');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('services.show')->with('success', 'Service deleted successfully.');
    }



}
