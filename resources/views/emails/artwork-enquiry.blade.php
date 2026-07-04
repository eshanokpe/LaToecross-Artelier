<!DOCTYPE html>
<html>
<head>
    <title>New Artwork Enquiry</title>
    <style>
        body { font-family: Arial, sans-serif; background: #faf0f5; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { border-bottom: 3px solid #DB2077; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { color: #1a0a0f; font-family: Georgia, serif; }
        .enquiry-details { background: #faf0f5; padding: 20px; border-radius: 12px; margin: 20px 0; }
        .enquiry-details p { margin: 8px 0; }
        .label { font-weight: 600; color: #6b3b4f; }
        .artwork-info { background: #fce4ec; padding: 15px; border-radius: 12px; margin: 15px 0; border-left: 4px solid #DB2077; }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #fce4ec; color: #6b3b4f; font-size: 14px; }
        .btn { display: inline-block; padding: 12px 24px; background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div style="margin-bottom: 12px; text-align: center;">
                <img src="{{ asset('assets/img/logo.png') }}" alt="{{ config('app.name') }} Logo" style="max-height: 60px; width: auto; display: block; margin: 0 auto;">
            </div>
            <h1 style="margin: 0;">🖼️ New Artwork Enquiry</h1>
            <p style="color: #6b3b4f;">Someone is interested in an artwork from your collection.</p>
        </div>

        <div class="artwork-info">
            <h3 style="color: #1a0a0f; margin: 0;">Artwork Details</h3>
            <p><strong>Title:</strong> {{ $artwork->title }}</p>
            <p><strong>Category:</strong> {{ ucfirst(str_replace('_', ' ', $artwork->style)) }}</p>
            @if($artwork->price)
                <p><strong>Price:</strong> ₦{{ number_format($artwork->price, 2) }}</p>
            @endif
            <p><strong>ID:</strong> #{{ $artwork->id }}</p>
            <p><a href="{{ route('artwork.show', $artwork) }}" class="btn" style="display: inline-block; padding: 8px 16px; background: linear-gradient(135deg, #DB2077, #ff6b9d); color: white; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; margin-top: 10px;">View Artwork</a></p>
        </div>

        <div class="enquiry-details">
            <h3 style="color: #1a0a0f; margin: 0 0 15px 0;">Enquirer Information</h3>
            <p><span class="label">Name:</span> {{ $enquiry->name }}</p>
            <p><span class="label">Email:</span> <a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></p>
            @if($enquiry->phone)
                <p><span class="label">Phone:</span> <a href="tel:{{ $enquiry->phone }}">{{ $enquiry->phone }}</a></p>
            @endif
            <p><span class="label">Enquiry Date:</span> {{ $enquiry->created_at->format('F j, Y \a\t g:i A') }}</p>
        </div>

        <div style="background: white; padding: 15px; border-radius: 12px; border: 1px solid #fce4ec;">
            <h4 style="color: #1a0a0f; margin: 0 0 10px 0;">Message:</h4>
            <p style="white-space: pre-wrap; line-height: 1.6;">{{ $enquiry->message }}</p>
        </div>

        <div class="footer">
            <p>This enquiry was submitted through the Latocross Artelier website.</p>
            <p style="font-size: 12px; color: #999;">You can reply directly to this email to contact the enquirer.</p>
        </div>
    </div>
</body>
</html>