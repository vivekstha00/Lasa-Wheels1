<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .vehicle-card {
            transition: transform 0.3s;
            height: 100%;
        }
        .vehicle-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .filter-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .price-tag {
            font-size: 1.5rem;
            font-weight: bold;
            color: #198754;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Vehicle Rental</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <h1 class="text-center mb-5">Available Vehicles for Rent</h1>
        
        <!-- Filter Section -->
        <div class="filter-section">
            <h4 class="mb-4">Filter Vehicles</h4>
            <form method="GET" action="{{ route('home') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="type" class="form-label">Vehicle Type</label>
                        <select class="form-select" id="type" name="type">
                            <option value="">All Types</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ request('type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control" id="model" name="model" placeholder="Model" value="{{ request('model') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="fuel" class="form-label">Fuel Type</label>
                        <select class="form-select" id="fuel" name="fuel">
                            <option value="">All Fuel Types</option>
                            @foreach($fuels as $fuel)
                                <option value="{{ $fuel->id }}" {{ request('fuel') == $fuel->id ? 'selected' : '' }}>{{ $fuel->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="transmission" class="form-label">Transmission</label>
                        <select class="form-select" id="transmission" name="transmission">
                            <option value="">All Transmissions</option>
                            @foreach($transmissions as $transmission)
                                <option value="{{ $transmission->id }}" {{ request('transmission') == $transmission->id ? 'selected' : '' }}>{{ $transmission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="{{ route('home') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Vehicles Listing -->
        @if($vehicles->count() > 0)
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($vehicles as $vehicle)
                    <div class="col">
                        <div class="card h-100 vehicle-card">
                            @if($vehicle->image)
                                <img src="{{ asset('storage/' . $vehicle->image) }}" class="card-img-top" alt="{{ $vehicle->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-car fa-3x text-light"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $vehicle->name }}</h5>
                                <p class="card-text">{{ $vehicle->description }}</p>
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item"><strong>Type:</strong> {{ $vehicle->type->name }}</li>
                                    <li class="list-group-item"><strong>Model:</strong> {{ $vehicle->model }}</li>
                                    <li class="list-group-item"><strong>Fuel:</strong> {{ $vehicle->fuel->name }}</li>
                                    <li class="list-group-item"><strong>Transmission:</strong> {{ $vehicle->transmission->name }}</li>
                                </ul>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price-tag">${{ number_format($vehicle->price_per_day, 2) }}/day</span>
                                    <button class="btn btn-primary">Rent Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $vehicles->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-car fa-5x text-muted mb-3"></i>
                <h3>No vehicles found</h3>
                <p class="text-muted">Try adjusting your filters to find what you're looking for.</p>
            </div>
        @endif
    </div>

    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2023 Vehicle Rental. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>