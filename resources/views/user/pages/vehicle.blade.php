@extends('user.layouts.master')

@section('user-content')

<div class="container py-5">
    <h1 class="text-center mb-5">Available Vehicles for Rent</h1>
    
    <!-- Filter Section -->
    <div class="filter-section mb-5">
        <h4 class="mb-4">Filter Vehicles</h4>
        <form method="GET" action="{{ route('vehicle') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="type" class="form-label">Vehicle Type</label>
                    <select class="form-select" id="type" name="type">
                        <option value="">All Types</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="model" class="form-label">Model</label>
                    <input type="text" class="form-control" id="model" name="model" placeholder="Model" value="{{ request('model') }}">
                </div>
                <div class="col-md-3">
                    <label for="fuel" class="form-label">Fuel Type</label>
                    <select class="form-select" id="fuel" name="fuel">
                        <option value="">All Fuel Types</option>
                        @foreach($fuels as $fuel)
                            <option value="{{ $fuel->id }}" {{ request('fuel') == $fuel->id ? 'selected' : '' }}>{{ $fuel->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="transmission" class="form-label">Transmission</label>
                    <select class="form-select" id="transmission" name="transmission">
                        <option value="">All Transmissions</option>
                        @foreach($transmissions as $transmission)
                            <option value="{{ $transmission->id }}" {{ request('transmission') == $transmission->id ? 'selected' : '' }}>{{ $transmission->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('vehicle') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Vehicles Listing -->
    @if($vehicles->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($vehicles as $vehicle)
                <div class="col">
                    <!-- Make entire card clickable -->
                    <div class="card h-100 vehicle-card" style="cursor: pointer;" onclick="window.location='{{ route('vehicle.show', $vehicle->id) }}'">
                        @if($vehicle->image)
                            <img src="{{ asset('storage/' . $vehicle->image) }}" class="card-img-top" alt="{{ $vehicle->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-car fa-3x text-light"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $vehicle->name }}</h5>
                            <!-- Limited description with "..." -->
                            <p class="card-text">{{ Str::limit($vehicle->description, 60) }}</p>
                            
                            <!-- Compact vehicle info -->
                            <div class="mb-3">
                                <small class="text-muted d-block"><strong>Type:</strong> {{ $vehicle->type->name }}</small>
                                <small class="text-muted d-block"><strong>Model:</strong> {{ $vehicle->model }}</small>
                                <small class="text-muted d-block"><strong>Fuel:</strong> {{ $vehicle->fuel->name }} | <strong>Transmission:</strong> {{ $vehicle->transmission->name }}</small>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag h5 text-primary mb-0">${{ number_format($vehicle->price_per_day, 2) }}/day</span>
                                <!-- Prevent button from triggering card click -->
                                <button class="btn btn-primary btn-sm" onclick="event.stopPropagation(); window.location='{{ route('vehicle.show', $vehicle->id) }}'">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $vehicles->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-car fa-5x text-muted mb-3"></i>
            <h3>No vehicles found</h3>
            <p class="text-muted">Try adjusting your filters to find what you're looking for.</p>
        </div>
    @endif
</div>
@endsection