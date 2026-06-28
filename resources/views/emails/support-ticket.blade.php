<!DOCTYPE html>
<html>
<head>
    <title>New Support Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #faf0f5;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .header {
            border-bottom: 3px solid #DB2077;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #1a0a0f;
            font-family: Georgia, serif;
            margin: 0;
        }
        .ticket-details {
            background: #faf0f5;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
        }
        .ticket-details p {
            margin: 8px 0;
        }
        .label {
            font-weight: 600;
            color: #6b3b4f;
        }
        .message-box {
            background: white;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid #fce4ec;
            margin: 15px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #fce4ec;
            color: #6b3b4f;
            font-size: 14px;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            background: linear-gradient(135deg, #DB2077, #ff6b9d);
            color: white;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎫 New Support Ticket</h1>
            <p style="color: #6b3b4f;">A new support ticket has been submitted.</p>
        </div>

        <div class="ticket-details">
            <h3 style="color: #1a0a0f; margin: 0 0 15px 0;">Ticket Information</h3>
            <p><span class="label">Subject:</span> {{ $data['subject'] }}</p>
            <p><span class="label">Status:</span> <span class="badge">Pending</span></p>
            <p><span class="label">Submitted:</span> {{ now()->format('F j, Y \a\t g:i A') }}</p>
        </div>

        <div class="ticket-details">
            <h3 style="color: #1a0a0f; margin: 0 0 15px 0;">Customer Information</h3>
            <p><span class="label">Name:</span> {{ $data['name'] }}</p>
            <p><span class="label">Email:</span> <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></p>
            @if(isset($data['phone']) && $data['phone'])
                <p><span class="label">Phone:</span> <a href="tel:{{ $data['phone'] }}">{{ $data['phone'] }}</a></p>
            @endif
        </div>

        <div class="message-box">
            <h4 style="color: #1a0a0f; margin: 0 0 10px 0;">Message:</h4>
            <p style="white-space: pre-wrap; line-height: 1.6;">{{ $data['message'] }}</p>
        </div>

        <div class="footer">
            <p>Reply to this email to respond to the customer.</p>
            <p style="font-size: 12px; color: #999;">
                This ticket was submitted through the Latocross Artelier Support Center.
            </p>
        </div>
    </div>
</body>
</html>