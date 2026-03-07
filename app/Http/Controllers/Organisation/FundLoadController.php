<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use App\Models\BankDeposit;
use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class FundLoadController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function showLoadForm()
    {
        $user = Auth::user();
        $profile = $user->organisationProfile;
        $walletBalance = $profile ? (float)$profile->wallet_balance : 0.0;
        
        // Check if organisation has verified bank deposits
        $bankDeposits = BankDeposit::where('organisation_user_id', $user->id)
            ->where('status', 'verified')
            ->latest()
            ->get();

        return view('organisation.fund-load', compact('walletBalance', 'bankDeposits'));
    }

    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:10000',
        ]);

        $user = Auth::user();
        $amountInCents = (int)($request->amount * 100);

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amountInCents,
                'currency' => 'gbp',
                'metadata' => [
                    'user_id' => $user->id,
                    'organisation_name' => $user->name,
                    'role' => $user->role,
                ],
            ]);

            SystemLog::log('fund_load_initiated', 'fund_load', null, "Fund load of £{$request->amount} initiated by {$user->name}");

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
                'amount' => $request->amount,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function confirmPayment(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();

        try {
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);

            if ($paymentIntent->status === 'succeeded') {
                // Update wallet balance
                $profile = $user->organisationProfile;
                if ($profile) {
                    $profile->increment('wallet_balance', $request->amount);
                }

                SystemLog::log('fund_load_completed', 'fund_load', null, "Fund load of £{$request->amount} completed by {$user->name}");

                return response()->json([
                    'success' => true,
                    'message' => 'Funds loaded successfully!',
                    'amount' => $request->amount,
                ]);
            }

            return response()->json(['error' => 'Payment failed'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function loadHistory()
    {
        $user = Auth::user();
        // In a real app, you'd have a FundLoad model to track transactions
        // For now, we'll show recent system logs
        $logs = SystemLog::where('user_id', $user->id)
            ->where('action', 'fund_load_completed')
            ->latest()
            ->paginate(15);

        return view('organisation.fund-load-history', compact('logs'));
    }
}
