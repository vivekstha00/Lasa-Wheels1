<!-- Sidebar -->
<div class="col-md-3 col-lg-2 d-md-block bg-dark text-white vh-100 position-fixed p-3">
    <h5 class="text-uppercase border-bottom pb-2">Admin Menu</h5>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.users.index') }}">
                <i class="fas fa-users me-2"></i>Manage Users
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.vehicles.index') }}">
                <i class="fas fa-car me-2"></i>Manage Vehicles
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.bookings.index') }}">
                <i class="fas fa-book me-2"></i>Manage Bookings
            </a>
        </li>
        <li class="nav-item">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </button>
            </form>
        </li>
    </ul>
</div>