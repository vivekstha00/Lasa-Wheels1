@extends('user.layouts.master')

@section('user-content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Reset Password</h3>
                    
                    <!-- Step 1: Request OTP -->
                    <div id="step1">
                        <form id="forgotPasswordForm">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Send OTP</button>
                        </form>
                    </div>

                    <!-- Step 2: Verify OTP -->
                    <div id="step2" style="display: none;">
                        <form id="verifyOtpForm">
                            <div class="mb-3">
                                <label for="otp" class="form-label">Enter OTP</label>
                                <input type="text" class="form-control" id="otp" name="otp" maxlength="4" required>
                                <small class="text-muted">Check your email for the 4-digit code</small>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Verify OTP</button>
                        </form>
                    </div>

                    <!-- Step 3: Reset Password -->
                    <div id="step3" style="display: none;">
                        <form id="resetPasswordForm">
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Add JavaScript to handle the multi-step form
let currentEmail = '';
let currentOtp = '';

// Step 1: Send OTP
document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    currentEmail = email;
    
    fetch('/api/forgot-password', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step2').style.display = 'block';
            alert('OTP sent to your email!');
        } else {
            alert(data.error || 'Failed to send OTP');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
});

// Step 2: Verify OTP
document.getElementById('verifyOtpForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const otp = document.getElementById('otp').value;
    currentOtp = otp;
    
    fetch('/api/verify-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ 
            email: currentEmail,
            otp: otp 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            document.getElementById('step2').style.display = 'none';
            document.getElementById('step3').style.display = 'block';
            alert('OTP verified! Now set your new password.');
        } else {
            alert(data.error || 'Invalid OTP');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
});

// Step 3: Reset Password
document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const password = document.getElementById('password').value;
    const password_confirmation = document.getElementById('password_confirmation').value;
    
    if (password !== password_confirmation) {
        alert('Passwords do not match!');
        return;
    }
    
    fetch('/api/reset-password', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ 
            email: currentEmail,
            otp: currentOtp,
            password: password,
            password_confirmation: password_confirmation
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert('Password reset successful! You can now login with your new password.');
            window.location.href = '/login';
        } else {
            alert(data.error || 'Password reset failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
});
</script>
@endsection