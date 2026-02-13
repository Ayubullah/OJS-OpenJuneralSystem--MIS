<?php

namespace App\Mail;

use App\Models\Review;
use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewerReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $review;
    public $article;
    public $message;
    public $editorName;

    /**
     * Create a new message instance.
     */
    public function __construct(Review $review, Article $article, string $message = null, string $editorName = null)
    {
        $this->review = $review;
        $this->article = $article;
        $this->message = $message ?? $this->getDefaultMessage();
        $this->editorName = $editorName ?? 'Editor';
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Reminder: Review Request - ' . $this->article->title)
                    ->view('emails.reviewer-reminder')
                    ->with([
                        'review' => $this->review,
                        'article' => $this->article,
                        'message' => $this->message,
                        'editorName' => $this->editorName,
                    ]);
    }

    /**
     * Get default reminder message
     */
    private function getDefaultMessage(): string
    {
        return "This is a friendly reminder about your pending review assignment. Please complete your review at your earliest convenience.";
    }
}

