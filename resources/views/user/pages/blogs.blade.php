@extends('user.layouts.master')

@section('user-content')
<div class="container py-5">
    <h1 class="text-center mb-4">Latest Blogs</h1>
    <p class="text-center mb-5">Read our latest articles, tips, and updates about vehicle rentals and travel.</p>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="bg-secondary d-flex align-items-center justify-content-center" style="height:200px;">
                    <i class="fas fa-pen fa-2x text-light"></i>
                </div>
                <div class="card-body">
                    <h5 class="card-title">How to Choose the Best Rental Vehicle</h5>
                    <p class="card-text">Tips for selecting the right vehicle for your journey, whether for business or leisure...</p>
                    <a href="#" class="btn btn-primary">Read More</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="bg-secondary d-flex align-items-center justify-content-center" style="height:200px;">
                    <i class="fas fa-pen fa-2x text-light"></i>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Top 5 Travel Destinations by Car</h5>
                    <p class="card-text">Discover some amazing places you can explore with your rental car this season...</p>
                    <a href="#" class="btn btn-primary">Read More</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="bg-secondary d-flex align-items-center justify-content-center" style="height:200px;">
                    <i class="fas fa-pen fa-2x text-light"></i>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Why Renting is Better than Buying</h5>
                    <p class="card-text">Learn about the financial and practical benefits of renting a vehicle instead of purchasing...</p>
                    <a href="#" class="btn btn-primary">Read More</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
