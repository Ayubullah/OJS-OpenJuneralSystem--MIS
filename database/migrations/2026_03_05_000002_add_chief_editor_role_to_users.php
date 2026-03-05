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
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'editor', 'reviewer', 'author', 'editorial_assistant', 'chief_editor') DEFAULT 'author'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->where('role', 'chief_editor')->update(['role' => 'author']);
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'editor', 'reviewer', 'author', 'editorial_assistant') DEFAULT 'author'");
    }
};
