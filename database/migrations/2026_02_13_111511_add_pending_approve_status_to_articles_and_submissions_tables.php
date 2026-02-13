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
        // Add 'pending_approve' status to articles table enum
        DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'pending_approve', 'accepted', 'published', 'rejected') DEFAULT 'submitted'");
        
        // Add 'pending_approve' status to submissions table enum
        DB::statement("ALTER TABLE submissions MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'pending_approve', 'accepted', 'published', 'rejected') DEFAULT 'submitted'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'pending_approve' status from articles table enum
        DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'accepted', 'published', 'rejected') DEFAULT 'submitted'");
        
        // Remove 'pending_approve' status from submissions table enum
        DB::statement("ALTER TABLE submissions MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'accepted', 'published', 'rejected') DEFAULT 'submitted'");
    }
};
