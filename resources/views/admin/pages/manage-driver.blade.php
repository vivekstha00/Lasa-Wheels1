@extends('admin.layouts.master')    
@section('admin-content')

<div class="container-fluid py-4">
    <div class="row">
        <!-- Main -->
        <div class="col-md-9">
            <h2 class="mb-4">Manage Drivers</h2>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Driver ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Assigned Vehicle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#D01</td>
                                    <td>Robert King</td>
                                    <td>robert@example.com</td>
                                    <td>+1 123-456-7890</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>Toyota Corolla</td>
                                </tr>
                                <tr>
                                    <td>#D02</td>
                                    <td>Linda Carter</td>
                                    <td>linda@example.com</td>
                                    <td>+1 555-987-6543</td>
                                    <td><span class="badge bg-warning">On Leave</span></td>
                                    <td>Honda Civic</td>
                                </tr>
                                <tr>
                                    <td>#D03</td>
                                    <td>James Wilson</td>
                                    <td>james@example.com</td>
                                    <td>+1 444-222-1111</td>
                                    <td><span class="badge bg-danger">Inactive</span></td>
                                    <td>—</td>
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
