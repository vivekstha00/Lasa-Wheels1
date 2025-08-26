@extends('user.layouts.master')

@section('user-content')

<div class="container py-5">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('vehicle') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Vehicles
        </a>
    </div>

    <div class="row">
        <!-- Vehicle Image -->
        <div class="col-lg-6">
            @if($vehicle->image)
                <img src="{{ asset('storage/' . $vehicle->image) }}" class="img-fluid rounded" alt="{{ $vehicle->name }}" style="width: 100%; height: 400px; object-fit: cover;">
            @else
                <div class="bg-secondary d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                    <i class="fas fa-car fa-5x text-light"></i>
                </div>
            @endif
        </div>

        <!-- Vehicle Details -->
        <div class="col-lg-6">
            <h1 class="mb-3">{{ $vehicle->name }}</h1>
            <p class="lead text-muted mb-4">{{ $vehicle->description }}</p>

            <!-- Price -->
            <div class="bg-primary text-white p-3 rounded mb-4">
                <h3 class="mb-0">रू{{ number_format($vehicle->price_per_day, 2) }} <small>/day</small></h3>
            </div>

            <!-- Vehicle Specifications -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Vehicle Specifications</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Type:</strong> {{ $vehicle->type->name }}</p>
                            <p><strong>Model:</strong> {{ $vehicle->model }}</p>
                            <p><strong>Year:</strong> {{ $vehicle->year ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Fuel:</strong> {{ $vehicle->fuel->name }}</p>
                            <p><strong>Transmission:</strong> {{ $vehicle->transmission->name }}</p>
                            <p><strong>Seats:</strong> {{ $vehicle->seats ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features -->
            @if($vehicle->features)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Features</h5>
                </div>
                <div class="card-body">
                    <p>{{ $vehicle->features }}</p>
                </div>
            </div>
            @endif

            <!-- Booking Section -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Book This Vehicle</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pickup_date" class="form-label">Pickup Date</label>
                                <input type="date" class="form-control" id="pickup_date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="return_date" class="form-label">Return Date</label>
                                <input type="date" class="form-control" id="return_date" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="pickup_location" class="form-label">Pickup Location</label>
                            <input type="text" class="form-control" id="pickup_location" placeholder="Enter pickup location" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-calendar-check me-2"></i>Book Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection