@extends('admin.layouts.master')    
@section('admin-content')

<div class="container-fluid py-4">
    <div class="row">

        <!-- Main -->
        <div class="col-md-9">
            <h2 class="mb-4">Booking Records</h2>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>User</th>
                                    <th>Vehicle</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#101</td>
                                    <td>John Doe</td>
                                    <td>Toyota Corolla</td>
                                    <td>2025-08-01</td>
                                    <td>2025-08-05</td>
                                    <td><span class="badge bg-success">Confirmed</span></td>
                                </tr>
                                <tr>
                                    <td>#102</td>
                                    <td>Jane Smith</td>
                                    <td>Honda Civic</td>
                                    <td>2025-08-10</td>
                                    <td>2025-08-12</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>#103</td>
                                    <td>Mike Johnson</td>
                                    <td>Ford Focus</td>
                                    <td>2025-08-15</td>
                                    <td>2025-08-18</td>
                                    <td><span class="badge bg-danger">Cancelled</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
