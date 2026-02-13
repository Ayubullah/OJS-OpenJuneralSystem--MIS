<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: First add new enum values alongside old ones for approval_status
        DB::statement("ALTER TABLE submissions MODIFY COLUMN approval_status ENUM('pending', 'approved', 'verified', 'rejected')");
        
        // Step 2: Update data: change 'approved' to 'verified' 
        DB::table('submissions')->where('approval_status', 'approved')->update(['approval_status' => 'verified']);
        
        // Step 3: Now remove 'approved' from enum
        DB::statement("ALTER TABLE submissions MODIFY COLUMN approval_status ENUM('pending', 'verified', 'rejected')");
        
        // Step 4: Add new enum values for status (include both old and new)
        DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'pending_approve', 'pending_verify', 'approved', 'verified', 'accepted', 'published', 'rejected') DEFAULT 'submitted'");
        DB::statement("ALTER TABLE submissions MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'pending_approve', 'pending_verify', 'approved', 'verified', 'accepted', 'published', 'rejected') DEFAULT 'submitted'");
        
        // Step 5: Update data: change 'pending_approve' to 'pending_verify'
        DB::table('articles')->where('status', 'pending_approve')->update(['status' => 'pending_verify']);
        DB::table('submissions')->where('status', 'pending_approve')->update(['status' => 'pending_verify']);
        
        // Step 6: Update data: change 'approved' to 'verified'
        DB::table('articles')->where('status', 'approved')->update(['status' => 'verified']);
        DB::table('submissions')->where('status', 'approved')->update(['status' => 'verified']);
        
        // Step 7: Remove old enum values
        DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'pending_verify', 'verified', 'accepted', 'published', 'rejected') DEFAULT 'submitted'");
        DB::statement("ALTER TABLE submissions MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'pending_verify', 'verified', 'accepted', 'published', 'rejected') DEFAULT 'submitted'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert approval_status first
        DB::table('submissions')->where('approval_status', 'verified')->update(['approval_status' => 'approved']);
        DB::statement("ALTER TABLE submissions MODIFY COLUMN approval_status ENUM('pending', 'approved', 'rejected')");
        
        // Revert status changes
        DB::table('articles')->where('status', 'pending_verify')->update(['status' => 'pending_approve']);
        DB::table('articles')->where('status', 'verified')->update(['status' => 'approved']);
        
        DB::table('submissions')->where('status', 'pending_verify')->update(['status' => 'pending_approve']);
        DB::table('submissions')->where('status', 'verified')->update(['status' => 'approved']);
        
        // Revert enum definitions
        DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'pending_approve', 'approved', 'accepted', 'published', 'rejected') DEFAULT 'submitted'");
        DB::statement("ALTER TABLE submissions MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'pending_approve', 'approved', 'accepted', 'published', 'rejected') DEFAULT 'submitted'");
    }
};
