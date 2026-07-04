<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>We've Received Your Message</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; border: 1px solid #e0e0e0; border-top: none; }
        .footer { text-align: center; margin-top: 20px; color: #999; font-size: 12px; }
        .button { display: inline-block; background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div style="margin-bottom: 10px;">
                <img src="{{ asset('assets/img/logo.png') }}" alt="{{ config('app.name') }} Logo" style="max-height: 60px; width: auto; display: block; margin: 0 auto;">
            </div> 
            <h2 style="margin: 0;">Thank You for Reaching Out!</h2>
        </div>
        <div class="content">
            <h3>Dear {{ $name }},</h3>
            <p>Thank you for contacting us. We have received your message and will get back to you as soon as possible.</p>
            <p style="color: #666;">We typically respond within 24-48 hours during business days.</p>
            <div style="text-align: center;">
                <a href="{{ url('/') }}" class="button">Visit Our Gallery</a>
            </div>
            <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 20px 0;">
            <p style="color: #666; font-size: 14px;">
                <strong>Need immediate assistance?</strong><br>
                Call us: <a href="tel:{{ $phone ?? '+1234567890' }}">{{ $phone ?? '+1234567890' }}</a>
            </p>
            <p style="color: #666; font-size: 14px;">
                <strong>Visit us:</strong><br>
                {{ $address ?? 'Lagos, Nigeria' }}
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>