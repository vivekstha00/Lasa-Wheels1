@extends('user.layouts.master')

@section('user-content')

<div class="container py-5">
    <h1 class="text-center mb-5">Available Vehicles for Rent</h1>
    
    <!-- Filter Section -->
    <div class="filter-section">
        <h4 class="mb-4">Filter Vehicles</h4>
        <form method="GET" action="{{ route('home') }}">
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
                    <a href="{{ route('home') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Vehicles Listing -->
    @if($vehicles->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($vehicles as $vehicle)
                <div class="col">
                    <div class="card h-100 vehicle-card">
                        @if($vehicle->image)
                            <img src="{{ asset('storage/' . $vehicle->image) }}" class="card-img-top" alt="{{ $vehicle->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-car fa-3x text-light"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $vehicle->name }}</h5>
                            <p class="card-text">{{ $vehicle->description }}</p>
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item"><strong>Type:</strong> {{ $vehicle->type->name }}</li>
                                <li class="list-group-item"><strong>Model:</strong> {{ $vehicle->model }}</li>
                                <li class="list-group-item"><strong>Fuel:</strong> {{ $vehicle->fuel->name }}</li>
                                <li class="list-group-item"><strong>Transmission:</strong> {{ $vehicle->transmission->name }}</li>
                            </ul>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price-tag">${{ number_format($vehicle->price_per_day, 2) }}/day</span>
                                <button class="btn btn-primary">Rent Now</button>
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