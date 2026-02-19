<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('editorial_assistants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('journal_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            // Allow one user to be editorial assistant for multiple journals
            // If journal_id is null, it means they have access to all journals
            // Note: MySQL allows multiple NULLs in unique constraint, but we'll handle this in application logic
            $table->unique(['user_id', 'journal_id']);
            
            // Add index for faster queries
            $table->index('user_id');
            $table->index('journal_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editorial_assistants');
    }
};
