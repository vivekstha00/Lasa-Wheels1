@extends('admin.layouts.master')    
@section('admin-content')
<body>
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-left: 16.666667%;">    
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-car me-2"></i>Manage Vehicles</h2>
            <!-- FIXED: Change admin.create to admin.vehicles.create -->
            <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New Vehicle
            </a>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Vehicle List ({{ $vehicles->total() ?? $vehicles->count() }} vehicles)</h5>
            </div>
            <div class="card-body">
                @if($vehicles->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Image</th>
                                    <th>Brand</th>
                                    <th>Model</th>
                                    <th>Type</th>
                                    <th>Year</th>
                                    <th>Price/Day</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vehicles as $vehicle)
                                    <tr>
                                        <td>
                                            @if($vehicle->image)
                                                <img src="{{ asset('storage/' . $vehicle->image) }}" 
                                                     alt="{{ $vehicle->brand }} {{ $vehicle->model }}" 
                                                     width="60" 
                                                     height="40" 
                                                     class="rounded"
                                                     style="object-fit: cover;">
                                            @else
                                                <div class="bg-secondary d-flex align-items-center justify-content-center rounded" 
                                                     style="width: 60px; height: 40px;">
                                                    <i class="fas fa-car text-light"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td><strong>{{ $vehicle->brand }}</strong></td>
                                        <td>{{ $vehicle->model }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $vehicle->type->name }}</span>
                                        </td>
                                        <td>{{ $vehicle->year }}</td>
                                        <td><strong>रू{{ number_format($vehicle->price_per_day, 2) }}</strong></td>
                                        <td>
                                            @if($vehicle->is_available)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Available
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>Not Available
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <!-- View Button -->
                                                <a href="{{ route('admin.vehicles.show', $vehicle->id) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <!-- FIXED: Change admin.edit to admin.vehicles.edit -->
                                                <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Edit Vehicle">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <!-- FIXED: Change admin.delete to admin.vehicles.destroy -->
                                                <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete {{ $vehicle->brand }} {{ $vehicle->model }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            title="Delete Vehicle">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if(method_exists($vehicles, 'links'))
                        <div class="d-flex justify-content-center mt-3">
                            {{ $vehicles->links() }}
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <i class="fas fa-car fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No vehicles found</h5>
                        <p class="text-muted">Start by adding your first vehicle to the system.</p>
                        <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add First Vehicle
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
@endsection