-- =====================================================
-- DATABASE REPORTS - IMPORTANT INFORMATION QUERIES
-- =====================================================

-- 1. ARTICLES OVERVIEW WITH ALL DETAILS
SELECT 
    a.id,
    a.title,
    au.name AS author_name,
    au.email AS author_email,
    au.affiliation,
    j.name AS journal_name,
    c.name AS category_name,
    a.manuscript_type,
    a.word_count,
    a.number_of_tables,
    a.number_of_figures,
    a.status,
    a.created_at
FROM articles a
JOIN authors au ON a.author_id = au.id
JOIN journals j ON a.journal_id = j.id
JOIN categories c ON a.category_id = c.id
ORDER BY a.created_at DESC;

-- =====================================================
-- 2. ARTICLES BY STATUS
-- =====================================================
SELECT 
    status,
    COUNT(*) as total_articles,
    AVG(word_count) as avg_word_count,
    SUM(number_of_tables) as total_tables,
    SUM(number_of_figures) as total_figures
FROM articles
GROUP BY status
ORDER BY total_articles DESC;

-- =====================================================
-- 3. TOP AUTHORS BY NUMBER OF PUBLICATIONS
-- =====================================================
SELECT 
    au.name,
    au.email,
    au.affiliation,
    au.specialization,
    au.orcid_id,
    COUNT(a.id) as total_publications,
    GROUP_CONCAT(a.status) as article_statuses
FROM authors au
LEFT JOIN articles a ON au.id = a.author_id
GROUP BY au.id
ORDER BY total_publications DESC;

-- =====================================================
-- 4. JOURNAL PERFORMANCE REPORT
-- =====================================================
SELECT 
    j.name as journal_name,
    j.issn,
    COUNT(a.id) as total_articles,
    COUNT(CASE WHEN a.status = 'published' THEN 1 END) as published_count,
    COUNT(CASE WHEN a.status = 'under_review' THEN 1 END) as under_review_count,
    COUNT(CASE WHEN a.status = 'accepted' THEN 1 END) as accepted_count,
    COUNT(CASE WHEN a.status = 'rejected' THEN 1 END) as rejected_count,
    AVG(a.word_count) as avg_word_count
FROM journals j
LEFT JOIN articles a ON j.id = a.journal_id
GROUP BY j.id
ORDER BY total_articles DESC;

-- =====================================================
-- 5. CATEGORY-WISE ARTICLE DISTRIBUTION
-- =====================================================
SELECT 
    c.name as category_name,
    COUNT(a.id) as total_articles,
    COUNT(CASE WHEN a.status = 'published' THEN 1 END) as published,
    COUNT(CASE WHEN a.status = 'submitted' THEN 1 END) as submitted,
    AVG(a.word_count) as avg_word_count
FROM categories c
LEFT JOIN articles a ON c.id = a.category_id
GROUP BY c.id
ORDER BY total_articles DESC;

-- =====================================================
-- 6. MANUSCRIPT TYPE ANALYSIS
-- =====================================================
SELECT 
    manuscript_type,
    COUNT(*) as total_count,
    AVG(word_count) as avg_word_count,
    AVG(number_of_tables) as avg_tables,
    AVG(number_of_figures) as avg_figures,
    COUNT(CASE WHEN funded_by_outside_source = 'Yes' THEN 1 END) as funded_count
FROM articles
GROUP BY manuscript_type;

-- =====================================================
-- 7. FUNDING ANALYSIS
-- =====================================================
SELECT 
    funded_by_outside_source,
    COUNT(*) as total_articles,
    COUNT(CASE WHEN status = 'published' THEN 1 END) as published_count,
    AVG(word_count) as avg_word_count
FROM articles
GROUP BY funded_by_outside_source;

-- =====================================================
-- 8. ARTICLES WITH PREVIOUS SUBMISSIONS
-- =====================================================
SELECT 
    a.title,
    au.name as author_name,
    j.name as journal_name,
    a.previously_submitted,
    a.status,
    a.created_at
FROM articles a
JOIN authors au ON a.author_id = au.id
JOIN journals j ON a.journal_id = j.id
WHERE a.previously_submitted = 'Yes'
ORDER BY a.created_at DESC;

-- =====================================================
-- 9. DETAILED ARTICLE INFORMATION WITH AUTHOR CONTRIBUTIONS
-- =====================================================
SELECT 
    a.id,
    a.title,
    au.name as author_name,
    au.orcid_id,
    au.author_contributions,
    a.abstract,
    a.manuscript_type,
    a.word_count,
    a.status,
    j.name as journal_name
FROM articles a
JOIN authors au ON a.author_id = au.id
JOIN journals j ON a.journal_id = j.id
ORDER BY a.id;

-- =====================================================
-- 10. SUBMISSION COMPLIANCE REPORT
-- =====================================================
SELECT 
    a.title,
    au.name as author_name,
    a.confirm_not_published_elsewhere,
    a.confirm_prepared_as_per_guidelines,
    a.status
FROM articles a
JOIN authors au ON a.author_id = au.id
WHERE a.confirm_not_published_elsewhere = 'No' 
   OR a.confirm_prepared_as_per_guidelines = 'No';

-- =====================================================
-- 11. AVERAGE METRICS BY JOURNAL
-- =====================================================
SELECT 
    j.name as journal_name,
    AVG(a.word_count) as avg_word_count,
    AVG(a.number_of_tables) as avg_tables,
    AVG(a.number_of_figures) as avg_figures,
    COUNT(a.id) as total_submissions
FROM journals j
LEFT JOIN articles a ON j.id = a.journal_id
GROUP BY j.id
ORDER BY total_submissions DESC;

-- =====================================================
-- 12. AUTHORS WITH COMPLETE ORCID INFORMATION
-- =====================================================
SELECT 
    name,
    email,
    affiliation,
    specialization,
    orcid_id,
    author_contributions
FROM authors
WHERE orcid_id IS NOT NULL
ORDER BY name;

-- =====================================================
-- 13. MONTHLY SUBMISSION TREND
-- =====================================================
SELECT 
    DATE_FORMAT(created_at, '%Y-%m') as month,
    COUNT(*) as total_submissions,
    COUNT(CASE WHEN status = 'published' THEN 1 END) as published,
    COUNT(CASE WHEN status = 'under_review' THEN 1 END) as under_review
FROM articles
GROUP BY DATE_FORMAT(created_at, '%Y-%m')
ORDER BY month DESC;

-- =====================================================
-- 14. RESEARCH QUALITY METRICS (Top 10 by Quality Score)
-- =====================================================
SELECT 
    a.title,
    au.name as author_name,
    a.word_count,
    a.number_of_tables,
    a.number_of_figures,
    (a.word_count + (a.number_of_tables * 500) + (a.number_of_figures * 500)) as quality_score,
    a.status
FROM articles a
JOIN authors au ON a.author_id = au.id
ORDER BY quality_score DESC
LIMIT 10;

-- =====================================================
-- 15. COMPREHENSIVE DASHBOARD QUERY
-- =====================================================
SELECT 
    (SELECT COUNT(*) FROM articles) as total_articles,
    (SELECT COUNT(*) FROM articles WHERE status = 'published') as published_articles,
    (SELECT COUNT(*) FROM articles WHERE status = 'under_review') as under_review,
    (SELECT COUNT(*) FROM articles WHERE status = 'submitted') as submitted,
    (SELECT COUNT(*) FROM authors) as total_authors,
    (SELECT COUNT(*) FROM journals) as total_journals,
    (SELECT AVG(word_count) FROM articles) as avg_word_count,
    (SELECT COUNT(*) FROM articles WHERE funded_by_outside_source = 'Yes') as funded_research;

-- =====================================================
-- 16. AUTHOR PRODUCTIVITY REPORT
-- =====================================================
SELECT 
    au.name,
    au.affiliation,
    COUNT(a.id) as total_articles,
    SUM(a.word_count) as total_words_written,
    AVG(a.word_count) as avg_article_length,
    COUNT(CASE WHEN a.status = 'published' THEN 1 END) as published_count
FROM authors au
LEFT JOIN articles a ON au.id = a.author_id
GROUP BY au.id
HAVING total_articles > 0
ORDER BY total_articles DESC;

-- =====================================================
-- 17. ARTICLES NEEDING REVISION
-- =====================================================
SELECT 
    a.id,
    a.title,
    au.name as author_name,
    au.email,
    j.name as journal_name,
    a.status,
    a.created_at,
    DATEDIFF(NOW(), a.created_at) as days_since_submission
FROM articles a
JOIN authors au ON a.author_id = au.id
JOIN journals j ON a.journal_id = j.id
WHERE a.status IN ('revision_required', 'under_review')
ORDER BY a.created_at ASC;

-- =====================================================
-- 18. WORD COUNT DISTRIBUTION
-- =====================================================
SELECT 
    CASE 
        WHEN word_count < 3000 THEN 'Short (< 3000)'
        WHEN word_count BETWEEN 3000 AND 5999 THEN 'Medium (3000-5999)'
        WHEN word_count BETWEEN 6000 AND 7999 THEN 'Long (6000-7999)'
        ELSE 'Very Long (8000+)'
    END as length_category,
    COUNT(*) as article_count,
    AVG(word_count) as avg_words
FROM articles
GROUP BY length_category
ORDER BY avg_words;

-- =====================================================
-- 19. JOURNAL ARTICLE STATUS BREAKDOWN
-- =====================================================
SELECT 
    j.name as journal_name,
    a.status,
    COUNT(*) as count,
    AVG(a.word_count) as avg_word_count
FROM journals j
LEFT JOIN articles a ON j.id = a.journal_id
GROUP BY j.id, a.status
ORDER BY j.name, a.status;

-- =====================================================
-- 20. EXPORT READY - ALL ARTICLES WITH COMPLETE INFO
-- =====================================================
SELECT 
    a.id as 'Article ID',
    a.title as 'Title',
    au.name as 'Author Name',
    au.email as 'Author Email',
    au.orcid_id as 'ORCID',
    au.affiliation as 'Affiliation',
    j.name as 'Journal',
    c.name as 'Category',
    a.manuscript_type as 'Type',
    a.abstract as 'Abstract',
    a.word_count as 'Words',
    a.number_of_tables as 'Tables',
    a.number_of_figures as 'Figures',
    a.previously_submitted as 'Previously Submitted',
    a.funded_by_outside_source as 'Funded',
    a.status as 'Status',
    DATE_FORMAT(a.created_at, '%Y-%m-%d') as 'Submission Date'
FROM articles a
JOIN authors au ON a.author_id = au.id
JOIN journals j ON a.journal_id = j.id
JOIN categories c ON a.category_id = c.id
ORDER BY a.created_at DESC;

