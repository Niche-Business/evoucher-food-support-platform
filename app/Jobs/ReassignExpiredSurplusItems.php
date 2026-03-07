<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\SurplusAllocation;
use App\Models\Notification;

class ReassignExpiredSurplusItems implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Find all expired allocations
        $expiredAllocations = SurplusAllocation::where('status', 'pending')
            ->where('expires_at', '<=', now())
            ->get();

        foreach ($expiredAllocations as $allocation) {
            // Mark as expired
            $allocation->update(['status' => 'expired']);

            // Get next VCFSE user
            $nextUser = SurplusAllocation::getNextVcfseUser($allocation->food_listing_id);

            if ($nextUser) {
                // Create new allocation for next user
                $newAllocation = SurplusAllocation::create([
                    'food_listing_id' => $allocation->food_listing_id,
                    'vcfse_user_id' => $nextUser->id,
                    'allocated_at' => now(),
                    'expires_at' => now()->addHours(2),
                    'status' => 'pending',
                    'allocation_sequence' => $allocation->allocation_sequence + 1,
                ]);

                // Send notification to new user
                Notification::create([
                    'user_id' => $nextUser->id,
                    'type' => 'surplus_allocated',
                    'title' => 'Surplus Food Available',
                    'message' => 'A surplus item has been allocated to you for 2 hours',
                    'icon' => 'fas fa-hourglass-end',
                    'read_at' => null,
                ]);
            }
        }
    }
}
