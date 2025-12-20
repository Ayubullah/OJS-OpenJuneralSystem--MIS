<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reviewer;
use App\Models\Article;
use App\Models\Submission;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $reviewer = Reviewer::first();
        $articles = Article::take(3)->get();

        if ($reviewer && $articles->count() > 0) {
            foreach ($articles as $article) {
                // Create submission if it doesn't exist
                $submission = $article->submissions()->first();
                if (!$submission) {
                    $submission = Submission::create([
                        'article_id' => $article->id,
                        'author_id' => $article->author_id,
                        'submission_date' => now()->subDays(rand(1, 30)),
                        'status' => 'under_review',
                        'version_number' => 1,
                        'file_path' => 'sample.pdf'
                    ]);
                }

                // Create review
                Review::create([
                    'submission_id' => $submission->id,
                    'reviewer_id' => $reviewer->id,
                    'rating' => rand(3, 5),
                    'comments' => 'This is a test review comment for demonstration purposes.',
                    'review_date' => now()->subDays(rand(1, 10))
                ]);
            }

            echo "Test reviews created successfully!\n";
        } else {
            echo "No reviewer or articles found to create test data.\n";
        }
    }
}

