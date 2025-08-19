<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Type;
use App\Models\Fuel;
use App\Models\Transmission;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with(['type', 'fuel', 'transmission'])->paginate(10);
        return view('admin.pages.manage', compact('vehicles'));
    }

    public function create()
    {
        $types = Type::all();
        $fuels = Fuel::all();
        $transmissions = Transmission::all();
        return view('admin.pages.create', compact('types', 'fuels', 'transmissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type_id' => 'required|exists:types,id',
            'model' => 'required|string|max:255',
            'fuel_id' => 'required|exists:fuels,id',
            'transmission_id' => 'required|exists:transmissions,id',
            'price_per_day' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('vehicles', 'public');
            $data['image'] = $imagePath;
        }
        
        $data['is_available'] = $request->has('is_available');
        
        Vehicle::create($data);

        return redirect()->route('admin.pages.manage')->with('success', 'Vehicle added successfully.');
    }

    public function edit(Vehicle $vehicle)
    {
        $types = Type::all();
        $fuels = Fuel::all();
        $transmissions = Transmission::all();
        return view('admin.pages.edit', compact('vehicle', 'types', 'fuels', 'transmissions'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type_id' => 'required|exists:types,id',
            'model' => 'required|string|max:255',
            'fuel_id' => 'required|exists:fuels,id',
            'transmission_id' => 'required|exists:transmissions,id',
            'price_per_day' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($vehicle->image) {
                Storage::disk('public')->delete($vehicle->image);
            }
            
            $imagePath = $request->file('image')->store('vehicles', 'public');
            $data['image'] = $imagePath;
        }
        
        $data['is_available'] = $request->has('is_available');
        
        $vehicle->update($data);

        return redirect()->route('admin.pages.manage')->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->image) {
            Storage::disk('public')->delete($vehicle->image);
        }
        
        $vehicle->delete();

        return redirect()->route('admin.pages.manage')->with('success', 'Vehicle deleted successfully.');
    }
}