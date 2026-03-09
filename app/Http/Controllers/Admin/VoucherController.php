<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\VoucherIssuedConfirmationMail;
use App\Mail\VoucherIssuedMail;
use App\Models\User;
use App\Models\Voucher;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $query = Voucher::with(['recipient', 'issuedBy']);
        if ($request->status) $query->where('status', $request->status);
        if ($request->search) $query->where('code', 'like', '%' . $request->search . '%');
        $vouchers = $query->latest()->paginate(20);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        $recipients = User::where('role', 'recipient')->where('is_approved', true)->orderBy('name')->get();
        return view('admin.vouchers.create', compact('recipients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_user_id' => 'required|exists:users,id',
            'value'             => 'required|numeric|min:0.01|max:500',
            'expiry_date'       => 'nullable|date|after:today',
            'notes'             => 'nullable|string|max:500',
        ]);

        $voucher = Voucher::create([
            'code'              => Voucher::generateCode(),
            'recipient_user_id' => $request->recipient_user_id,
            'issued_by'         => Auth::id(),
            'value'             => $request->value,
            'remaining_value'   => $request->value,
            'status'            => 'active',
            'expiry_date'       => $request->expiry_date ?? now()->addDays(30)->format('Y-m-d'),
            'notes'             => $request->notes,
        ]);

        // In-app notification
        try {
            NotificationService::notifyRecipientNewVoucher($voucher);
        } catch (\Exception $e) {
            \Log::warning('Voucher in-app notification failed: ' . $e->getMessage());
        }

        // Email notification to recipient
        try {
            $recipient = $voucher->recipient;
            if ($recipient && $recipient->email) {
                Mail::to($recipient->email)->send(new VoucherIssuedMail($voucher));
            }
        } catch (\Exception $e) {
            \Log::warning('Voucher email failed: ' . $e->getMessage());
        }

        // Confirmation email to the admin who issued the voucher
        try {
            $admin = Auth::user();
            if ($admin && $admin->email) {
                Mail::to($admin->email)->send(new VoucherIssuedConfirmationMail($voucher));
            }
        } catch (\Exception $e) {
            \Log::warning('Admin voucher confirmation email failed: ' . $e->getMessage());
        }

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher issued successfully. The recipient has been notified and a confirmation has been sent to your email.');
    }

    public function show(Voucher $voucher)
    {
        $voucher->load(['recipient', 'issuedBy', 'redemptions.foodListing']);
        return view('admin.vouchers.show', compact('voucher'));
    }

    public function cancel(Voucher $voucher)
    {
        $voucher->update(['status' => 'cancelled']);
        return back()->with('success', 'Voucher cancelled.');
    }
}
