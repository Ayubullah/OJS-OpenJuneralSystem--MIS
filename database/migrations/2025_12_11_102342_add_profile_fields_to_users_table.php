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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_image')->nullable()->after('email');
            $table->string('phone')->nullable()->after('profile_image');
            $table->text('bio')->nullable()->after('phone');
            $table->string('address')->nullable()->after('bio');
            $table->string('city')->nullable()->after('address');
            $table->string('country')->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['profile_image', 'phone', 'bio', 'address', 'city', 'country']);
        });
    }
};
