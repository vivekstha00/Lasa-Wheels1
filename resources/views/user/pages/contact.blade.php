@extends('user.layouts.master')

@section('user-content')
<div class="container py-5">
    <h1 class="text-center mb-4">Contact Us</h1>
    <p class="text-center mb-5">Have questions? Get in touch with us using the form below.</p>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form>
                <div class="mb-3">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Your Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
