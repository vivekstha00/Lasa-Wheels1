@extends('user.layouts.master')

@section('user-content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">🔐 Reset Password</h3>
                    
                    <!-- Step 1: Request OTP -->
                    <div id="step1">
                        <form id="forgotPasswordForm">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" id="sendBtn">Send OTP</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('user.login') }}" class="text-decoration-none">
                                <small>← Back to Login</small>
                            </a>
                        </div>
                    </div>

                    <!-- Step 2: Verify OTP -->
                    <div id="step2" style="display: none;">
                        <div class="alert alert-success">
                            <i class="fas fa-envelope me-2"></i>
                            OTP sent to <strong id="emailDisplay"></strong>
                        </div>
                        <form id="verifyOtpForm">
                            <div class="mb-3">
                                <label for="otp" class="form-label">Enter OTP</label>
                                <input type="text" class="form-control text-center" id="otp" name="otp" maxlength="4" placeholder="0000" required>
                                <small class="text-muted">Check your email for the 4-digit code</small>
                            </div>
                            <button type="submit" class="btn btn-success w-100" id="verifyBtn">Verify OTP</button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-link btn-sm" onclick="goBackToStep1()">
                                ← Send OTP Again
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Reset Password -->
                    <div id="step3" style="display: none;">
                        <div class="alert alert-info">
                            <i class="fas fa-shield-alt me-2"></i>
                            Create a strong password for your account
                        </div>
                        <form id="resetPasswordForm">
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" minlength="6" required>
                                <small class="text-muted">Minimum 6 characters</small>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" minlength="6" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100" id="resetBtn">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentEmail = '';
let currentOtp = '';

// Function to go back to step 1
function goBackToStep1() {
    document.getElementById('step2').style.display = 'none';
    document.getElementById('step1').style.display = 'block';
    document.getElementById('email').value = currentEmail;
}

// Step 1: Send OTP
document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const sendBtn = document.getElementById('sendBtn');
    
    if (!email) {
        alert('Please enter your email address');
        return;
    }
    
    currentEmail = email;
    
    // Show loading state
    sendBtn.disabled = true;
    sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    fetch('/api/forgot-password', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        sendBtn.disabled = false;
        sendBtn.innerHTML = 'Send OTP';
        
        if (data.message) {
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step2').style.display = 'block';
            document.getElementById('emailDisplay').textContent = email;
            // Focus on OTP input
            setTimeout(() => document.getElementById('otp').focus(), 100);
        } else {
            alert('❌ ' + (data.error || 'Failed to send OTP'));
        }
    })
    .catch(error => {
        sendBtn.disabled = false;
        sendBtn.innerHTML = 'Send OTP';
        alert('❌ Network error. Please try again.');
    });
});

// Step 2: Verify OTP
document.getElementById('verifyOtpForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const otp = document.getElementById('otp').value;
    const verifyBtn = document.getElementById('verifyBtn');
    
    if (!otp || otp.length !== 4) {
        alert('Please enter a valid 4-digit OTP');
        return;
    }
    
    currentOtp = otp;
    
    verifyBtn.disabled = true;
    verifyBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Verifying...';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    fetch('/api/verify-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ 
            email: currentEmail,
            otp: otp 
        })
    })
    .then(response => response.json())
    .then(data => {
        verifyBtn.disabled = false;
        verifyBtn.innerHTML = 'Verify OTP';
        
        if (data.message) {
            document.getElementById('step2').style.display = 'none';
            document.getElementById('step3').style.display = 'block';
            // Focus on password input
            setTimeout(() => document.getElementById('password').focus(), 100);
        } else {
            alert('❌ ' + (data.error || 'Invalid OTP'));
            document.getElementById('otp').value = '';
            document.getElementById('otp').focus();
        }
    })
    .catch(error => {
        verifyBtn.disabled = false;
        verifyBtn.innerHTML = 'Verify OTP';
        alert('❌ An error occurred. Please try again.');
    });
});

// Step 3: Reset Password
document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const password = document.getElementById('password').value;
    const password_confirmation = document.getElementById('password_confirmation').value;
    const resetBtn = document.getElementById('resetBtn');
    
    if (password !== password_confirmation) {
        alert('❌ Passwords do not match!');
        return;
    }
    
    if (password.length < 6) {
        alert('❌ Password must be at least 6 characters long');
        return;
    }
    
    resetBtn.disabled = true;
    resetBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Resetting...';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    fetch('/api/reset-password', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json'
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
        resetBtn.disabled = false;
        resetBtn.innerHTML = 'Reset Password';
        
        if (data.message) {
            alert('✅ Password reset successful! You can now login with your new password.');
            window.location.href = '/login';
        } else {
            alert('❌ ' + (data.error || 'Password reset failed'));
        }
    })
    .catch(error => {
        resetBtn.disabled = false;
        resetBtn.innerHTML = 'Reset Password';
        alert('❌ An error occurred. Please try again.');
    });
});

// Auto-format OTP input
document.getElementById('otp').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
@endsection