<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Donation Receipt – eVoucher Food Support</title>
  <style>
    body { margin:0; padding:0; background:#f0f4f8; font-family:'Segoe UI',Arial,sans-serif; }
    .wrapper { width:100%; background:#f0f4f8; padding:32px 0; }
    .container { max-width:600px; margin:0 auto; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
    .header { background:linear-gradient(135deg,#1e3a5f 0%,#2d6a4f 100%); padding:36px 40px 28px; text-align:center; }
    .header-logo { font-size:22px; font-weight:800; color:#ffffff; letter-spacing:-.5px; margin-bottom:4px; }
    .header-logo span { color:#4ade80; }
    .header-sub { font-size:13px; color:rgba(255,255,255,.7); }
    .hero { padding:32px 40px 0; text-align:center; }
    .hero-icon { font-size:48px; margin-bottom:8px; }
    .hero h1 { font-size:22px; font-weight:700; color:#1e3a5f; margin:0 0 6px; }
    .hero p { font-size:15px; color:#4a5568; margin:0; }
    .receipt { margin:28px 40px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; overflow:hidden; }
    .receipt-header { background:#1e3a5f; padding:14px 20px; }
    .receipt-header p { font-size:13px; font-weight:700; color:#fff; margin:0; letter-spacing:.05em; text-transform:uppercase; }
    .receipt-row { display:flex; justify-content:space-between; padding:12px 20px; border-bottom:1px solid #e2e8f0; }
    .receipt-row:last-child { border-bottom:none; }
    .receipt-row .label { font-size:13px; color:#64748b; }
    .receipt-row .value { font-size:13px; font-weight:600; color:#1e3a5f; }
    .receipt-total { background:#f0fdf4; padding:14px 20px; display:flex; justify-content:space-between; border-top:2px solid #bbf7d0; }
    .receipt-total .label { font-size:15px; font-weight:700; color:#166534; }
    .receipt-total .value { font-size:20px; font-weight:900; color:#166534; }
    .body { padding:0 40px 28px; }
    .body p { font-size:15px; color:#4a5568; line-height:1.7; margin:0 0 14px; }
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
      <div class="hero-icon">💚</div>
      <h1>Thank You for Your Donation!</h1>
      <p>Your generosity helps feed families across Northamptonshire.</p>
    </div>
    <div class="receipt">
      <div class="receipt-header"><p>Donation Receipt</p></div>
      <div class="receipt-row">
        <span class="label">Donor Email</span>
        <span class="value">{{ $donorEmail }}</span>
      </div>
      <div class="receipt-row">
        <span class="label">Payment Reference</span>
        <span class="value">{{ $paymentId }}</span>
      </div>
      <div class="receipt-row">
        <span class="label">Date</span>
        <span class="value">{{ $donatedAt }}</span>
      </div>
      <div class="receipt-row">
        <span class="label">Currency</span>
        <span class="value">{{ $currency }}</span>
      </div>
      <div class="receipt-total">
        <span class="label">Amount Donated</span>
        <span class="value">£{{ number_format($amount, 2) }}</span>
      </div>
    </div>
    <div class="body">
      <p>Your donation has been successfully processed. This email serves as your official receipt.</p>
      <p>Your contribution will be used to fund food vouchers for individuals and families in need across Northamptonshire. Thank you for making a difference!</p>
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
