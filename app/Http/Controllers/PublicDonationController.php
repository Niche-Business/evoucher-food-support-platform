<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;
use App\Models\Donation;
use App\Models\Notification;
use App\Models\User;
use App\Services\NotificationService;

class PublicDonationController extends Controller
{
    private $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    /**
     * Create a payment intent for donation
     */
    public function createPaymentIntent(Request $request)
    {
        try {
            $validated = $request->validate([
                'amount' => 'required|numeric|min:1',
                'email' => 'required|email'
            ]);

            $amountInCents = intval($validated['amount'] * 100);

            $paymentIntent = $this->stripe->paymentIntents->create([
                'amount' => $amountInCents,
                'currency' => 'gbp',
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never'
                ],
                'metadata' => [
                    'email' => $validated['email'],
                    'type' => 'donation'
                ]
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
                'amount' => $validated['amount']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Confirm and store donation
     */
    public function confirm(Request $request)
    {
        try {
            $validated = $request->validate([
                'amount' => 'required|numeric|min:1',
                'email' => 'required|email',
                'payment_intent_id' => 'required|string'
            ]);

            // Retrieve the payment intent from Stripe
            $paymentIntent = $this->stripe->paymentIntents->retrieve($validated['payment_intent_id']);

            // Log the payment intent for debugging
            \Log::info('Payment Intent Retrieved', [
                'id' => $paymentIntent->id,
                'status' => $paymentIntent->status,
                'payment_method' => $paymentIntent->payment_method,
                'charges' => $paymentIntent->charges
            ]);

            // Check if payment succeeded or is processing
            // For card payments, the status might be requires_payment_method if confirmCardPayment wasn't successful
            if ($paymentIntent->status === 'succeeded' || $paymentIntent->status === 'processing') {
                // Save donation to database
                $donation = Donation::create([
                    'amount' => $validated['amount'],
                    'email' => $validated['email'],
                    'donor_email' => $validated['email'],
                    'stripe_payment_id' => $paymentIntent->id,
                    'payment_intent_id' => $validated['payment_intent_id'],
                    'status' => $paymentIntent->status === 'succeeded' ? 'completed' : 'processing',
                    'currency' => 'GBP',
                    'notes' => json_encode([
                        'email' => $validated['email'],
                        'type' => 'donation',
                        'stripe_status' => $paymentIntent->status,
                        'payment_method' => $paymentIntent->payment_method
                    ])
                ]);

                // Create notification for admin
                $admin = User::where('role', 'admin')->first();
                if ($admin) {
                    Notification::create([
                        'user_id' => $admin->id,
                        'title' => 'New Donation Received',
                        'message' => "Donation of £{$validated['amount']} from {$validated['email']}",
                        'type' => 'donation',
                        'icon' => 'gift',
                        'link' => '/admin/donations',
                    ]);
                }

                // Notify admins about new donation
                try {
                    NotificationService::notifyNewDonation($validated['amount'], $validated['email']);
                } catch (\Exception $notifyError) {
                    // Log but don't fail the donation
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for your donation of GBP' . $validated['amount'] . '!',
                    'amount' => $validated['amount'],
                    'email' => $validated['email'],
                    'donation_id' => $donation->id,
                    'status' => $paymentIntent->status
                ]);
            } else if ($paymentIntent->status === 'requires_payment_method') {
                // This happens when confirmCardPayment doesn't properly attach the payment method
                // Try to retrieve charges from the payment intent
                if ($paymentIntent->charges && count($paymentIntent->charges->data) > 0) {
                    $charge = $paymentIntent->charges->data[0];
                    if ($charge->status === 'succeeded') {
                        // Charge succeeded, save donation
                        $donation = Donation::create([
                            'amount' => $validated['amount'],
                            'email' => $validated['email'],
                            'donor_email' => $validated['email'],
                            'stripe_payment_id' => $paymentIntent->id,
                            'payment_intent_id' => $validated['payment_intent_id'],
                            'status' => 'completed',
                            'currency' => 'GBP',
                            'notes' => json_encode([
                                'email' => $validated['email'],
                                'type' => 'donation',
                                'stripe_status' => $paymentIntent->status,
                                'charge_id' => $charge->id
                            ])
                        ]);

                        // Create notification for admin
                        $admin = User::where('role', 'admin')->first();
                        if ($admin) {
                            Notification::create([
                                'user_id' => $admin->id,
                                'title' => 'New Donation Received',
                                'message' => "Donation of £{$validated['amount']} from {$validated['email']}",
                                'type' => 'donation',
                                'icon' => 'gift',
                                'link' => '/admin/donations',
                            ]);
                        }

                        return response()->json([
                            'success' => true,
                            'message' => 'Thank you for your donation of GBP' . $validated['amount'] . '!',
                            'amount' => $validated['amount'],
                            'email' => $validated['email'],
                            'donation_id' => $donation->id,
                            'status' => 'completed'
                        ]);
                    }
                }
                
                return response()->json([
                    'success' => false,
                    'message' => 'Payment method not attached. Please try again.'
                ], 400);
            } else {
                // Save failed donation
                $errorMessage = 'Payment not succeeded';
                if ($paymentIntent->last_payment_error) {
                    $errorMessage = $paymentIntent->last_payment_error->message;
                }

                Donation::create([
                    'amount' => $validated['amount'],
                    'email' => $validated['email'],
                    'donor_email' => $validated['email'],
                    'stripe_payment_id' => $paymentIntent->id,
                    'payment_intent_id' => $validated['payment_intent_id'],
                    'status' => 'failed',
                    'currency' => 'GBP',
                    'notes' => json_encode([
                        'stripe_status' => $paymentIntent->status,
                        'error' => $errorMessage
                    ])
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Payment processing failed. Status: ' . $paymentIntent->status
                ], 400);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', array_merge(...array_values($e->errors())))
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 400);
        }
    }
}
