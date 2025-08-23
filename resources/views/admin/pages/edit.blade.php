@extends('admin.layouts.master')

@section('admin-content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="{{ route('admin.manage') }}" class="list-group-item list-group-item-action">Manage Vehicles</a>
                <a href="{{ route('admin.create') }}" class="list-group-item list-group-item-action">Add New Vehicle</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Edit Vehicle: {{ $vehicle->name }}</h2>
                <a href="{{ route('admin.manage') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Vehicles
                </a>
            </div>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <div class="col-md-4">
                                @if($vehicle->image)
                                    <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->name }}" class="img-fluid rounded">
                                @else
                                    <div class="bg-secondary d-flex align-items-center justify-content-center rounded" style="height: 200px;">
                                        <i class="fas fa-car fa-3x text-light"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Vehicle Name *</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $vehicle->name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="model" class="form-label">Model *</label>
                                            <input type="text" class="form-control" id="model" name="model" value="{{ old('model', $vehicle->model) }}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="image" class="form-label">Update Vehicle Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $vehicle->description) }}</textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="type_id" class="form-label">Vehicle Type *</label>
                                    <select class="form-select" id="type_id" name="type_id" required>
                                        <option value="">Select Type</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" {{ old('type_id', $vehicle->type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="fuel_id" class="form-label">Fuel Type *</label>
                                    <select class="form-select" id="fuel_id" name="fuel_id" required>
                                        <option value="">Select Fuel Type</option>
                                        @foreach($fuels as $fuel)
                                            <option value="{{ $fuel->id }}" {{ old('fuel_id', $vehicle->fuel_id) == $fuel->id ? 'selected' : '' }}>{{ $fuel->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="transmission_id" class="form-label">Transmission *</label>
                                    <select class="form-select" id="transmission_id" name="transmission_id" required>
                                        <option value="">Select Transmission</option>
                                        @foreach($transmissions as $transmission)
                                            <option value="{{ $transmission->id }}" {{ old('transmission_id', $vehicle->transmission_id) == $transmission->id ? 'selected' : '' }}>{{ $transmission->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price_per_day" class="form-label">Price Per Day ($) *</label>
                                    <input type="number" step="0.01" class="form-control" id="price_per_day" name="price_per_day" value="{{ old('price_per_day', $vehicle->price_per_day) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-check d-flex align-items-center" style="padding-top: 2.5rem;">
                                    <input type="checkbox" class="form-check-input me-2" id="is_available" name="is_available" value="1" {{ old('is_available', $vehicle->is_available) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_available">Available for rent</label>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Vehicle</button>
                        <a href="{{ route('admin.manage') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection