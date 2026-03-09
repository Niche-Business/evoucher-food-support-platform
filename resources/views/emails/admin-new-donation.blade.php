<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>New Donation Received – Admin Alert</title>
  <style>
    body { margin:0; padding:0; background:#f0f4f8; font-family:'Segoe UI',Arial,sans-serif; }
    .wrapper { width:100%; background:#f0f4f8; padding:32px 0; }
    .container { max-width:600px; margin:0 auto; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
    .header { background:linear-gradient(135deg,#1e3a5f 0%,#2d6a4f 100%); padding:36px 40px 28px; text-align:center; }
    .header-logo { font-size:22px; font-weight:800; color:#ffffff; letter-spacing:-.5px; margin-bottom:4px; }
    .header-logo span { color:#4ade80; }
    .header-sub { font-size:13px; color:rgba(255,255,255,.7); }
    .body { padding:32px 40px; }
    .body h1 { font-size:20px; font-weight:700; color:#1e3a5f; margin:0 0 12px; }
    .body p { font-size:15px; color:#4a5568; line-height:1.7; margin:0 0 14px; }
    .info-box { background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:18px 20px; margin-bottom:24px; }
    .info-box p { font-size:13px; color:#64748b; margin:0 0 6px; }
    .info-box p:last-child { margin:0; }
    .info-box strong { color:#1e3a5f; }
    .amount-big { font-size:36px; font-weight:900; color:#166534; margin:0 0 4px; }
    .cta-wrap { text-align:center; margin-bottom:28px; }
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
  </style>
</head>
<body>
<div class="wrapper">
  <div class="container">
    <div class="header">
      <div class="header-logo">eVoucher <span>Food Support</span></div>
      <div class="header-sub">Admin Notification</div>
    </div>
    <div class="body">
      <h1>💰 New Donation Received</h1>
      <p>A new donation has just been processed on the eVoucher Food Support Platform.</p>
      <div class="info-box">
        <div class="amount-big">£{{ number_format($amount, 2) }}</div>
        <p><strong>From:</strong> {{ $donorEmail }}</p>
        <p><strong>Payment ID:</strong> {{ $paymentId }}</p>
        <p><strong>Date:</strong> {{ $donatedAt }}</p>
        <p><strong>Status:</strong> Completed</p>
      </div>
      <p>Log in to the admin dashboard to view the full donation details.</p>
    </div>
    <div class="cta-wrap">
      <a href="{{ $adminUrl }}" class="cta-btn">View in Admin Dashboard</a>
    </div>
    <div class="divider"></div>
    <div class="footer">
      <p>This is an automated admin notification from <strong>eVoucher Food Support Platform</strong></p>
    </div>
  </div>
</div>
</body>
</html>
