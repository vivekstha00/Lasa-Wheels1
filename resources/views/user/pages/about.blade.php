@extends('user.layouts.master')

@section('user-content')
<div class="container py-5">
    <h1 class="text-center mb-4">About Us</h1>
    <p class="text-center mb-5">
        Welcome to our vehicle rental service. We provide a wide range of cars, bikes, and other vehicles 
        for rent at affordable prices. Our mission is to make traveling easier and more comfortable 
        for everyone.
    </p>

    <div class="row g-4">
        <div class="col-md-4 text-center">
            <i class="fas fa-car fa-3x mb-3"></i>
            <h5>Wide Range of Vehicles</h5>
            <p>Choose from cars, bikes, and more to suit your needs.</p>
        </div>
        <div class="col-md-4 text-center">
            <i class="fas fa-dollar-sign fa-3x mb-3"></i>
            <h5>Affordable Pricing</h5>
            <p>Competitive rental prices with no hidden charges.</p>
        </div>
        <div class="col-md-4 text-center">
            <i class="fas fa-headset fa-3x mb-3"></i>
            <h5>24/7 Support</h5>
            <p>Our support team is always ready to assist you.</p>
        </div>
    </div>
</div>
@endsection
