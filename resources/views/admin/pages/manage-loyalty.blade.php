@extends('admin.layouts.master')    
@section('admin-content')

<div class="container-fluid py-4">
    <div class="row">
        <!-- Main -->
        <div class="col-md-9">
            <h2 class="mb-4">User Loyalty Points</h2>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Total Bookings</th>
                                    <th>Loyalty Points</th>
                                    <th>Tier</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Doe</td>
                                    <td>john@example.com</td>
                                    <td>12</td>
                                    <td>1200</td>
                                    <td><span class="badge bg-success">Gold</span></td>
                                </tr>
                                <tr>
                                    <td>Jane Smith</td>
                                    <td>jane@example.com</td>
                                    <td>8</td>
                                    <td>650</td>
                                    <td><span class="badge bg-warning">Silver</span></td>
                                </tr>
                                <tr>
                                    <td>Mike Johnson</td>
                                    <td>mike@example.com</td>
                                    <td>3</td>
                                    <td>200</td>
                                    <td><span class="badge bg-secondary">Bronze</span></td>
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
