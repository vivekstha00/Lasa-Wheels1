@extends('user.layouts.master')

@section('user-content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-file-alt me-2"></i>Booking Details</h2>
                <a href="{{ route('booking.my') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to My Bookings
                </a>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Booking #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</h5>
                            <span class="badge bg-{{ $booking->status == 'pending' ? 'warning' : ($booking->status == 'confirmed' ? 'info' : ($booking->status == 'active' ? 'success' : ($booking->status == 'completed' ? 'secondary' : 'danger'))) }} fs-6">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                        <div class="card-body">
                            <!-- Vehicle Information -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    @if($booking->vehicle->image)
                                        <img src="{{ asset('storage/' . $booking->vehicle->image) }}" class="img-fluid rounded" alt="{{ $booking->vehicle->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary d-flex align-items-center justify-content-center rounded" style="height: 200px;">
                                            <i class="fas fa-car fa-3x text-light"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <h5 class="fw-bold">{{ $booking->vehicle->brand ?? '' }} {{ $booking->vehicle->name }}</h5>
                                    <p class="text-muted">{{ $booking->vehicle->model }} ({{ $booking->vehicle->year ?? 'N/A' }})</p>
                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="small mb-1"><strong>Type:</strong> {{ $booking->vehicle->type->name }}</p>
                                            <p class="small mb-1"><strong>Fuel:</strong> {{ $booking->vehicle->fuel->name }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="small mb-1"><strong>Transmission:</strong> {{ $booking->vehicle->transmission->name }}</p>
                                            <p class="small mb-1"><strong>Seats:</strong> {{ $booking->vehicle->seats ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Booking Information -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Rental Period</h6>
                                    <p><strong>Pickup Date:</strong> {{ \Carbon\Carbon::parse($booking->pickup_date)->format('l, M d, Y') }}</p>
                                    <p><strong>Return Date:</strong> {{ \Carbon\Carbon::parse($booking->return_date)->format('l, M d, Y') }}</p>
                                    <p><strong>Total Days:</strong> {{ $booking->total_days }} {{ $booking->total_days == 1 ? 'day' : 'days' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Pickup Information</h6>
                                    <p><strong>Location:</strong> {{ $booking->pickup_location }}</p>
                                    <p><strong>Customer:</strong> {{ $booking->user->name }}</p>
                                    <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                                </div>
                            </div>

                            <!-- Actions -->
                            @if(in_array($booking->status, ['pending', 'confirmed']))
                                <div class="border-top pt-3">
                                    <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                            <i class="fas fa-times me-2"></i>Cancel Booking
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer text-muted">
                            <small>Booking created on {{ $booking->created_at->format('M d, Y h:i A') }}</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Payment Summary -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Payment Summary</h6>
                        </div>
                        <div class="card-body">
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
                    </div>

                    <!-- Status Timeline -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0">Booking Status</h6>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item {{ $booking->status == 'pending' ? 'active' : 'completed' }}">
                                    <i class="fas fa-clock"></i>
                                    <div>
                                        <strong>Pending</strong>
                                        <small class="text-muted d-block">Awaiting confirmation</small>
                                    </div>
                                </div>
                                
                                <div class="timeline-item {{ in_array($booking->status, ['confirmed', 'active', 'completed']) ? 'completed' : '' }}">
                                    <i class="fas fa-check"></i>
                                    <div>
                                        <strong>Confirmed</strong>
                                        <small class="text-muted d-block">Booking approved</small>
                                    </div>
                                </div>
                                
                                <div class="timeline-item {{ in_array($booking->status, ['active', 'completed']) ? 'completed' : '' }}">
                                    <i class="fas fa-car"></i>
                                    <div>
                                        <strong>Active</strong>
                                        <small class="text-muted d-block">Vehicle in use</small>
                                    </div>
                                </div>
                                
                                <div class="timeline-item {{ $booking->status == 'completed' ? 'completed' : '' }}">
                                    <i class="fas fa-flag"></i>
                                    <div>
                                        <strong>Completed</strong>
                                        <small class="text-muted d-block">Rental finished</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
    border-left: 2px solid #e9ecef;
}

.timeline-item:last-child {
    border-left: 2px solid transparent;
}

.timeline-item i {
    position: absolute;
    left: -8px;
    top: 0;
    background: #e9ecef;
    color: #6c757d;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 8px;
}

.timeline-item.completed i {
    background: #198754;
    color: white;
}

.timeline-item.active i {
    background: #ffc107;
    color: black;
}
</style>
@endsection