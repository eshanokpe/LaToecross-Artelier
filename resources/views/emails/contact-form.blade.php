<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Message</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; border: 1px solid #e0e0e0; border-top: none; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #555; }
        .value { background: white; padding: 8px 12px; border-radius: 4px; border: 1px solid #e0e0e0; margin-top: 4px; }
        .footer { text-align: center; margin-top: 20px; color: #999; font-size: 12px; }
        .badge { display: inline-block; background: #DB2077; color: white; padding: 2px 10px; border-radius: 12px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div style="margin-bottom: 10px;">
                <img src="{{ asset('assets/img/logo.png') }}" alt="{{ config('app.name') }} Logo" style="max-height: 60px; width: auto; display: block; margin: 0 auto;">
            </div>
            <h2 style="margin: 0;">New Contact Message</h2>
            <span class="badge">{{ now()->format('M d, Y h:i A') }}</span>
        </div>
        <div class="content">
            <div class="field">
                <div class="label">Name:</div>
                <div class="value">{{ $name }}</div>
            </div>
            <div class="field">
                <div class="label">Email:</div>
                <div class="value"><a href="mailto:{{ $email }}">{{ $email }}</a></div>
            </div>
            @if($subject)
            <div class="field">
                <div class="label">Subject:</div>
                <div class="value">{{ $subject }}</div>
            </div>
            @endif
            <div class="field">
                <div class="label">Message:</div>
                <div class="value" style="white-space: pre-wrap;">{{ $messageContent }}</div>
            </div>
            <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 20px 0;">
            <p style="color: #666; font-size: 14px;">
                <strong>Reply to:</strong> <a href="mailto:{{ $email }}">{{ $email }}</a>
            </p>
        </div>
        <div class="footer">
            <p>This email was sent from your website contact form.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>