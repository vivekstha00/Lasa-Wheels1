<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to Our Platform</title>
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
        
        .social-links {
            margin: 20px 0;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            width: 40px;
            height: 40px;
            background: #667eea;
            border-radius: 50%;
            color: white;
            text-decoration: none;
            line-height: 40px;
            font-size: 18px;
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
                <div class="welcome-icon">🎉</div>
                <h1>Welcome to Our Platform!</h1>
                <p>Your journey starts here</p>
            </div>
            
            <!-- Main content -->
            <div class="content">
                <div class="greeting">
                    Hello {{ $mailData['name'] }}! 👋
                </div>
                
                <div class="message">
                    <p>We're absolutely <strong>thrilled</strong> to have you join our amazing community! 🚀</p>
                    
                    <p>Your account has been successfully created, and you're now part of something special. We've built this platform with love and care, just for people like you.</p>
                </div>
                
                <div class="divider"></div>
                
                <!-- Features section -->
                <div class="features">
                    <h3>🌟 What's waiting for you:</h3>
                    <ul class="feature-list">
                        <li>Access to premium vehicle rentals</li>
                        <li>24/7 customer support</li>
                        <li>Exclusive member discounts</li>
                        <li>Easy booking management</li>
                        <li>Loyalty rewards program</li>
                    </ul>
                </div>
                
                <div style="text-align: center;">
                    <a href="{{ url('/') }}" class="cta-button">
                        🚗 Start Exploring Now
                    </a>
                </div>
                
                <div class="message">
                    <p>If you have any questions or need assistance, our friendly support team is always here to help. Just reply to this email or visit our help center.</p>
                    
                    <p><strong>Welcome aboard!</strong> 🎊</p>
                    
                    <p>Best regards,<br>
                    <strong>The Vehicle Rental Team</strong></p>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <div class="social-links">
                    <a href="#" title="Facebook">📘</a>
                    <a href="#" title="Twitter">🐦</a>
                    <a href="#" title="Instagram">📷</a>
                    <a href="#" title="LinkedIn">💼</a>
                </div>
                
                <p>© {{ date('Y') }} Vehicle Rental Platform. All rights reserved.</p>
                <p>You're receiving this email because you just signed up for our platform.</p>
            </div>
        </div>
    </div>
</body>
</html>