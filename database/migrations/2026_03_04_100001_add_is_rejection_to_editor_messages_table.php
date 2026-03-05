<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('editor_messages', function (Blueprint $table) {
            $table->boolean('is_rejection')->default(false)->after('is_approval_request');
        });
    }

    public function down(): void
    {
        Schema::table('editor_messages', function (Blueprint $table) {
            $table->dropColumn('is_rejection');
        });
    }
};
