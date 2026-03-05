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
        // Add chief_editor_review and approved_chief_editor status to submissions
        DB::statement("ALTER TABLE submissions MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'disc_review', 'pending_verify', 'verified', 'plagiarism', 'accepted', 'chief_editor_review', 'approved_chief_editor', 'published', 'rejected') DEFAULT 'submitted'");

        if (Schema::hasTable('articles')) {
            DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'disc_review', 'pending_verify', 'verified', 'plagiarism', 'accepted', 'chief_editor_review', 'approved_chief_editor', 'published', 'rejected') DEFAULT 'submitted'");
        }

        // Add chief_editor_comment to submissions (visible to Editor only)
        Schema::table('submissions', function (Blueprint $table) {
            $table->text('chief_editor_comment')->nullable()->after('approval_message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn('chief_editor_comment');
        });

        DB::statement("ALTER TABLE submissions MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'disc_review', 'pending_verify', 'verified', 'plagiarism', 'accepted', 'published', 'rejected') DEFAULT 'submitted'");

        if (Schema::hasTable('articles')) {
            DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('submitted', 'under_review', 'revision_required', 'disc_review', 'pending_verify', 'verified', 'plagiarism', 'accepted', 'published', 'rejected') DEFAULT 'submitted'");
        }
    }
};
