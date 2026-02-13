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
        Schema::table('submissions', function (Blueprint $table) {
            $table->string('approval_pending_file')->nullable()->after('file_path')->comment('Path to the file uploaded by author for approval');
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->nullable()->after('approval_pending_file')->comment('Status of the approval workflow');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn(['approval_pending_file', 'approval_status']);
        });
    }
};
