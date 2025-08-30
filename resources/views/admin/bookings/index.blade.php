@extends('admin.layouts.master')

@section('admin-content')
<body>
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-left: 16.666667%;">    
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2><i class="fas fa-calendar-check me-2"></i>Booking Management</h2>
                        <p class="text-muted mb-0">Manage all vehicle bookings</p>
                    </div>
                    <div class="d-flex gap-2">
                        <span class="badge bg-warning">Pending: {{ $bookings->where('status', 'pending')->count() }}</span>
                        <span class="badge bg-info">Confirmed: {{ $bookings->where('status', 'confirmed')->count() }}</span>
                        <span class="badge bg-success">Active: {{ $bookings->where('status', 'active')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.bookings.index') }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Filter by Status</label>
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
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Search by booking ID or customer name" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search me-1"></i>Filter
                            </button>
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Clear
                            </a>
                        </div>
                    </div>
                </form>
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

        <!-- Bookings Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Customer</th>
                                <th>Vehicle</th>
                                <th>Dates</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Booked On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td>
                                        <strong>#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $booking->user->name }}</strong><br>
                                            <small class="text-muted">{{ $booking->user->email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $booking->vehicle->brand ?? '' }} {{ $booking->vehicle->name }}</strong><br>
                                            <small class="text-muted">{{ $booking->vehicle->model }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <small><strong>Pickup:</strong> {{ \Carbon\Carbon::parse($booking->pickup_date)->format('M d, Y') }}</small><br>
                                            <small><strong>Return:</strong> {{ \Carbon\Carbon::parse($booking->return_date)->format('M d, Y') }}</small><br>
                                            <small class="text-muted">{{ $booking->total_days }} days</small>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>रू{{ number_format($booking->total_amount, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $booking->status == 'pending' ? 'warning' : ($booking->status == 'confirmed' ? 'info' : ($booking->status == 'active' ? 'success' : ($booking->status == 'completed' ? 'secondary' : 'danger'))) }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $booking->created_at->format('M d, Y') }}<br>
                                        <small class="text-muted">{{ $booking->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if($booking->status == 'pending')
                                                <form method="POST" action="{{ route('admin.bookings.approve', $booking->id) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Approve this booking?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.bookings.reject', $booking->id) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Reject this booking?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @elseif($booking->status == 'confirmed')
                                                <form method="POST" action="{{ route('admin.bookings.active', $booking->id) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Mark as picked up?')">
                                                        <i class="fas fa-car"></i>
                                                    </button>
                                                </form>
                                            @elseif($booking->status == 'active')
                                                <form method="POST" action="{{ route('admin.bookings.complete', $booking->id) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm('Mark as completed?')">
                                                        <i class="fas fa-flag-checkered"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No bookings found</h5>
                                        <p class="text-muted">No bookings match your current filters.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $bookings->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</body>
@endsection