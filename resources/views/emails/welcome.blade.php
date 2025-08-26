<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to LasaWheel</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }
        
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        
        .welcome-icon {
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
        }
        
        .greeting {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .message {
            color: #666;
            line-height: 1.8;
            font-size: 16px;
            margin-bottom: 30px;
        }
        
        .features {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin: 30px 0;
        }
        
        .features h3 {
            color: #333;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .feature-list li {
            color: #666;
            margin-bottom: 10px;
            padding-left: 25px;
            position: relative;
        }
        
        .feature-list li:before {
            content: "✅";
            position: absolute;
            left: 0;
        }
        
        .cta-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 50px;
            display: inline-block;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: transform 0.3s ease;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
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
        
        .admin-note {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .divider {
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #667eea);
            margin: 30px 0;
            border-radius: 2px;
        }
        
        @media only screen and (max-width: 600px) {
            .email-container {
                padding: 10px;
            }
            
            .content {
                padding: 30px 20px;
            }
            
            .greeting {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-card">
            <!-- Header with gradient background -->
            <div class="header">
                <div class="welcome-icon">🚗</div>
                <h1>Welcome to LasaWheel!</h1>
                <p>Your premium vehicle rental experience starts here</p>
            </div>
            
            <!-- Main content -->
            <div class="content">
                <div class="greeting">
                    Hello {{ $mailData['name'] }}! 👋
                </div>
                
                <div class="message">
                    @if(isset($mailData['created_by']) && $mailData['created_by'] === 'admin')
                        <div class="admin-note">
                            <strong>🔧 Account Created by Administrator</strong><br>
                            Your account has been created by {{ $mailData['admin_name'] ?? 'our admin team' }}. 
                            You can now access our platform using your registered email.
                        </div>
                    @endif
                    
                    <p>We're absolutely <strong>thrilled</strong> to have you join the LasaWheel family! 🚀</p>
                    
                    <p>Your account has been successfully created, and you're now part of Nepal's premier vehicle rental platform. We've built this service with care and precision, just for travelers and adventurers like you.</p>
                </div>
                
                <div class="divider"></div>
                
                <!-- Features section -->
                <div class="features">
                    <h3>🌟 What's waiting for you:</h3>
                    <ul class="feature-list">
                        <li>Premium vehicle fleet (Cars, Bikes, SUVs)</li>
                        <li>24/7 customer support in Nepal</li>
                        <li>Exclusive member discounts</li>
                        <li>Easy booking management</li>
                        <li>Loyalty rewards program</li>
                        <li>GPS tracking and roadside assistance</li>
                    </ul>
                </div>
                
                <div style="text-align: center;">
                    <a href="{{ url('/') }}" class="cta-button">
                        🚗 Start Your Journey Now
                    </a>
                </div>
                
                <div class="message">
                    @if(isset($mailData['created_by']) && $mailData['created_by'] === 'admin')
                        <p><strong>📧 Account Details:</strong><br>
                        Email: {{ $mailData['email'] }}<br>
                        <small>Please contact your administrator for your login password.</small></p>
                    @else
                        <p><strong>🎊 You're all set!</strong> You can now log in to your account and start exploring our amazing vehicle collection.</p>
                    @endif
                    
                    <p>If you have any questions or need assistance, our friendly support team is always here to help. Just reply to this email or visit our help center.</p>
                    
                    <p><strong>Happy travels with LasaWheel!</strong> 🎊</p>
                    
                    <p>Best regards,<br>
                    <strong>The LasaWheel Team</strong><br>
                    <small>Nepal's Trusted Vehicle Rental Platform</small></p>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <p>© {{ date('Y') }} LasaWheel. All rights reserved.</p>
                <p>Kathmandu, Nepal | Email: support@lasawheel.com</p>
                <p>You're receiving this email because you have an account with LasaWheel.</p>
            </div>
        </div>
    </div>
</body>
</html>