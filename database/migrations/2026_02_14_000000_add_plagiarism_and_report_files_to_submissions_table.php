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
            $table->decimal('plagiarism_percentage', 5, 2)->nullable()->after('approval_status')->comment('Plagiarism percentage detected by editor');
            $table->string('ai_report_file')->nullable()->after('plagiarism_percentage')->comment('Path to AI plagiarism report file');
            $table->string('other_resources_report_file')->nullable()->after('ai_report_file')->comment('Path to other resources plagiarism report file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn(['plagiarism_percentage', 'ai_report_file', 'other_resources_report_file']);
        });
    }
};


