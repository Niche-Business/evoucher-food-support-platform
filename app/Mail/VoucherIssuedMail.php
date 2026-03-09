<?php

namespace App\Mail;

use App\Models\Setting;
use App\Models\Voucher;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VoucherIssuedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Voucher $voucher;
    public string  $recipientName;
    public string  $issuedByName;
    public string  $dashboardUrl;
    public string  $supportEmail;

    public function __construct(Voucher $voucher)
    {
        $this->voucher       = $voucher;
        $this->recipientName = $voucher->recipient->name ?? 'Valued Recipient';
        $this->issuedByName  = $voucher->issuedBy->name ?? 'eVoucher Admin';
        $this->dashboardUrl  = url('/recipient/vouchers');
        $this->supportEmail  = Setting::get('support_email', config('mail.from.address', 'support@evoucher.org'));
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Food Support Voucher – eVoucher Food Support',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.voucher-issued',
            with: [
                'voucher'       => $this->voucher,
                'recipientName' => $this->recipientName,
                'issuedByName'  => $this->issuedByName,
                'dashboardUrl'  => $this->dashboardUrl,
                'supportEmail'  => $this->supportEmail,
            ],
        );
    }
}
