<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 8px 8px;
            border: 1px solid #ddd;
        }
        .field {
            margin-bottom: 20px;
        }
        .field label {
            font-weight: bold;
            color: #f43f5e;
            display: block;
            margin-bottom: 5px;
        }
        .field-value {
            background: white;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .message-box {
            background: white;
            padding: 15px;
            border-radius: 4px;
            border: 1px solid #ddd;
            white-space: pre-wrap;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            background: #f1f1f1;
            border-radius: 4px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Contact Form Submission</h1>
        <p>EShop Admin - Contact Form</p>
    </div>
    
    <div class="content">
        <div class="field">
            <label>Name:</label>
            <div class="field-value">{{ $contact->name }}</div>
        </div>
        
        <div class="field">
            <label>Email:</label>
            <div class="field-value">{{ $contact->email }}</div>
        </div>
        
        <div class="field">
            <label>Message:</label>
            <div class="message-box">{{ $contact->message }}</div>
        </div>
        
        <div class="field">
            <label>Submitted:</label>
            <div class="field-value">{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
    </div>
    
    <div class="footer">
        <p>This email was sent from your EShop contact form.</p>
        <p>Please reply directly to {{ $contact->email }} to respond to this inquiry.</p>
    </div>
</body>
</html>
