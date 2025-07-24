<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $reply->subject }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
            position: relative;
            overflow: hidden;
        }
        body::before,
        body::after {
            content: '';
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: #fb7185;
            border-radius: 50%;
            animation: float 6s infinite;
        }
        body::before {
            top: 20%;
            left: 10%;
            background-color: #f43f5e;
        }
        body::after {
            bottom: 30%;
            right: 15%;
            background-color: #e11d48;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background-color: #fb7185;
            border-radius: 2px;
        }
        .particle:nth-child(1) {
            top: 15%;
            left: 25%;
            background-color: #f43f5e;
            animation: float 4s infinite;
        }
        .particle:nth-child(2) {
            top: 45%;
            right: 20%;
            background-color: #e11d48;
            animation: float 5s infinite;
        }
        .particle:nth-child(3) {
            bottom: 25%;
            left: 30%;
            background-color: #fb7185;
            animation: float 7s infinite;
        }
        .container {
            background-color: #ffffff;
            padding: 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
            position: relative;
            z-index: 1;
        }
        .header {
            background-color: #fb7185;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 500;
        }
        .content {
            padding: 30px 20px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #374151;
        }
        .reply-content {
            background-color: #f9fafb;
            padding: 20px;
            border-left: 4px solid #fb7185;
            margin: 20px 0;
            border-radius: 4px;
        }
        .original-message {
            background-color: #f3f4f6;
            padding: 20px;
            border-radius: 4px;
            margin-top: 30px;
            border-left: 4px solid #9ca3af;
        }
        .original-message h4 {
            margin-top: 0;
            color: #6b7280;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            color: #6b7280;
        }
        .footer p {
            margin: 5px 0;
        }
        .meta-info {
            font-size: 12px;
            color: #9ca3af;
            margin-bottom: 15px;
        }
        .signature {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #374151;
        }
    </style>
</head>
<body>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="container">
        <div class="header">
            <h1>Reply to Your Message</h1>
        </div>

        <div class="content">
            <div class="greeting">
                Hello {{ $contact->name }},
            </div>

            <p>Thank you for contacting us. We have reviewed your message and here's our response:</p>

            <div class="reply-content">
                <h3 style="margin-top: 0; color: #fb7185;">{{ $reply->subject }}</h3>
                <div style="white-space: pre-line; line-height: 1.6;">{{ $reply->message }}</div>
            </div>

            <div class="original-message">
                <h4>Your Original Message</h4>
                <div class="meta-info">
                    <strong>Sent:</strong> {{ $contact->created_at->format('F j, Y \a\t g:i A') }}
                </div>
                <div style="white-space: pre-line; font-style: italic; color: #6b7280;">{{ $contact->message }}</div>
            </div>

            <div class="signature">
                <p><strong>Best regards,</strong><br>
                {{ $reply->user->name ?? 'Support Team' }}</p>
            </div>
        </div>

        <div class="footer">
            <p><strong>{{ config('Eshop Team') }}</strong></p>
            <p>This email was sent in response to your inquiry.</p>
            <p>If you have any further questions, please don't hesitate to contact us.</p>
        </div>
    </div>
</body>
</html>
