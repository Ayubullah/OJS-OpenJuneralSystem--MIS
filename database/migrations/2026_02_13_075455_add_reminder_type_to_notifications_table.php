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
        // Modify the enum to include 'reminder'
        DB::statement("ALTER TABLE notifications MODIFY COLUMN type ENUM('submission', 'review', 'acceptance', 'publication', 'revision', 'registration', 'reminder') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to enum values without 'reminder'
        DB::statement("ALTER TABLE notifications MODIFY COLUMN type ENUM('submission', 'review', 'acceptance', 'publication', 'revision', 'registration') NOT NULL");
    }
};
