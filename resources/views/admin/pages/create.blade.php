@extends('admin.layouts.master')

@section('admin-content')
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-left: 16.666667%;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add New Vehicle</h2>
        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Vehicles
        </a>
    </div>

    {{-- Validation Errors --}}
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
            <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Name & Brand --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Vehicle Name *</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Brand *</label>
                        <input type="text" class="form-control" name="brand" value="{{ old('brand') }}" required>
                    </div>
                </div>

                {{-- Model & Year --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Model *</label>
                        <input type="text" class="form-control" name="model" value="{{ old('model') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Year *</label>
                        <input type="number" class="form-control" name="year"
                               min="1990" max="{{ date('Y') + 1 }}"
                               value="{{ old('year') }}" required>
                    </div>
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
                </div>

                {{-- Type / Fuel / Transmission --}}
                <div class="row">
                    {{-- Vehicle Type --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Vehicle Type *</label>
                        <select class="form-select" name="type_id" required>
                            <option value="">Select Type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Fuel Type --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fuel Type *</label>
                        <select class="form-select" name="fuel_id" required>
                            <option value="">Select Fuel</option>
                            @foreach($fuels as $fuel)
                                <option value="{{ $fuel->id }}"
                                    {{ old('fuel_id') == $fuel->id ? 'selected' : '' }}>
                                    {{ $fuel->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Transmission --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Transmission *</label>
                        <select class="form-select" name="transmission_id" required>
                            <option value="">Select Transmission</option>
                            @foreach($transmissions as $transmission)
                                <option value="{{ $transmission->id }}"
                                    {{ old('transmission_id') == $transmission->id ? 'selected' : '' }}>
                                    {{ $transmission->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Price & Image --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price Per Day *</label>
                        <div class="input-group">
                            <span class="input-group-text">रू</span>
                            <input type="number" step="0.01" class="form-control"
                                   name="price_per_day"
                                   value="{{ old('price_per_day') }}" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Vehicle Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                    </div>
                </div>

                {{-- Availability --}}
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="is_available" value="1"
                        {{ old('is_available', true) ? 'checked' : '' }}>
                    <label class="form-check-label">Available for rent</label>
                </div>

                {{-- Buttons --}}
                <button type="submit" class="btn btn-primary">Add Vehicle</button>
                <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">Cancel</a>

            </form>
        </div>
    </div>
</div>
@endsection
