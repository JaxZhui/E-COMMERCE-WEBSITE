Hello {{ $contact->name }},

Thank you for contacting us. We have reviewed your message and here's our response:

Subject: {{ $reply->subject }}

{{ $reply->message }}

---

Your Original Message:
Sent: {{ $contact->created_at->format('F j, Y \a\t g:i A') }}

{{ $contact->message }}

---

Best regards,
{{ $reply->user->name ?? 'Support Team' }}

{{ config('app.name', 'Eshop') }}
This email was sent in response to your inquiry.
If you have any further questions, please don't hesitate to contact us.
