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
        Schema::table('editor_messages', function (Blueprint $table) {
            $table->enum('sender_type', ['admin', 'editor'])->default('editor')->after('editor_id');
            $table->foreignId('editor_recipient_id')->nullable()->after('reviewer_id')->constrained('users')->onDelete('cascade');
        });

        // Update recipient_type enum to include 'editor'
        DB::statement("ALTER TABLE editor_messages MODIFY COLUMN recipient_type ENUM('author', 'reviewer', 'editor', 'both') NOT NULL DEFAULT 'both'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('editor_messages', function (Blueprint $table) {
            $table->dropForeign(['editor_recipient_id']);
            $table->dropColumn(['sender_type', 'editor_recipient_id']);
        });

        // Revert recipient_type enum
        DB::statement("ALTER TABLE editor_messages MODIFY COLUMN recipient_type ENUM('author', 'reviewer', 'both') NOT NULL DEFAULT 'both'");
    }
};
