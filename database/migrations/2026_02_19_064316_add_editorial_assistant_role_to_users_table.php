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
        // Add 'editorial_assistant' to the role enum in users table
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'editor', 'reviewer', 'author', 'editorial_assistant') DEFAULT 'author'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'editorial_assistant' from the role enum
        // First, update any users with editorial_assistant role to author
        DB::table('users')->where('role', 'editorial_assistant')->update(['role' => 'author']);
        
        // Then remove the enum value
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'editor', 'reviewer', 'author') DEFAULT 'author'");
    }
};
