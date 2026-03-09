<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Voucher Issued Confirmation – eVoucher Food Support</title>
  <style>
    body { margin:0; padding:0; background:#f0f4f8; font-family:'Segoe UI',Arial,sans-serif; }
    .wrapper { width:100%; background:#f0f4f8; padding:32px 0; }
    .container { max-width:600px; margin:0 auto; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }

    /* Header */
    .header { background:linear-gradient(135deg,#1e3a5f 0%,#2d6a4f 100%); padding:36px 40px 28px; text-align:center; }
    .header-logo { font-size:22px; font-weight:800; color:#ffffff; letter-spacing:-.5px; margin-bottom:4px; }
    .header-logo span { color:#4ade80; }
    .header-sub { font-size:13px; color:rgba(255,255,255,.7); }

    /* Hero */
    .hero { background:#f0fdf4; padding:28px 40px 20px; text-align:center; border-bottom:1px solid #bbf7d0; }
    .hero-icon { font-size:44px; margin-bottom:10px; }
    .hero h1 { font-size:22px; font-weight:800; color:#166534; margin:0 0 6px; }
    .hero p { font-size:14px; color:#15803d; margin:0; }

    /* Body */
    .body { padding:28px 40px; }
    .body p { font-size:15px; color:#4a5568; line-height:1.7; margin:0 0 14px; }

    /* Voucher card */
    .voucher-card {
      background:linear-gradient(135deg,#1e3a5f 0%,#2d6a4f 100%);
      border-radius:14px;
      padding:24px 28px;
      margin:20px 0 28px;
      position:relative;
      overflow:hidden;
    }
    .voucher-card::before {
      content:'';
      position:absolute;
      top:-30px; right:-30px;
      width:120px; height:120px;
      background:rgba(255,255,255,.06);
      border-radius:50%;
    }
    .voucher-card::after {
      content:'';
      position:absolute;
      bottom:-40px; left:-20px;
      width:160px; height:160px;
      background:rgba(255,255,255,.04);
      border-radius:50%;
    }
    .vc-label { font-size:11px; font-weight:700; color:rgba(255,255,255,.6); letter-spacing:.1em; text-transform:uppercase; margin-bottom:4px; }
    .vc-value { font-size:15px; font-weight:600; color:#ffffff; margin-bottom:14px; }
    .vc-code { font-size:26px; font-weight:900; color:#4ade80; letter-spacing:.15em; font-family:monospace; margin-bottom:6px; }
    .vc-amount { font-size:36px; font-weight:900; color:#ffffff; margin-bottom:4px; }
    .vc-amount span { font-size:18px; font-weight:500; color:rgba(255,255,255,.7); }
    .vc-row { display:flex; justify-content:space-between; margin-top:16px; padding-top:16px; border-top:1px solid rgba(255,255,255,.15); }
    .vc-row-item { text-align:center; }
    .vc-row-item .label { font-size:11px; color:rgba(255,255,255,.6); text-transform:uppercase; letter-spacing:.05em; }
    .vc-row-item .val { font-size:13px; font-weight:700; color:#ffffff; margin-top:2px; }

    /* CTA */
    .cta-wrap { text-align:center; margin:20px 0 28px; }
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

    /* Footer */
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
      <h1>Voucher Issued Successfully</h1>
      <p>The food support voucher has been sent to the recipient.</p>
    </div>

    <div class="body">
      <p>Hello <strong>{{ $issuerName }}</strong>,</p>
      <p>You have successfully issued a food support voucher to <strong>{{ $recipientName }}</strong>. A copy of the voucher has been emailed directly to the recipient.</p>

      <div class="voucher-card">
        <div class="vc-label">Voucher Code</div>
        <div class="vc-code">{{ $voucher->code }}</div>
        <div class="vc-amount">£{{ number_format($voucher->value, 2) }} <span>GBP</span></div>
        <div class="vc-row">
          <div class="vc-row-item">
            <div class="label">Recipient</div>
            <div class="val">{{ $recipientName }}</div>
          </div>
          <div class="vc-row-item">
            <div class="label">Issued By</div>
            <div class="val">{{ $issuerName }}</div>
          </div>
          <div class="vc-row-item">
            <div class="label">Expires</div>
            <div class="val">{{ \Carbon\Carbon::parse($voucher->expiry_date)->format('d M Y') }}</div>
          </div>
          <div class="vc-row-item">
            <div class="label">Status</div>
            <div class="val">Active</div>
          </div>
        </div>
      </div>

      <p>The recipient can use this voucher at any participating local food shop on the platform. You can view and manage all issued vouchers from your dashboard.</p>
    </div>

    <div class="cta-wrap">
      <a href="{{ $dashboardUrl }}" class="cta-btn">View Your Dashboard</a>
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
