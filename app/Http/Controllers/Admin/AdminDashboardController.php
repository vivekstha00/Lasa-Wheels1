<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicle;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsersCount = User::where('role', 'user')->count();
        $totalVehiclesCount = Vehicle::count();
        $availableVehiclesCount = Vehicle::where('is_available', true)->count();
        $recentUsers = User::where('role', 'user')->latest()->take(5)->get();
        $recentVehicles = Vehicle::latest()->take(5)->get();

        $statistics = [
            'totalUsersCount' => $totalUsersCount,
            'totalVehiclesCount' => $totalVehiclesCount,
            'availableVehiclesCount' => $availableVehiclesCount,
            'recentUsers' => $recentUsers,
            'recentVehicles' => $recentVehicles,
        ];

        return view('admin.pages.dashboard', compact('statistics'));
    }
}
