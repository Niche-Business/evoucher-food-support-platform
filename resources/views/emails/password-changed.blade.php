<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Password Changed – eVoucher Food Support</title>
  <style>
    body { margin:0; padding:0; background:#f0f4f8; font-family:'Segoe UI',Arial,sans-serif; }
    .wrapper { width:100%; background:#f0f4f8; padding:32px 0; }
    .container { max-width:600px; margin:0 auto; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
    .header { background:linear-gradient(135deg,#1e3a5f 0%,#2d6a4f 100%); padding:36px 40px 28px; text-align:center; }
    .header-logo { font-size:22px; font-weight:800; color:#ffffff; letter-spacing:-.5px; margin-bottom:4px; }
    .header-logo span { color:#4ade80; }
    .header-sub { font-size:13px; color:rgba(255,255,255,.7); }
    .body { padding:36px 40px; }
    .body h1 { font-size:22px; font-weight:700; color:#1e3a5f; margin:0 0 12px; }
    .body p { font-size:15px; color:#4a5568; line-height:1.7; margin:0 0 14px; }
    .alert {
      background:#fef2f2;
      border:1px solid #fecaca;
      border-radius:10px;
      padding:16px 20px;
      font-size:14px;
      color:#991b1b;
      line-height:1.6;
      margin-bottom:24px;
    }
    .alert strong { font-weight:700; }
    .meta { background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:16px 20px; margin-bottom:24px; }
    .meta p { font-size:13px; color:#64748b; margin:0 0 4px; }
    .meta p:last-child { margin:0; }
    .meta strong { color:#1e3a5f; }
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
    <div class="body">
      <h1>🔐 Password Changed</h1>
      <p>Hello <strong>{{ $userName }}</strong>,</p>
      <p>Your password for your eVoucher Food Support account has been successfully changed.</p>
      <div class="meta">
        <p><strong>Account:</strong> {{ $userEmail }}</p>
        <p><strong>Changed at:</strong> {{ $changedAt }}</p>
      </div>
      <div class="alert">
        <strong>⚠️ Didn't make this change?</strong> If you did not change your password, please contact our support team immediately at <a href="mailto:{{ $supportEmail }}" style="color:#991b1b;">{{ $supportEmail }}</a> and reset your password right away.
      </div>
      <p>If you made this change, no further action is required.</p>
    </div>
    <div class="cta-wrap">
      <a href="{{ $loginUrl }}" class="cta-btn">Go to Login</a>
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
