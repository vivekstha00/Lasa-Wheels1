@extends('user.layouts.master')

@section('user-content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-list me-2"></i>My Bookings</h2>
                <a href="{{ route('vehicle') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Book New Vehicle
                </a>
            </div>

            @if($bookings->count() > 0)
                <div class="row">
                    @foreach($bookings as $booking)
                        <div class="col-lg-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Booking #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</h6>
                                    <span class="badge bg-{{ $booking->status == 'pending' ? 'warning' : ($booking->status == 'confirmed' ? 'info' : ($booking->status == 'active' ? 'success' : ($booking->status == 'completed' ? 'secondary' : 'danger'))) }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            @if($booking->vehicle->image)
                                                <img src="{{ asset('storage/' . $booking->vehicle->image) }}" class="img-fluid rounded" alt="{{ $booking->vehicle->name }}" style="width: 100%; height: 80px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary d-flex align-items-center justify-content-center rounded" style="height: 80px;">
                                                    <i class="fas fa-car text-light"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="fw-bold">{{ $booking->vehicle->brand ?? '' }} {{ $booking->vehicle->name }}</h6>
                                            <p class="text-muted small mb-1">{{ $booking->vehicle->model }}</p>
                                            <p class="small mb-1">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ \Carbon\Carbon::parse($booking->pickup_date)->format('M d') }} - 
                                                {{ \Carbon\Carbon::parse($booking->return_date)->format('M d, Y') }}
                                            </p>
                                            <p class="small mb-1">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                {{ $booking->pickup_location }}
                                            </p>
                                            <p class="fw-bold text-primary mb-0">रू{{ number_format($booking->total_amount, 2) }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3 d-flex gap-2">
                                        <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>View Details
                                        </a>
                                        
                                        @if(in_array($booking->status, ['pending', 'confirmed']))
                                            <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                    <i class="fas fa-times me-1"></i>Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer text-muted small">
                                    Booked on {{ $booking->created_at->format('M d, Y h:i A') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-5x text-muted mb-3"></i>
                    <h4 class="text-muted">No bookings found</h4>
                    <p class="text-muted">You haven't made any bookings yet.</p>
                    <a href="{{ route('vehicle') }}" class="btn btn-primary">
                        <i class="fas fa-car me-2"></i>Browse Vehicles
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection