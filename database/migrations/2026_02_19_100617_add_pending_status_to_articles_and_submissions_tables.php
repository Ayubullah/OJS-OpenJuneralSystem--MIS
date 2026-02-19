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
        // Add 'pending' status to submissions table enum
        DB::statement("ALTER TABLE submissions MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'disc_review', 'pending', 'pending_verify', 'verified', 'plagiarism', 'accepted', 'published', 'rejected') DEFAULT 'submitted'");
        
        // Also add to articles table if it exists
        if (Schema::hasTable('articles')) {
            DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'disc_review', 'pending', 'pending_verify', 'verified', 'plagiarism', 'accepted', 'published', 'rejected') DEFAULT 'submitted'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'pending' status from submissions table enum
        DB::statement("ALTER TABLE submissions MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'disc_review', 'pending_verify', 'verified', 'plagiarism', 'accepted', 'published', 'rejected') DEFAULT 'submitted'");
        
        // Also remove from articles table if it exists
        if (Schema::hasTable('articles')) {
            DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'disc_review', 'pending_verify', 'verified', 'plagiarism', 'accepted', 'published', 'rejected') DEFAULT 'submitted'");
        }
    }
};
