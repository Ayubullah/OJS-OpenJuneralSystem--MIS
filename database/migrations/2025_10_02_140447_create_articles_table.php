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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title', 300);
            $table->foreignId('journal_id')->constrained()->onDelete('cascade');
            $table->foreignId('author_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('manuscript_type', 100)->default('Research Article')->comment('Type of manuscript');
            $table->text('abstract')->nullable()->comment('Full abstract text');
            $table->integer('word_count')->nullable()->comment('Total word count of the manuscript');
            $table->integer('number_of_tables')->default(0)->comment('Number of tables in the manuscript');
            $table->integer('number_of_figures')->default(0)->comment('Number of figures in the manuscript');
            $table->enum('previously_submitted', ['Yes', 'No'])->default('No')->comment('Whether paper was previously submitted elsewhere');
            $table->enum('funded_by_outside_source', ['Yes', 'No'])->default('No')->comment('Whether research was funded by external sources');
            $table->enum('confirm_not_published_elsewhere', ['Yes', 'No'])->default('Yes')->comment('Author confirms paper not published elsewhere');
            $table->enum('confirm_prepared_as_per_guidelines', ['Yes', 'No'])->default('Yes')->comment('Author confirms paper follows journal guidelines');
            $table->enum('status', ['submitted', 'under_review', 'revision_required', 'accepted', 'published', 'rejected'])->default('submitted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
