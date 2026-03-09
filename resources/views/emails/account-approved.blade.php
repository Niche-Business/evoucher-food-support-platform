<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Account Approved – eVoucher Food Support</title>
  <style>
    body { margin:0; padding:0; background:#f0f4f8; font-family:'Segoe UI',Arial,sans-serif; }
    .wrapper { width:100%; background:#f0f4f8; padding:32px 0; }
    .container { max-width:600px; margin:0 auto; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
    .header { background:linear-gradient(135deg,#1e3a5f 0%,#2d6a4f 100%); padding:36px 40px 28px; text-align:center; }
    .header-logo { font-size:22px; font-weight:800; color:#ffffff; letter-spacing:-.5px; margin-bottom:4px; }
    .header-logo span { color:#4ade80; }
    .header-sub { font-size:13px; color:rgba(255,255,255,.7); }
    .hero { background:#f0fdf4; padding:32px 40px; text-align:center; border-bottom:1px solid #bbf7d0; }
    .hero-icon { font-size:48px; margin-bottom:12px; }
    .hero h1 { font-size:24px; font-weight:800; color:#166534; margin:0 0 8px; }
    .hero p { font-size:15px; color:#15803d; margin:0; }
    .body { padding:32px 40px; }
    .body p { font-size:15px; color:#4a5568; line-height:1.7; margin:0 0 14px; }
    .cta-wrap { text-align:center; margin:28px 0; }
    .cta-btn {
      display:inline-block;
      background:linear-gradient(135deg,#1e3a5f,#2d6a4f);
      color:#ffffff !important;
      text-decoration:none;
      font-size:15px;
      font-weight:700;
      padding:14px 36px;
      border-radius:10px;
    }
    .divider { height:1px; background:#e2e8f0; margin:0 40px; }
    .footer { padding:24px 40px; text-align:center; }
    .footer p { font-size:12px; color:#94a3b8; line-height:1.6; margin:0 0 4px; }
    .footer a { color:#2d6a4f; text-decoration:none; }
  </style>
</head>
<body>
<div class="wrapper">
  <div class="container">
    <div class="header">
      <div class="header-logo">eVoucher <span>Food Support</span></div>
      <div class="header-sub">Northamptonshire Community Food Programme</div>
    </div>
    <div class="hero">
      <div class="hero-icon">✅</div>
      <h1>Your Account is Approved!</h1>
      <p>You can now log in and access your dashboard.</p>
    </div>
    <div class="body">
      <p>Hello <strong>{{ $userName }}</strong>,</p>
      <p>Great news! Your <strong>{{ $roleLabel }}</strong> account on the eVoucher Food Support Platform has been reviewed and <strong>approved</strong> by our admin team.</p>
      <p>You can now log in using your registered email address and password to access your dashboard.</p>
      <div class="cta-wrap">
        <a href="{{ $loginUrl }}" class="cta-btn">Log In to Your Dashboard</a>
      </div>
      <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
    </div>
    <div class="divider"></div>
    <div class="footer">
      <p>This email was sent by <strong>eVoucher Food Support Platform</strong></p>
      <p>Questions? <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a></p>
    </div>
  </div>
</div>
</body>
</html>
