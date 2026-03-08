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
        DB::statement("ALTER TABLE editor_messages MODIFY COLUMN recipient_type ENUM('author', 'reviewer', 'editor', 'admin', 'both') NOT NULL DEFAULT 'author'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE editor_messages MODIFY COLUMN recipient_type ENUM('author', 'reviewer', 'editor', 'both') NOT NULL DEFAULT 'both'");
    }
};
