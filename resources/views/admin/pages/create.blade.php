@extends('admin.layouts.master')

@section('admin-content')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="{{ route('admin.manage') }}" class="list-group-item list-group-item-action">Manage Vehicles</a>
                <a href="{{ route('admin.create') }}" class="list-group-item list-group-item-action active">Add New Vehicle</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Add New Vehicle</h2>
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
            
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Vehicle Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="model" class="form-label">Model *</label>
                                    <input type="text" class="form-control" id="model" name="model" value="{{ old('model') }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="type_id" class="form-label">Vehicle Type *</label>
                                    <select class="form-select" id="type_id" name="type_id" required>
                                        <option value="">Select Type</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
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
                                            <option value="{{ $fuel->id }}" {{ old('fuel_id') == $fuel->id ? 'selected' : '' }}>{{ $fuel->name }}</option>
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
                                            <option value="{{ $transmission->id }}" {{ old('transmission_id') == $transmission->id ? 'selected' : '' }}>{{ $transmission->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price_per_day" class="form-label">Price Per Day ($) *</label>
                                    <input type="number" step="0.01" class="form-control" id="price_per_day" name="price_per_day" value="{{ old('price_per_day') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Vehicle Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_available">Available for rent</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Add Vehicle</button>
                        <a href="{{ route('admin.manage') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection