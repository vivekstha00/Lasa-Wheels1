@extends('admin.layouts.master')    
@section('admin-content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="{{ route('admin.manage') }}" class="list-group-item list-group-item-action active">Manage Vehicles</a>
                <a href="{{ route('admin.create') }}" class="list-group-item list-group-item-action">Add New Vehicle</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Manage Vehicles</h2>
                <a href="{{ route('admin.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Add New Vehicle
                </a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Model</th>
                                    <th>Price/Day</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vehicles as $vehicle)
                                    <tr>
                                        <td>
                                            @if($vehicle->image)
                                                <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->name }}" width="60" height="40" style="object-fit: cover;">
                                            @else
                                                <div class="bg-secondary d-flex align-items-center justify-content-center" style="width: 60px; height: 40px;">
                                                    <i class="fas fa-car text-light"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $vehicle->name }}</td>
                                        <td>{{ $vehicle->type->name }}</td>
                                        <td>{{ $vehicle->model }}</td>
                                        <td>${{ number_format($vehicle->price_per_day, 2) }}</td>
                                        <td>
                                            @if($vehicle->is_available)
                                                <span class="badge bg-success">Available</span>
                                            @else
                                                <span class="badge bg-danger">Not Available</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.edit', $vehicle->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.delete', $vehicle->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this vehicle?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        {{ $vehicles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection