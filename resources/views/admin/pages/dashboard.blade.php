@extends('admin.layouts.master')

@section('admin-content')
<body>
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-left: 16.666667%;">    
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Total Vehicles</h5>
                                <h2 class="card-text">{{ \App\Models\Vehicle::count() }}</h2>
                            </div>
                            <div>
                                <i class="fas fa-car fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Available Vehicles</h5>
                                <h2 class="card-text">{{ \App\Models\Vehicle::where('is_available', true)->count() }}</h2>
                            </div>
                            <div>
                                <i class="fas fa-check-circle fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Rented Vehicles</h5>
                                <h2 class="card-text">{{ \App\Models\Vehicle::where('is_available', false)->count() }}</h2>
                            </div>
                            <div>
                                <i class="fas fa-times-circle fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h4>Quick Actions</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.create') }}" class="btn btn-primary btn-lg w-100 py-3">
                            <i class="fas fa-plus me-2"></i> Add New Vehicle
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.manage') }}" class="btn btn-success btn-lg w-100 py-3">
                            <i class="fas fa-edit me-2"></i> Manage Vehicles
                        </a>
                    </div>
                </div>
            </div>
        </div> 
    </div>  
</body>  

@endsection