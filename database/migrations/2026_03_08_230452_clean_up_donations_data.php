<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Delete all incomplete donations (missing email or amount)
        DB::table('donations')
            ->whereNull('donor_email')
            ->orWhereNull('email')
            ->orWhereNull('amount')
            ->orWhere('amount', 0)
            ->delete();

        // Keep only donations from shadrackadupoku@gmail.com
        DB::table('donations')
            ->where('donor_email', '!=', 'shadrackadupoku@gmail.com')
            ->where('email', '!=', 'shadrackadupoku@gmail.com')
            ->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot reverse this destructive operation
    }
};
