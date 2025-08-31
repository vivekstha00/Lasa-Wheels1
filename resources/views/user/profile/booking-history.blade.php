@extends('user.layouts.master')

@section('user-content')
<div class="container py-4">
    <!-- Header with Stats -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h3><i class="fas fa-history me-2"></i>Booking History</h3>
            <p class="text-muted">View and manage your vehicle bookings</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('user.profile.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Profile
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h4>{{ $bookings->count() }}</h4>
                    <small>Total Bookings</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h4>{{ $bookings->where('status', 'completed')->count() }}</h4>
                    <small>Completed</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h4>{{ $bookings->where('status', 'pending')->count() }}</h4>
                    <small>Pending</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h4>{{ $bookings->where('status', 'active')->count() }}</h4>
                    <small>Active</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Options -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('user.profile.booking-history') }}" class="btn btn-outline-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bookings List -->
    @if($bookings && $bookings->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Booking ID</th>
                                <th>Vehicle</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Points</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>
                                        <strong>#{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $booking->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($booking->vehicle->image)
                                                <img src="{{ asset('storage/' . $booking->vehicle->image) }}" 
                                                     class="rounded me-2" style="width: 40px; height: 30px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <strong>{{ $booking->vehicle->name ?? 'N/A' }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $booking->vehicle->model ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ \Carbon\Carbon::parse($booking->pickup_date)->format('M d') }}</strong>
                                        <br>
                                        <small class="text-muted">to {{ \Carbon\Carbon::parse($booking->return_date)->format('M d') }}</small>
                                        <br>
                                        <span class="badge bg-light text-dark">{{ $booking->total_days ?? 1 }} days</span>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'confirmed' => 'info', 
                                                'active' => 'success',
                                                'completed' => 'secondary',
                                                'cancelled' => 'danger'
                                            ];
                                            $color = $statusColors[$booking->status] ?? 'primary';
                                        @endphp
                                        <span class="badge bg-{{ $color }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong class="text-success">रू{{ number_format($booking->total_amount ?? 0, 2) }}</strong>
                                    </td>
                                    <td>
                                        @if($booking->status == 'completed')
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-star"></i> {{ floor($booking->total_amount / 100) }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('booking.show', $booking->id) }}" 
                                           class="btn btn-sm btn-outline-primary" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No Bookings Found</h4>
                <p class="text-muted">
                    @if(request('status'))
                        No bookings found with "{{ request('status') }}" status
                    @else
                        You haven't made any bookings yet
                    @endif
                </p>
                <a href="{{ route('vehicle') }}" class="btn btn-primary">
                    <i class="fas fa-car me-2"></i>Browse Vehicles
                </a>
            </div>
        </div>
    @endif
</div>
@endsection