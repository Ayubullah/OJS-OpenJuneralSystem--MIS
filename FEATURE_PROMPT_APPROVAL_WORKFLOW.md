# Feature Prompt: Article Approval Workflow with File Upload

## Overview
Implement an approval workflow system that allows editors to request article approval from authors, enables authors to upload revised files, and allows editors to approve articles after review.

## Feature Requirements

### 1. Editor Message Enhancement - "Send for Approval" Option

**Location:** Editor submission detail page (`resources/views/editor/submissions/show.blade.php`)

**Changes Required:**
- Add a checkbox or toggle option in the message sending modal/form labeled **"Send for Approval"** or **"Request Article Approval"**
- When this option is checked/selected:
  - The message form should indicate that selecting this option will change the article status to "pending_approve"
  - Add visual indicator (info badge) explaining the workflow

**Backend Changes:**
- Modify `Editor_SubmissionController::sendMessage()` method (`app/Http/Controllers/Editor/Editor_SubmissionController.php`)
- Add new request parameter: `send_for_approval` (boolean)
- When `send_for_approval` is true:
  - Update the article status to `'pending_approve'` (add this new status to articles table enum)
  - Update the submission status to `'pending_approve'` (add this new status to submissions table enum)
  - Store a flag in `editor_messages` table indicating this is an approval request (add `is_approval_request` boolean column)
  - Create notification for author indicating approval request

### 2. Database Schema Updates

**Migration Required:**
- Add `'pending_approve'` status to `articles` table enum: `['submitted', 'under_review', 'revision_required', 'pending_approve', 'accepted', 'published', 'rejected']`
- Add `'pending_approve'` status to `submissions` table enum: `['submitted', 'under_review', 'revision_required', 'pending_approve', 'accepted', 'published', 'rejected']`
- Add `is_approval_request` boolean column to `editor_messages` table (default: false)
- Add `approval_pending_file` string column to `submissions` table (nullable) to store the path of the file uploaded by author for approval
- Add `approval_status` enum column to `submissions` table: `['pending', 'approved', 'rejected']` (nullable) to track approval status

### 3. Author View - Display Approval Request Messages

**Location:** Author article detail page (`resources/views/author/articles/show.blade.php`)

**Changes Required:**
- Display approval request messages prominently with special styling/badge
- Show "Pending Approval" status badge when article status is `pending_approve`
- Display the approval request message from editor clearly

### 4. Author File Upload for Approval

**Location:** Author article detail page (`resources/views/author/articles/show.blade.php`)

**Changes Required:**
- When article status is `'pending_approve'`, display a **"Upload Revised File for Approval"** section
- Add file upload form with:
  - File input field (accept PDF, DOC, DOCX)
  - Optional message/notes field for the editor
  - Submit button labeled "Submit for Approval"
- This should be visible only when:
  - Article status is `'pending_approve'`
  - There is an approval request message from editor
  - The file hasn't been approved yet (`approval_status` is not `'approved'`)

**Backend Changes:**
- Create new method `Author_ArticleSubmissionController::uploadApprovalFile()` or add to existing controller
- Handle file upload and store in `approval_pending_file` column of `submissions` table
- Set `approval_status` to `'pending'` in submissions table
- Create notification for editor that author has uploaded a file for approval
- Store the file in `storage/app/public/approval_files/` directory

### 5. Editor View - Pending Approval Files

**Location:** Editor submission detail page (`resources/views/editor/submissions/show.blade.php`)

**Changes Required:**
- Display a new section **"Pending Approval Files"** when `approval_status` is `'pending'`
- Show:
  - File name and upload date
  - Download link for the uploaded file
  - Author's message/notes (if provided)
  - Action buttons: **"Approve"** and **"Reject"** (or "Request Changes")

### 6. Editor Approval Action

**Backend Changes:**
- Create new method `Editor_SubmissionController::approveArticle()` 
- When editor clicks "Approve":
  - Update `approval_status` to `'approved'` in submissions table
  - Update article status to `'accepted'` (or keep as `'pending_approve'` based on business logic)
  - Optionally move `approval_pending_file` to main `file_path` if this is the final approved version
  - Create notification for author that article has been approved
  - Prevent editor from sending the file again (add check to prevent duplicate approval requests)

**Validation:**
- Editor should not be able to send another approval request if:
  - There is already a pending approval file (`approval_status` is `'pending'`)
  - The article has already been approved (`approval_status` is `'approved'`)

### 7. Status Management

**Article Status Flow:**
- Normal flow: `submitted` → `under_review` → `revision_required` → `accepted` → `published`
- New approval flow: `submitted` → `under_review` → `pending_approve` → (author uploads file) → (editor approves) → `accepted` → `published`

**Submission Status:**
- Should mirror article status changes
- Track approval-specific status in `approval_status` column separately

### 8. UI/UX Enhancements

**Editor Side:**
- Add visual indicator (badge/icon) when article is in "pending_approve" status
- Show count of pending approval files in dashboard/listing
- Disable "Send for Approval" button if approval is already pending or approved

**Author Side:**
- Show clear call-to-action when approval request is received
- Display upload progress indicator
- Show confirmation message after file upload
- Display approval status clearly (Pending, Approved, Rejected)

### 9. Notifications

**Create notifications for:**
- Author: When editor sends approval request
- Author: When editor approves the article
- Editor: When author uploads a file for approval
- Editor: Reminder if approval file is pending for more than X days (optional)

### 10. File Management

**File Storage:**
- Approval files: `storage/app/public/approval_files/{article_id}/{timestamp}_{filename}`
- Keep original submission files separate from approval files
- When approved, optionally archive or move approval file to final location

**File Cleanup:**
- Consider cleanup strategy for rejected approval files
- Keep approved files for record-keeping

## Implementation Checklist

- [ ] Database migrations for new columns and status values
- [ ] Update Article and Submission models with new status values
- [ ] Update EditorMessage model with `is_approval_request` field
- [ ] Modify editor message sending form to include "Send for Approval" option
- [ ] Update `Editor_SubmissionController::sendMessage()` method
- [ ] Create author file upload form for approval
- [ ] Create `uploadApprovalFile()` controller method
- [ ] Update editor view to show pending approval files
- [ ] Create `approveArticle()` controller method
- [ ] Add validation to prevent duplicate approval requests
- [ ] Update author article view to show approval request messages
- [ ] Add notifications for all approval workflow steps
- [ ] Update status badges and indicators throughout the application
- [ ] Add route definitions for new endpoints
- [ ] Test complete workflow: Editor request → Author upload → Editor approve

## Technical Notes

- Use Laravel's file storage system (`Storage::disk('public')`)
- Ensure proper file validation (size, type, etc.)
- Add proper authorization checks (editor can only approve articles in their journal)
- Consider adding audit trail/logging for approval actions
- Handle edge cases (multiple approval requests, file upload failures, etc.)

