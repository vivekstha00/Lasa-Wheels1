@extends('user.layouts.master')

@section('user-content')
<div class="container py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h3><i class="fas fa-star me-2 text-warning"></i>Loyalty Points</h3>
            <p class="text-muted">Track your rewards and redeem discounts</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('user.profile.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Profile
            </a>
        </div>
    </div>

    <!-- Points Overview -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-star fa-2x text-warning mb-2"></i>
                    <h2 class="text-warning fw-bold">{{ number_format($user->loyalty_points ?? 0) }}</h2>
                    <p class="mb-0">Available Points</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-money-bill fa-2x text-success mb-2"></i>
                    <h2 class="text-success fw-bold">रू{{ number_format($totalSpent ?? 0) }}</h2>
                    <p class="mb-0">Total Spent</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fas fa-trophy fa-2x text-info mb-2"></i>
                    <h2 class="text-info fw-bold">{{ $pointsHistory->count() ?? 0 }}</h2>
                    <p class="mb-0">Completed Trips</p>
                </div>
            </div>
        </div>
    </div>

    <!-- How Points Work -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>How Loyalty Points Work</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-success"><i class="fas fa-coins me-2"></i>Earning Points</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i>1 point for every रू100 spent</li>
                        <li><i class="fas fa-check text-success me-2"></i>Points credited after trip completion</li>
                        <li><i class="fas fa-check text-success me-2"></i>No expiry on earned points</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary"><i class="fas fa-gift me-2"></i>Redeeming Points</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-star text-warning me-2"></i>100 points = रू10 discount</li>
                        <li><i class="fas fa-star text-warning me-2"></i>500 points = रू60 discount</li>
                        <li><i class="fas fa-star text-warning me-2"></i>1000 points = रू150 discount</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Redeem Points -->
    @if($user->loyalty_points >= 100)
        <div class="card mb-4 border-warning">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-gift me-2"></i>Redeem Your Points</h5>
            </div>
            <div class="card-body">
                <p class="mb-3">You have <strong>{{ number_format($user->loyalty_points) }} points</strong> ready to use!</p>
                <div class="row">
                    @if($user->loyalty_points >= 100)
                        <div class="col-md-4 mb-2">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5>100 Points</h5>
                                    <h6 class="text-success">रू10 OFF</h6>
                                    <button class="btn btn-outline-warning btn-sm">Use Now</button>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($user->loyalty_points >= 500)
                        <div class="col-md-4 mb-2">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5>500 Points</h5>
                                    <h6 class="text-success">रू60 OFF</h6>
                                    <button class="btn btn-outline-warning btn-sm">Use Now</button>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($user->loyalty_points >= 1000)
                        <div class="col-md-4 mb-2">
                            <div class="card border-warning">
                                <div class="card-body text-center">
                                    <h5>1000 Points</h5>
                                    <h6 class="text-success">रू150 OFF</h6>
                                    <span class="badge bg-warning text-dark mb-2">Best Value!</span>
                                    <br>
                                    <button class="btn btn-warning btn-sm">Use Now</button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Points History -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-history me-2"></i>Points History</h5>
        </div>
        <div class="card-body">
            @if($pointsHistory && $pointsHistory->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount Spent</th>
                                <th>Points Earned</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pointsHistory as $history)
                                <tr>
                                    <td>
                                        <strong>{{ $history['date']->format('M d, Y') }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $history['date']->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <div>
                                            {{ $history['description'] }}
                                            <br>
                                            <small class="text-muted">Trip completed successfully</small>
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="text-success">रू{{ number_format($history['amount']) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-star"></i> {{ $history['points'] }} points
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> Credited
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-star fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No Points Earned Yet</h5>
                    <p class="text-muted">Complete your first booking to start earning points!</p>
                    <a href="{{ route('vehicle') }}" class="btn btn-primary">
                        <i class="fas fa-car me-2"></i>Book Your First Vehicle
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection