@extends('admin.layouts.master')

@section('admin-content')
<body>
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-left: 16.666667%;">    
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2><i class="fas fa-receipt me-2"></i>Booking Details</h2>
                        <p class="text-muted mb-0">Booking #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Bookings
                        </a>
                        <span class="badge bg-{{ $booking->status == 'pending' ? 'warning' : ($booking->status == 'confirmed' ? 'info' : ($booking->status == 'active' ? 'success' : ($booking->status == 'completed' ? 'secondary' : 'danger'))) }} fs-6">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Customer Information -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $booking->user->name }}</p>
                        <p><strong>Email:</strong> {{ $booking->user->email }}</p>
                        <p><strong>Phone:</strong> {{ $booking->user->phone ?? 'Not provided' }}</p>
                        <p><strong>Joined:</strong> {{ $booking->user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <!-- Vehicle Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-car me-2"></i>Vehicle Information</h5>
                    </div>
                    <div class="card-body">
                        @if($booking->vehicle->image)
                            <img src="{{ asset('storage/' . $booking->vehicle->image) }}" 
                                class="img-fluid rounded mb-3" 
                                alt="{{ $booking->vehicle->name }}"
                                style="width: 100%; height: 150px; object-fit: cover;">
                        @endif
                        
                        <h6 class="fw-bold">{{ $booking->vehicle->brand ?? '' }} {{ $booking->vehicle->name }}</h6>
                        <p class="text-muted">{{ $booking->vehicle->model }} ({{ $booking->vehicle->year ?? 'N/A' }})</p>
                        
                        <div class="row text-center">
                            <div class="col-4">
                                <i class="fas fa-car text-primary"></i>
                                <div class="small">{{ $booking->vehicle->type->name }}</div>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-gas-pump text-primary"></i>
                                <div class="small">{{ $booking->vehicle->fuel->name }}</div>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-cog text-primary"></i>
                                <div class="small">{{ $booking->vehicle->transmission->name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="col-lg-8">
                <!-- Booking Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Booking Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">Rental Period</h6>
                                <p><strong>Pickup Date:</strong> {{ \Carbon\Carbon::parse($booking->pickup_date)->format('l, M d, Y') }}</p>
                                <p><strong>Return Date:</strong> {{ \Carbon\Carbon::parse($booking->return_date)->format('l, M d, Y') }}</p>
                                <p><strong>Total Days:</strong> {{ $booking->total_days }} {{ $booking->total_days == 1 ? 'day' : 'days' }}</p>
                                <p><strong>Pickup Location:</strong> {{ $booking->pickup_location }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">Booking Details</h6>
                                <p><strong>Booking Date:</strong> {{ $booking->created_at->format('M d, Y h:i A') }}</p>
                                <p><strong>Current Status:</strong> 
                                    <span class="badge bg-{{ $booking->status == 'pending' ? 'warning' : ($booking->status == 'confirmed' ? 'info' : ($booking->status == 'active' ? 'success' : ($booking->status == 'completed' ? 'secondary' : 'danger'))) }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-rupee-sign me-2"></i>Payment Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="bg-light p-3 rounded">
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
                </div>

                <!-- Status Management -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Status Management</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($booking->status == 'pending')
                                <div class="col-md-6">
                                    <form method="POST" action="{{ route('admin.bookings.approve', $booking->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Approve this booking?')">
                                            <i class="fas fa-check me-2"></i>Approve Booking
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <form method="POST" action="{{ route('admin.bookings.reject', $booking->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Reject this booking?')">
                                            <i class="fas fa-times me-2"></i>Reject Booking
                                        </button>
                                    </form>
                                </div>
                            @elseif($booking->status == 'confirmed')
                                <div class="col-md-12">
                                    <form method="POST" action="{{ route('admin.bookings.active', $booking->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-warning w-100" onclick="return confirm('Mark vehicle as picked up?')">
                                            <i class="fas fa-car me-2"></i>Mark as Picked Up
                                        </button>
                                    </form>
                                </div>
                            @elseif($booking->status == 'active')
                                <div class="col-md-12">
                                    <form method="POST" action="{{ route('admin.bookings.complete', $booking->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary w-100" onclick="return confirm('Mark booking as completed?')">
                                            <i class="fas fa-flag-checkered me-2"></i>Mark as Completed
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        This booking is <strong>{{ $booking->status }}</strong>. No further actions available.
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Manual Status Update -->
                        <hr>
                        <form method="POST" action="{{ route('admin.bookings.status', $booking->id) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <select name="status" class="form-select">
                                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="active" {{ $booking->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-save me-2"></i>Update Status
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection