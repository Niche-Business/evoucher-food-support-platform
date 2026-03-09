<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Your Food Voucher – eVoucher Food Support</title>
  <style>
    /* Reset */
    body, table, td, a { -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; }
    table, td { mso-table-lspace:0pt; mso-table-rspace:0pt; }
    img { -ms-interpolation-mode:bicubic; border:0; outline:none; text-decoration:none; }
    body { margin:0; padding:0; background:#f0f4f8; font-family:'Segoe UI',Arial,sans-serif; }

    .wrapper { width:100%; background:#f0f4f8; padding:32px 0; }
    .container { max-width:600px; margin:0 auto; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }

    /* Header */
    .header { background:linear-gradient(135deg,#1e3a5f 0%,#2d6a4f 100%); padding:36px 40px 28px; text-align:center; }
    .header-logo { font-size:22px; font-weight:800; color:#ffffff; letter-spacing:-.5px; margin-bottom:4px; }
    .header-logo span { color:#4ade80; }
    .header-sub { font-size:13px; color:rgba(255,255,255,.7); }

    /* Greeting */
    .greeting { padding:32px 40px 0; }
    .greeting h1 { font-size:22px; font-weight:700; color:#1e3a5f; margin:0 0 8px; }
    .greeting p { font-size:15px; color:#4a5568; line-height:1.6; margin:0; }

    /* Voucher Card */
    .voucher-wrap { padding:28px 40px; }
    .voucher-card {
      background:linear-gradient(135deg,#1e3a5f 0%,#2d6a4f 100%);
      border-radius:16px;
      padding:32px 28px;
      position:relative;
      overflow:hidden;
      color:#fff;
    }
    .voucher-card::before {
      content:'';
      position:absolute;
      top:-40px; right:-40px;
      width:160px; height:160px;
      background:rgba(255,255,255,.06);
      border-radius:50%;
    }
    .voucher-card::after {
      content:'';
      position:absolute;
      bottom:-60px; left:-30px;
      width:200px; height:200px;
      background:rgba(255,255,255,.04);
      border-radius:50%;
    }
    .voucher-platform { font-size:11px; font-weight:700; letter-spacing:.12em; text-transform:uppercase; opacity:.7; margin-bottom:8px; }
    .voucher-title { font-size:14px; font-weight:600; opacity:.85; margin-bottom:4px; }
    .voucher-amount { font-size:52px; font-weight:900; line-height:1; margin-bottom:6px; }
    .voucher-amount-sub { font-size:13px; opacity:.7; margin-bottom:20px; }
    .voucher-code-label { font-size:11px; font-weight:700; letter-spacing:.1em; text-transform:uppercase; opacity:.6; margin-bottom:6px; }
    .voucher-code {
      display:inline-block;
      background:rgba(255,255,255,.15);
      border:1px solid rgba(255,255,255,.25);
      border-radius:10px;
      padding:10px 20px;
      font-size:20px;
      font-weight:800;
      letter-spacing:.15em;
      font-family:'Courier New',monospace;
      margin-bottom:20px;
    }
    .voucher-meta { display:flex; gap:24px; flex-wrap:wrap; }
    .voucher-meta-item { font-size:12px; opacity:.8; }
    .voucher-meta-item strong { display:block; font-size:13px; font-weight:700; opacity:1; }

    /* Info Section */
    .info { padding:0 40px 28px; }
    .info p { font-size:14px; color:#4a5568; line-height:1.7; margin:0 0 12px; }
    .info ul { margin:0 0 12px; padding-left:20px; }
    .info ul li { font-size:14px; color:#4a5568; line-height:1.7; margin-bottom:4px; }

    /* CTA Button */
    .cta-wrap { padding:0 40px 32px; text-align:center; }
    .cta-btn {
      display:inline-block;
      background:linear-gradient(135deg,#1e3a5f,#2d6a4f);
      color:#ffffff !important;
      text-decoration:none;
      font-size:15px;
      font-weight:700;
      padding:14px 36px;
      border-radius:10px;
      letter-spacing:.02em;
    }

    /* Divider */
    .divider { height:1px; background:#e2e8f0; margin:0 40px; }

    /* Footer */
    .footer { padding:24px 40px; text-align:center; }
    .footer p { font-size:12px; color:#94a3b8; line-height:1.6; margin:0 0 4px; }
    .footer a { color:#2d6a4f; text-decoration:none; }

    /* Notice box */
    .notice {
      margin:0 40px 28px;
      background:#f0fdf4;
      border:1px solid #bbf7d0;
      border-radius:10px;
      padding:14px 18px;
      font-size:13px;
      color:#166534;
      line-height:1.6;
    }
    .notice strong { font-weight:700; }
  </style>
</head>
<body>
<div class="wrapper">
  <div class="container">

    <!-- Header -->
    <div class="header">
      <div class="header-logo">eVoucher <span>Food Support</span></div>
      <div class="header-sub">Northamptonshire Community Food Programme</div>
    </div>

    <!-- Greeting -->
    <div class="greeting">
      <h1>You've received a food voucher! 🎉</h1>
      <p>Hello <strong>{{ $recipientName }}</strong>, a food support voucher has been issued to you. You can use it to purchase food items from participating local shops.</p>
    </div>

    <!-- Voucher Card -->
    <div class="voucher-wrap">
      <div class="voucher-card">
        <div class="voucher-platform">eVoucher Food Support</div>
        <div class="voucher-title">Food Support Voucher</div>
        <div class="voucher-amount">£{{ number_format($voucher->value, 2) }}</div>
        <div class="voucher-amount-sub">Voucher Value</div>
        <div class="voucher-code-label">Voucher Code</div>
        <div class="voucher-code">{{ $voucher->code }}</div>
        <div class="voucher-meta">
          <div class="voucher-meta-item">
            <strong>Expires</strong>
            {{ $voucher->expiry_date->format('d M Y') }}
          </div>
          <div class="voucher-meta-item">
            <strong>Issued By</strong>
            {{ $issuedByName }}
          </div>
          <div class="voucher-meta-item">
            <strong>Status</strong>
            Active
          </div>
        </div>
      </div>
    </div>

    @if($voucher->notes)
    <div class="notice">
      <strong>Note from issuer:</strong> {{ $voucher->notes }}
    </div>
    @endif

    <!-- Info -->
    <div class="info">
      <p>Here's how to use your voucher:</p>
      <ul>
        <li>Log in to your eVoucher dashboard using the button below.</li>
        <li>Browse available food items from local shops in your area.</li>
        <li>Add items to your cart and redeem using your voucher code at checkout.</li>
        <li>Your voucher balance will be deducted automatically.</li>
      </ul>
      <p>Your voucher is valid until <strong>{{ $voucher->expiry_date->format('d F Y') }}</strong>. Please use it before it expires.</p>
    </div>

    <!-- CTA -->
    <div class="cta-wrap">
      <a href="{{ $dashboardUrl }}" class="cta-btn">View My Voucher &amp; Browse Food</a>
    </div>

    <div class="divider"></div>

    <!-- Footer -->
    <div class="footer">
      <p>This email was sent by <strong>eVoucher Food Support Platform</strong></p>
      <p>Northamptonshire Community Food Programme</p>
      <p style="margin-top:8px;">
        If you have any questions, contact us at
        <a href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>
      </p>
      <p style="margin-top:12px;font-size:11px;color:#cbd5e1;">
        Please do not reply directly to this email. This is an automated notification.
      </p>
    </div>

  </div>
</div>
</body>
</html>
