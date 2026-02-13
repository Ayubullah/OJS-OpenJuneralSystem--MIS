<?php

namespace App\Mail;

use App\Models\Article;
use App\Models\Author;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuthorReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $article;
    public $author;
    public $message;
    public $editorName;

    /**
     * Create a new message instance.
     */
    public function __construct(Article $article, Author $author, string $message = null, string $editorName = null)
    {
        $this->article = $article;
        $this->author = $author;
        $this->message = $message ?? $this->getDefaultMessage();
        $this->editorName = $editorName ?? 'Editor';
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Reminder: Article Submission - ' . $this->article->title)
                    ->view('emails.author-reminder')
                    ->with([
                        'article' => $this->article,
                        'author' => $this->author,
                        'message' => $this->message,
                        'editorName' => $this->editorName,
                    ]);
    }

    /**
     * Get default reminder message
     */
    private function getDefaultMessage(): string
    {
        return "This is a friendly reminder about your article submission. Please check the status and take any necessary actions.";
    }
}

