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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('email', 100)->unique();
            $table->string('affiliation', 200)->nullable();
            $table->string('specialization', 100)->nullable();
            $table->string('orcid_id', 50)->nullable()->comment('Author\'s ORCID identifier');
            $table->text('author_contributions')->nullable()->comment('Describes author\'s specific contributions to the research');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
