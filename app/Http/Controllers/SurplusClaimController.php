<?php

namespace App\Http\Controllers;

use App\Models\SurplusAllocation;
use App\Models\FoodListing;
use App\Models\Redemption;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurplusClaimController extends Controller
{
    /**
     * Claim a food item (VCFSE member claims a surplus or free item)
     */
    public function claim(Request $request, $foodListingId)
    {
        $user = Auth::user();

        // Verify user is VCFSE
        if ($user->role !== 'vcfse') {
            return redirect()->back()->with('error', 'Only VCFSE members can claim items');
        }

        // Get the food listing
        $foodListing = FoodListing::find($foodListingId);

        if (!$foodListing) {
            return redirect()->back()->with('error', 'Food item not found');
        }

        // Check if item has quantity available
        if ($foodListing->quantity <= 0) {
            return redirect()->back()->with('error', 'Item is no longer available');
        }

        // For surplus items, check allocation
        $allocation = null;
        if ($foodListing->listing_type === 'surplus') {
            $allocation = SurplusAllocation::where('food_listing_id', $foodListingId)
                ->where('vcfse_user_id', $user->id)
                ->where('status', 'pending')
                ->first();

            if (!$allocation) {
                return redirect()->back()->with('error', 'No allocation found for this item');
            }

            // Check if allocation has expired
            if ($allocation->isExpired()) {
                $allocation->update(['status' => 'expired']);
                return redirect()->back()->with('error', 'Allocation has expired');
            }

            // Update allocation status to claimed
            $allocation->update(['status' => 'claimed', 'claimed_at' => now()]);
        }

        // Create redemption record
        $redemption = Redemption::create([
            'food_listing_id' => $foodListingId,
            'recipient_user_id' => $user->id,
            'redeemed_at' => now(),
            'status' => 'confirmed',
        ]);

        // Update food listing quantity
        $foodListing->decrement('quantity');

        // If quantity reaches 0, mark as redeemed
        if ($foodListing->quantity <= 0) {
            if ($allocation) {
                $allocation->update(['status' => 'redeemed']);
            }
            $foodListing->update(['status' => 'collected']);
        }

        // Send notification
        $itemType = $foodListing->listing_type === 'surplus' ? 'Surplus Item' : 'Free Item';
        Notification::create([
            'user_id' => $user->id,
            'type' => 'item_redeemed',
            'title' => $itemType . ' Redeemed',
            'message' => 'You have successfully redeemed: ' . $foodListing->item_name,
            'icon' => 'fas fa-check-circle',
        ]);

        return redirect()->back()->with('success', 'Item claimed successfully! You can now collect it from the shop.');
    }
}
