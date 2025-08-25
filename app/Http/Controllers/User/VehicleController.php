<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Type;
use App\Models\Fuel;
use App\Models\Transmission;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::with(['type', 'fuel', 'transmission'])->where('is_available', true);
        
        // Apply filters
        if ($request->has('type') && $request->type != '') {
            $query->where('type_id', $request->type);
        }
        
        if ($request->has('model') && $request->model != '') {
            $query->where('model', 'like', '%' . $request->model . '%');
        }
        
        if ($request->has('fuel') && $request->fuel != '') {
            $query->where('fuel_id', $request->fuel);
        }
        
        if ($request->has('transmission') && $request->transmission != '') {
            $query->where('transmission_id', $request->transmission);
        }
        
        $vehicles = $query->paginate(9);
        
        $types = Type::all();
        $fuels = Fuel::all();
        $transmissions = Transmission::all();

        return view('user.pages.vehicle', compact('vehicles', 'types', 'fuels', 'transmissions'));
    }
  
    public function show(Vehicle $vehicle)
    {
        return view('user.pages.vehicle-detail', compact('vehicle'));
    }
}