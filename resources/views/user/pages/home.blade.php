@extends('user.layouts.master')

@section('user-content')

<div class="container mt-5">
    <div class="row">
        <!-- Booking Form (Left Side) -->
        <div class="col-md-6">
            <h1 class="fw-bold mb-3">Vehicle Rentals</h1>
            <p class="lead text-muted mb-4">Your one-stop solution for renting vehicles with self-drive and with-driver options</p>
            
            <!-- Tabs for Self Drive / With Driver -->
            <ul class="nav nav-tabs mb-4" id="bookingTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="self-drive-tab" data-bs-toggle="tab" data-bs-target="#self-drive" type="button" role="tab" aria-controls="self-drive" aria-selected="true">
                        <i class="fas fa-car me-2"></i>Self Drive
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="with-driver-tab" data-bs-toggle="tab" data-bs-target="#with-driver" type="button" role="tab" aria-controls="with-driver" aria-selected="false">
                        <i class="fas fa-user me-2"></i>With Driver
                    </button>
                </li>
            </ul>
            
            <!-- Tab Content -->
            <div class="tab-content" id="bookingTabsContent">
                <!-- Self Drive Tab Content -->
                <div class="tab-pane fade show active" id="self-drive" role="tabpanel" aria-labelledby="self-drive-tab">
                    <form>
                        <div class="mb-3">
                            <label for="selfPickupLocation" class="form-label">
                                <i class="fas fa-map-marker-alt"></i> Pickup Location
                            </label>
                            <input type="text" class="form-control" id="selfPickupLocation" placeholder="Enter pickup location">
                        </div>
                        <div class="mb-3">
                            <label for="selfDropoffLocation" class="form-label">
                                <i class="fas fa-map-marker-alt"></i> Drop-off Location
                            </label>
                            <input type="text" class="form-control" id="selfDropoffLocation" placeholder="Enter drop-off location">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="selfPickupDate" class="form-label">
                                    <i class="fas fa-calendar-alt"></i> Pickup Date
                                </label>
                                <input type="date" class="form-control" id="selfPickupDate">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="selfReturnDate" class="form-label">
                                    <i class="fas fa-calendar-check"></i> Return Date
                                </label>
                                <input type="date" class="form-control" id="selfReturnDate">
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fas fa-search me-2"></i>Search Self Drive Vehicles
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- With Driver Tab Content -->
                <div class="tab-pane fade" id="with-driver" role="tabpanel" aria-labelledby="with-driver-tab">
                    <form>
                        <div class="mb-3">
                            <label for="driverPickupLocation" class="form-label">
                                <i class="fas fa-map-marker-alt"></i> Pickup Location
                            </label>
                            <input type="text" class="form-control" id="driverPickupLocation" placeholder="Enter pickup location">
                        </div>
                        <div class="mb-3">
                            <label for="driverTravelLocation" class="form-label">
                                <i class="fas fa-map-signs"></i> Travel Location
                            </label>
                            <input type="text" class="form-control" id="driverTravelLocation" placeholder="Enter travel location">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="driverPickupDate" class="form-label">
                                    <i class="fas fa-calendar-alt"></i> Pickup Date
                                </label>
                                <input type="date" class="form-control" id="driverPickupDate">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="driverReturnDate" class="form-label">
                                    <i class="fas fa-calendar-check"></i> Return Date
                                </label>
                                <input type="date" class="form-control" id="driverReturnDate">
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fas fa-search me-2"></i>Search With Driver Vehicles
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Featured Vehicle (Right Side) -->
        <div class="col-md-6">
            <div class="p-4 bg-light rounded">
                <h2>Featured Vehicles</h2>
                <p>Showcase your best vehicles or promotional content here.</p>
                <img src="{{asset('web/assets/images/gt3.jpeg') }}" class="img-fluid rounded" alt="Featured Vehicle">
            </div>
        </div>
    </div>
</div>

<!-- <style>
/* Keep normal icon colors in tabs */
.nav-tabs .nav-link i {
    color: #6c757d !important;
}

.nav-tabs .nav-link.active i {
    color: #6c757d !important;
}

.nav-tabs .nav-link:hover i {
    color: #6c757d !important;
}
</style> -->

@endsection