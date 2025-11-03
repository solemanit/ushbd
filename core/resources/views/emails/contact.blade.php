<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>New Contact Message</title>
  <style>
    body {
      font-family: 'Poppins', Arial, sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding: 0;
    }

    .email-wrapper {
      max-width: 640px;
      margin: 30px auto;
      background: #ffffff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.08);
    }

    .header {
      background: #0075ff;
      color: #fff;
      text-align: center;
      padding: 20px;
      font-size: 20px;
      font-weight: 600;
    }

    .content {
      padding: 30px;
      color: #333;
      font-size: 15px;
      line-height: 1.6;
    }

    .content h2 {
      margin-top: 0;
      font-size: 18px;
      font-weight: 600;
      color: #0075ff;
    }

    .info-box {
      background: #f9f9f9;
      border: 1px solid #eee;
      border-radius: 6px;
      padding: 15px;
      margin: 15px 0;
    }

    .info-box p {
      margin: 6px 0;
      font-size: 15px;
    }

    .footer {
      background: #fafafa;
      text-align: center;
      font-size: 13px;
      color: #777;
      padding: 15px;
    }
  </style>
</head>

<body>
  <div class="email-wrapper">
    <!-- Header -->
    <div class="header">
      📩 New Contact Message
    </div>

    <!-- Content -->
    <div class="content">
      <h2>Contact Form Submission</h2>

      <div class="info-box">
        <p><strong>First Name:</strong> {{ $firstName }}</p>
        <p><strong>Last Name:</strong> {{ $lastName }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        @if(!empty($phone))
        <p><strong>Phone:</strong> {{ $phone }}</p>
        @endif
        <p><strong>Subject:</strong> {{ $subject }}</p>
      </div>

      <div>
        <p><strong>Message:</strong></p>
        <p>{{ $body }}</p>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      This email was sent from your website contact form. <br>
      &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
  </div>
</body>

</html>
