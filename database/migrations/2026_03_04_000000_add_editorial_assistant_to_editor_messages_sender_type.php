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
        DB::statement("ALTER TABLE editor_messages MODIFY COLUMN sender_type ENUM('admin', 'editor', 'editorial_assistant') NOT NULL DEFAULT 'editor'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE editor_messages MODIFY COLUMN sender_type ENUM('admin', 'editor') NOT NULL DEFAULT 'editor'");
    }
};
