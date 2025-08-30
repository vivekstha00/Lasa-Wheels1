@extends('user.layouts.master')

@section('user-content')
<div class="container py-5">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="fas fa-user me-2"></i>My Profile</h2>
            <p class="text-muted mb-0">Manage your account and view your booking activity</p>
        </div>
    </div>

    <!-- Success Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Profile Summary Card -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <!-- Profile Image -->
                    <div class="mb-3">
                        @if($user->profile_image)
                            <img src="{{ $user->profile_image_url }}" alt="Profile" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                <i class="fas fa-user fa-3x text-white"></i>
                            </div>
                        @endif
                    </div>
                    
                    <!-- User Info -->
                    <h5 class="fw-bold">{{ $user->name }}</h5>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    
                    <!-- Membership Level -->
                    <span class="badge bg-{{ $user->membership_color }} mb-3">
                        <i class="fas fa-crown me-1"></i>{{ $user->membership_level }}
                    </span>
                    
                    <!-- Profile Completion -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <small class="text-muted">Profile Completion</small>
                            <small class="text-muted">{{ $user->profile_completion }}%</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $user->profile_completion }}%"></div>
                        </div>
                        @if($user->profile_completion < 100)
                            <small class="text-warning">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Complete your profile to unlock all features
                            </small>
                        @endif
                    </div>
                    
                    <!-- Loyalty Points -->
                    <div class="bg-light p-3 rounded mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-star text-warning me-2"></i>Loyalty Points</span>
                            <span class="fw-bold text-primary">{{ number_format($user->loyalty_points) }}</span>
                        </div>
                    </div>
                    
                    <!-- Total Spent -->
                    <div class="bg-light p-3 rounded mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-rupee-sign text-success me-2"></i>Total Spent</span>
                            <span class="fw-bold text-success">रू{{ number_format($user->total_spent, 2) }}</span>
                        </div>
                    </div>
                    
                    <!-- Member Since -->
                    <p class="small text-muted mb-4">
                        <i class="fas fa-calendar me-1"></i>
                        Member since {{ $user->created_at->format('M Y') }}
                        @if($user->age)
                            <br><i class="fas fa-birthday-cake me-1"></i>
                            {{ $user->age }} years old
                        @endif
                    </p>
                    
                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                        <a href="{{ route('user.profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </a>
                        <a href="{{ route('user.profile.change-password') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-lock me-2"></i>Change Password
                        </a>
                    </div>
                </div>
            </div>

            <!-- Current Booking Alert -->
            @if($user->hasActiveBooking())
                @php $currentBooking = $user->getCurrentBooking(); @endphp
                <div class="alert alert-info">
                    <h6><i class="fas fa-car me-2"></i>Current Rental</h6>
                    <p class="mb-2">{{ $currentBooking->vehicle->name }}</p>
                    <small>Return by: {{ \Carbon\Carbon::parse($currentBooking->return_date)->format('M d, Y') }}</small>
                </div>
            @endif
        </div>

        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Quick Stats -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-calendar-check fa-2x mb-2"></i>
                            <h4>{{ $bookingStats['total'] }}</h4>
                            <p class="mb-0 small">Total Bookings</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-check-circle fa-2x mb-2"></i>
                            <h4>{{ $bookingStats['completed'] }}</h4>
                            <p class="mb-0 small">Completed</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-clock fa-2x mb-2"></i>
                            <h4>{{ $bookingStats['pending'] }}</h4>
                            <p class="mb-0 small">Pending</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <i class="fas fa-car fa-2x mb-2"></i>
                            <h4>{{ $bookingStats['active'] }}</h4>
                            <p class="mb-0 small">Active</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Personal Information</h5>
                    <a href="{{ route('user.profile.edit') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Full Name:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Phone:</strong> {{ $user->phone ?? 'Not provided' }}</p>
                            <p><strong>Date of Birth:</strong> {{ $user->date_of_birth ? $user->date_of_birth->format('M d, Y') : 'Not provided' }}</p>
                            <p><strong>Driver License:</strong> {{ $user->driver_license ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Full Address:</strong></p>
                            <p class="text-muted">{{ $user->full_address }}</p>
                            @if($user->address)
                                <p><strong>Address:</strong> {{ $user->address }}</p>
                                <p><strong>City:</strong> {{ $user->city ?? 'Not provided' }}</p>
                                <p><strong>State:</strong> {{ $user->state ?? 'Not provided' }}</p>
                                <p><strong>Postal Code:</strong> {{ $user->postal_code ?? 'Not provided' }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Recent Bookings</h5>
                    <a href="{{ route('user.profile.booking-history') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-list me-1"></i>View All
                    </a>
                </div>
                <div class="card-body">
                    @if($recentBookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Vehicle</th>
                                        <th>Dates</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBookings as $booking)
                                        <tr>
                                            <td><strong>#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                                            <td>
                                                <div>
                                                    <strong>{{ $booking->vehicle->brand ?? '' }} {{ $booking->vehicle->name }}</strong><br>
                                                    <small class="text-muted">{{ $booking->vehicle->model }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <small>
                                                    {{ \Carbon\Carbon::parse($booking->pickup_date)->format('M d') }} - 
                                                    {{ \Carbon\Carbon::parse($booking->return_date)->format('M d, Y') }}
                                                    <br>
                                                    <span class="text-muted">{{ $booking->total_days }} days</span>
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $booking->status == 'pending' ? 'warning' : ($booking->status == 'confirmed' ? 'info' : ($booking->status == 'active' ? 'success' : ($booking->status == 'completed' ? 'secondary' : 'danger'))) }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td>रू{{ number_format($booking->total_amount, 2) }}</td>
                                            <td>
                                                <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">No bookings yet</h6>
                            <p class="text-muted">Start exploring our vehicles!</p>
                            <a href="{{ route('vehicle') }}" class="btn btn-primary">
                                <i class="fas fa-car me-2"></i>Browse Vehicles
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('vehicle') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-plus me-2"></i>Book New Vehicle
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('booking.my') }}" class="btn btn-outline-info w-100">
                                <i class="fas fa-list me-2"></i>My Bookings
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('user.profile.loyalty-points') }}" class="btn btn-outline-warning w-100">
                                <i class="fas fa-star me-2"></i>Loyalty Points ({{ number_format($user->loyalty_points) }})
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('user.profile.booking-history') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-history me-2"></i>Booking History
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection