<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Reminder</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            border-bottom: 3px solid #10b981;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #059669;
            margin: 0;
            font-size: 24px;
        }
        .content {
            margin-bottom: 30px;
        }
        .article-info {
            background-color: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .article-info h3 {
            margin: 0 0 10px 0;
            color: #059669;
        }
        .article-info p {
            margin: 5px 0;
            color: #666;
        }
        .message-box {
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #10b981;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #059669;
        }
        .urgent {
            background-color: #fef3c7;
            border-left-color: #f59e0b;
        }
        .urgent h3 {
            color: #d97706;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Review Assignment Reminder</h1>
        </div>

        <div class="content">
            <p>Dear {{ $review->reviewer->user->name ?? 'Reviewer' }},</p>

            <p>This is a reminder from {{ $editorName }} regarding your pending review assignment.</p>

            <div class="article-info {{ $review->review_date && now()->greaterThan($review->review_date) ? 'urgent' : '' }}">
                <h3>{{ $article->title }}</h3>
                <p><strong>Journal:</strong> {{ $article->journal->name ?? 'N/A' }}</p>
                <p><strong>Category:</strong> {{ $article->category->name ?? 'N/A' }}</p>
                <p><strong>Author:</strong> {{ $article->author->name ?? 'N/A' }}</p>
                @if($review->review_date)
                <p><strong>Review Deadline:</strong> {{ \Carbon\Carbon::parse($review->review_date)->format('F d, Y') }}</p>
                @endif
                <p><strong>Assigned:</strong> {{ $review->created_at->format('F d, Y') }}</p>
                @if($review->review_date && now()->greaterThan($review->review_date))
                <p style="color: #d97706; font-weight: bold;">⚠️ This review is overdue</p>
                @endif
            </div>

            @if($message)
            <div class="message-box">
                <p><strong>Message from Editor:</strong></p>
                <p>{{ $message }}</p>
            </div>
            @endif

            <p>Please complete your review at your earliest convenience. Your feedback is valuable and helps maintain the quality of our publications.</p>

            @if(!$review->rating)
            <p><strong>Status:</strong> Review not yet submitted</p>
            @else
            <p><strong>Status:</strong> Review submitted (Rating: {{ $review->rating }}/10)</p>
            @endif

            <p>If you have any questions or need assistance, please don't hesitate to contact us.</p>

            <p>Best regards,<br>
            {{ $editorName }}<br>
            Editorial Team</p>
        </div>

        <div class="footer">
            <p>This is an automated reminder email. Please do not reply to this message.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

