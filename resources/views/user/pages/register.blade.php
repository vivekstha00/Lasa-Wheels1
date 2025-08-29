@extends('user.layouts.master')

@section('user-content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-user-plus me-2"></i>User Registration</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.register.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                   id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" 
                                   placeholder="" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password"
                                    class="password form-control @error('password') is-invalid @enderror"
                                    value="{{ old('password') }}">
                                <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                    <i class="bi password-toggle bi-eye"></i>
                                </span>
                            </div>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Driving License Upload -->
                        <div class="mb-3">
                            <label for="driving_license" class="form-label">Driving License <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('driving_license') is-invalid @enderror" 
                                   id="driving_license" name="driving_license" 
                                   accept=".jpg,.jpeg,.png,.pdf" required>
                            <div class="form-text">Upload your driving license (JPG, PNG, or PDF format, max 2MB)</div>
                            @error('driving_license')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Register
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center mt-3">
                            <p class="mb-0">Already have an account? 
                                <a href="{{ route('user.login') }}" class="text-primary text-decoration-none">
                                    <i class="fas fa-sign-in-alt me-1"></i>Back to Login
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('body').on('click', '.password-toggle', function() {
            if ($(this).hasClass('bi-eye')) {
                $(this).removeClass('bi-eye');
                $(this).addClass('bi-eye-slash');
                $('.password').attr('type', 'text');
            } else { // bi-eye xaina
                $(this).removeClass('bi-eye-slash');
                $(this).addClass('bi-eye');
                $('.password').attr('type', 'password');
            }
        });
    });
</script>
@endpush