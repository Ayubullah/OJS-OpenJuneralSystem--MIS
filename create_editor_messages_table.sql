-- Create editor_messages table
CREATE TABLE IF NOT EXISTS `editor_messages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `submission_id` bigint(20) UNSIGNED DEFAULT NULL,
  `editor_id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `recipient_type` enum('author','reviewer','both') NOT NULL DEFAULT 'both',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `editor_messages_article_id_foreign` (`article_id`),
  KEY `editor_messages_submission_id_foreign` (`submission_id`),
  KEY `editor_messages_editor_id_foreign` (`editor_id`),
  KEY `editor_messages_author_id_foreign` (`author_id`),
  KEY `editor_messages_reviewer_id_foreign` (`reviewer_id`),
  CONSTRAINT `editor_messages_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `editor_messages_submission_id_foreign` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `editor_messages_editor_id_foreign` FOREIGN KEY (`editor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `editor_messages_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `editor_messages_reviewer_id_foreign` FOREIGN KEY (`reviewer_id`) REFERENCES `reviewers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

