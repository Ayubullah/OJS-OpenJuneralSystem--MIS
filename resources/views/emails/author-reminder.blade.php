<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Reminder</title>
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
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #1e40af;
            margin: 0;
            font-size: 24px;
        }
        .content {
            margin-bottom: 30px;
        }
        .article-info {
            background-color: #f8f9fa;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .article-info h3 {
            margin: 0 0 10px 0;
            color: #1e40af;
        }
        .article-info p {
            margin: 5px 0;
            color: #666;
        }
        .message-box {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
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
            background-color: #3b82f6;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Article Submission Reminder</h1>
        </div>

        <div class="content">
            <p>Dear {{ $author->name }},</p>

            <p>This is a reminder from {{ $editorName }} regarding your article submission.</p>

            <div class="article-info">
                <h3>{{ $article->title }}</h3>
                <p><strong>Journal:</strong> {{ $article->journal->name ?? 'N/A' }}</p>
                <p><strong>Category:</strong> {{ $article->category->name ?? 'N/A' }}</p>
                <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $article->status)) }}</p>
                <p><strong>Submitted:</strong> {{ $article->created_at->format('F d, Y') }}</p>
            </div>

            @if($message)
            <div class="message-box">
                <p><strong>Message from Editor:</strong></p>
                <p>{{ $message }}</p>
            </div>
            @endif

            <p>Please log in to your account to check the current status of your article and take any necessary actions.</p>

            <p>If you have any questions or concerns, please don't hesitate to contact us.</p>

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

