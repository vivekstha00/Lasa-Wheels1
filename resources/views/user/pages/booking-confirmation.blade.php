@extends('user.layouts.master')

@section('user-content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h1 class="text-success">Booking Confirmed!</h1>
                <p class="lead text-muted">Your booking request has been submitted successfully.</p>
            </div>

            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Booking Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Booking Information</h6>
                            <p><strong>Booking ID:</strong> #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-warning">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </p>
                            <p><strong>Booking Date:</strong> {{ $booking->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Vehicle Information</h6>
                            <p><strong>Vehicle:</strong> {{ $booking->vehicle->brand ?? '' }} {{ $booking->vehicle->name }}</p>
                            <p><strong>Model:</strong> {{ $booking->vehicle->model }}</p>
                            <p><strong>Type:</strong> {{ $booking->vehicle->type->name }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Rental Period</h6>
                            <p><strong>Pickup Date:</strong> {{ \Carbon\Carbon::parse($booking->pickup_date)->format('M d, Y') }}</p>
                            <p><strong>Return Date:</strong> {{ \Carbon\Carbon::parse($booking->return_date)->format('M d, Y') }}</p>
                            <p><strong>Total Days:</strong> {{ $booking->total_days }} {{ $booking->total_days == 1 ? 'day' : 'days' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Location & Contact</h6>
                            <p><strong>Pickup Location:</strong> {{ $booking->pickup_location }}</p>
                            <p><strong>Customer:</strong> {{ $booking->user->name }}</p>
                            <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded mb-4">
                        <h6 class="text-muted mb-3">Payment Summary</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Price per day:</span>
                            <span>रू{{ number_format($booking->price_per_day, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Number of days:</span>
                            <span>{{ $booking->total_days }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total Amount:</span>
                            <span class="text-primary">रू{{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>What's Next?</strong><br>
                        Your booking is currently <strong>pending approval</strong>. Our team will contact you within 24 hours to confirm the details and arrange pickup.
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('booking.my') }}" class="btn btn-primary me-3">
                    <i class="fas fa-list me-2"></i>View My Bookings
                </a>
                <a href="{{ route('vehicle') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-car me-2"></i>Browse More Vehicles
                </a>
            </div>
        </div>
    </div>
</div>
@endsection