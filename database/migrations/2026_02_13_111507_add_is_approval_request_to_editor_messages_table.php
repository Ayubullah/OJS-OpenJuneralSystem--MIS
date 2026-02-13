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
        Schema::table('editor_messages', function (Blueprint $table) {
            $table->boolean('is_approval_request')->default(false)->after('recipient_type')->comment('Indicates if this message is an approval request');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('editor_messages', function (Blueprint $table) {
            $table->dropColumn('is_approval_request');
        });
    }
};
