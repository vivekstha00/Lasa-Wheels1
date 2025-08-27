<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset OTP</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .email-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }
        
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        
        .lock-icon {
            background: rgba(255,255,255,0.2);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
        }
        
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        
        .otp-box {
            background: #f8f9fa;
            border: 3px dashed #667eea;
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
        }
        
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
            letter-spacing: 8px;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
        }
        
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
        
        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #eee;
        }
        
        .footer p {
            margin: 0;
            color: #888;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-card">
            <!-- Header -->
            <div class="header">
                <div class="lock-icon">🔐</div>
                <h1>Password Reset OTP</h1>
                <p>LasaWheel Security Code</p>
            </div>
            
            <!-- Content -->
            <div class="content">
                <h2>🔑 Your Password Reset Code</h2>
                
                <p>We received a request to reset your password. Please use the following OTP code to proceed:</p>
                
                <div class="otp-box">
                    <p style="margin: 0; font-size: 18px; color: #666;">Your OTP Code:</p>
                    <div class="otp-code">{{ $otp }}</div>
                    <p style="margin: 0; font-size: 14px; color: #999;">Enter this code to reset your password</p>
                </div>
                
                <div class="warning">
                    <strong>⚠️ Security Notice:</strong><br>
                    • This OTP is valid for 10 minutes only<br>
                    • Don't share this code with anyone<br>
                    • If you didn't request this, please ignore this email
                </div>
                
                <p style="color: #666; margin-top: 30px;">
                    If you have any concerns about your account security, please contact our support team immediately.
                </p>
                
                <p><strong>Best regards,</strong><br>
                <strong>The LasaWheel Security Team</strong></p>
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <p>© {{ date('Y') }} LasaWheel. All rights reserved.</p>
                <p>This is an automated security email. Please do not reply.</p>
            </div>
        </div>
    </div>
</body>
</html>