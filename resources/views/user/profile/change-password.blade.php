@extends('user.layouts.master')

@section('user-content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3><i class="fas fa-lock me-2"></i>Change Password</h3>
                <a href="{{ route('user.profile.index') }}" class="btn btn-secondary">Back</a>
            </div>

            <!-- Messages -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Simple Form -->
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.profile.update-password') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <div class="input-group">
                                <input type="password" name="current_password" class="password form-control" required>
                                <span class="input-group-text" style="cursor: pointer;">
                                    <i class="bi password-toggle bi-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="password form-control" required>
                                <span class="input-group-text" style="cursor: pointer;">
                                    <i class="bi password-toggle bi-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" class="password form-control" required>
                                <span class="input-group-text" style="cursor: pointer;">
                                    <i class="bi password-toggle bi-eye"></i>
                                </span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.profile.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Change Password</button>
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