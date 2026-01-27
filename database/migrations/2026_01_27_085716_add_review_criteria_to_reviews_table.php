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
        Schema::table('reviews', function (Blueprint $table) {
            // General Comments - 6 Questions
            $table->text('originality_comment')->nullable()->after('comments');
            $table->text('relationship_to_literature_comment')->nullable()->after('originality_comment');
            $table->text('methodology_comment')->nullable()->after('relationship_to_literature_comment');
            $table->text('results_comment')->nullable()->after('methodology_comment');
            $table->text('implications_comment')->nullable()->after('results_comment');
            $table->text('quality_of_communication_comment')->nullable()->after('implications_comment');
            
            // Strengths and Weaknesses
            $table->text('strengths')->nullable()->after('quality_of_communication_comment');
            $table->text('weaknesses')->nullable()->after('strengths');
            
            // Suggestions for Improvement
            $table->text('suggestions_for_improvement')->nullable()->after('weaknesses');
            
            // Paper Score (Ten-point System)
            $table->decimal('relevance_score', 3, 1)->nullable()->after('suggestions_for_improvement')->comment('Score out of 5');
            $table->decimal('originality_score', 3, 1)->nullable()->after('relevance_score')->comment('Score out of 10');
            $table->decimal('significance_score', 3, 1)->nullable()->after('originality_score')->comment('Score out of 15');
            $table->decimal('technical_soundness_score', 3, 1)->nullable()->after('significance_score')->comment('Score out of 15');
            $table->decimal('clarity_score', 3, 1)->nullable()->after('technical_soundness_score')->comment('Score out of 10');
            $table->decimal('documentation_score', 3, 1)->nullable()->after('clarity_score')->comment('Score out of 5');
            $table->decimal('total_score', 4, 1)->nullable()->after('documentation_score')->comment('Total score out of 60');
            
            // Final Evaluation
            $table->enum('final_evaluation', ['excellent', 'very_good', 'fair', 'poor'])->nullable()->after('total_score');
            
            // Recommendation
            $table->enum('recommendation', ['acceptance', 'minor_revision', 'major_revision', 'rejection'])->nullable()->after('final_evaluation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn([
                'originality_comment',
                'relationship_to_literature_comment',
                'methodology_comment',
                'results_comment',
                'implications_comment',
                'quality_of_communication_comment',
                'strengths',
                'weaknesses',
                'suggestions_for_improvement',
                'relevance_score',
                'originality_score',
                'significance_score',
                'technical_soundness_score',
                'clarity_score',
                'documentation_score',
                'total_score',
                'final_evaluation',
                'recommendation'
            ]);
        });
    }
};
