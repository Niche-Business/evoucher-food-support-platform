<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Donation extends Model {
    protected $fillable = ['amount', 'email', 'payment_intent_id', 'payment_method_id', 'status', 'metadata', 'donor_user_id', 'donor_name', 'donor_email', 'org_name', 'currency', 'stripe_payment_id', 'stripe_session_id', 'vouchers_allocated', 'notes'];
    protected $casts = ['amount' => 'decimal:2', 'vouchers_allocated' => 'decimal:2'];
    public function donor() { return $this->belongsTo(User::class, 'donor_user_id'); }
}
