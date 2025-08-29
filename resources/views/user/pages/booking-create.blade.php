@extends('user.layouts.master')

@section('user-content')

<div class="container py-5">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-calendar-check me-2"></i>Book Vehicle</h2>
                    <p class="text-muted mb-0">Complete the form below to book your vehicle</p>
                </div>
                <a href="{{ route('vehicle.show', $vehicle->id) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Vehicle
                </a>
            </div>
        </div>
    </div>

    <!-- Error/Success Messages -->
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

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <!-- Vehicle Summary -->
        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header">
                    <h5 class="mb-0">Vehicle Summary</h5>
                </div>
                <div class="card-body">
                    <!-- Vehicle Image -->
                    @if($vehicle->image)
                        <img src="{{ asset('storage/' . $vehicle->image) }}" class="img-fluid rounded mb-3" alt="{{ $vehicle->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-secondary d-flex align-items-center justify-content-center rounded mb-3" style="height: 200px;">
                            <i class="fas fa-car fa-3x text-light"></i>
                        </div>
                    @endif

                    <!-- Vehicle Details -->
                    <h6 class="fw-bold">{{ $vehicle->brand }} {{ $vehicle->name }}</h6>
                    <p class="text-muted small mb-2">{{ $vehicle->model }} ({{ $vehicle->year }})</p>
                    
                    <div class="row text-center mb-3">
                        <div class="col-4">
                            <i class="fas fa-car text-primary"></i>
                            <div class="small">{{ $vehicle->type->name }}</div>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-gas-pump text-primary"></i>
                            <div class="small">{{ $vehicle->fuel->name }}</div>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-cog text-primary"></i>
                            <div class="small">{{ $vehicle->transmission->name }}</div>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Price per day:</span>
                            <span class="fw-bold">रू{{ number_format($vehicle->price_per_day, 2) }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between">
                            <span>Total days:</span>
                            <span id="totalDays" class="fw-bold">0</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Subtotal:</span>
                            <span id="subtotal" class="fw-bold">रू0.00</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Total Amount:</span>
                            <span id="totalAmount" class="fw-bold text-primary fs-5">रू0.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Booking Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                        
                        <!-- Date Selection -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pickup_date" class="form-label">Pickup Date <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('pickup_date') is-invalid @enderror" 
                                       id="pickup_date" 
                                       name="pickup_date"
                                       value="{{ old('pickup_date') }}"
                                       min="{{ date('Y-m-d') }}"
                                       required>
                                @error('pickup_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Select your preferred pickup date</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="return_date" class="form-label">Return Date <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('return_date') is-invalid @enderror" 
                                       id="return_date" 
                                       name="return_date"
                                       value="{{ old('return_date') }}"
                                       required>
                                @error('return_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Select your return date</div>
                            </div>
                        </div>
                        
                        <!-- Location -->
                        <div class="mb-3">
                            <label for="pickup_location" class="form-label">Pickup Location <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('pickup_location') is-invalid @enderror" 
                                   id="pickup_location" 
                                   name="pickup_location"
                                   value="{{ old('pickup_location') }}"
                                   placeholder="Enter your preferred pickup location" 
                                   required>
                            @error('pickup_location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">We'll arrange pickup from your specified location</div>
                        </div>


                        <!-- Terms and Conditions -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" target="_blank">Terms and Conditions</a> and <a href="#" target="_blank">Privacy Policy</a> <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>
                                <i class="fas fa-calendar-check me-2"></i>Confirm Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pickupDate = document.getElementById('pickup_date');
    const returnDate = document.getElementById('return_date');
    const totalDaysSpan = document.getElementById('totalDays');
    const subtotalSpan = document.getElementById('subtotal');
    const totalAmountSpan = document.getElementById('totalAmount');
    const submitBtn = document.getElementById('submitBtn');
    const termsCheckbox = document.getElementById('terms');
    const pricePerDay = {{ $vehicle->price_per_day }};

    function calculateTotal() {
        if (pickupDate.value && returnDate.value) {
            const pickup = new Date(pickupDate.value);
            const returnD = new Date(returnDate.value);
            
            if (returnD > pickup) {
                const diffTime = Math.abs(returnD - pickup);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                const totalAmount = diffDays * pricePerDay;
                
                totalDaysSpan.textContent = diffDays;
                subtotalSpan.textContent = 'रू' + totalAmount.toLocaleString('en-IN', {minimumFractionDigits: 2});
                totalAmountSpan.textContent = 'रू' + totalAmount.toLocaleString('en-IN', {minimumFractionDigits: 2});
                
                checkFormValid();
            } else {
                resetCalculation();
            }
        } else {
            resetCalculation();
        }
    }

    function resetCalculation() {
        totalDaysSpan.textContent = '0';
        subtotalSpan.textContent = 'रू0.00';
        totalAmountSpan.textContent = 'रू0.00';
        checkFormValid();
    }

    function checkFormValid() {
        const isValid = pickupDate.value && 
                       returnDate.value && 
                       new Date(returnDate.value) > new Date(pickupDate.value) && 
                       termsCheckbox.checked;
        submitBtn.disabled = !isValid;
    }

    // Event listeners
    pickupDate.addEventListener('change', function() {
        returnDate.min = this.value;
        calculateTotal();
    });

    returnDate.addEventListener('change', calculateTotal);
    termsCheckbox.addEventListener('change', checkFormValid);

    // Initial check
    checkFormValid();
});
</script>

@endsection