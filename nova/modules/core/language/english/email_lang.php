<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * English language file - Email content
 *
 * @package		Nova
 * @category	Language
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 * @version		2.0
 */

/*
|---------------------------------------------------------------
| SUBJECTS
|---------------------------------------------------------------
*/

$lang['email_subject_news_comment_added'] 	= 'New Comment Added to News Item';
$lang['email_subject_log_comment_added'] 	= 'New Comment Added to Personal Log';
$lang['email_subject_post_comment_added'] 	= 'New Comment Added to Mission Post';
$lang['email_subject_wiki_comment_added'] 	= 'New Comment Added to Wiki Page';
$lang['email_subject_join_user'] 			= 'Application Received';
$lang['email_subject_join_gm'] 				= 'Application Received';
$lang['email_subject_docking_request'] 		= 'Docking Request Application';
$lang['email_subject_password_reset'] 		= 'Password Reset';
$lang['email_subject_private_message'] 		= 'Private Message';
$lang['email_subject_personal_log'] 		= 'Personal Log';
$lang['email_subject_news_item'] 			= 'News Item';
$lang['email_subject_saved_post'] 			= ' (Saved Mission Post)';
$lang['email_subject_deleted_post'] 		= 'Mission Post Deletion Notification';
$lang['email_subject_comment_pending'] 		= 'Pending Comment';
$lang['email_subject_post_pending'] 		= 'Pending Mission Post';
$lang['email_subject_log_pending'] 			= 'Pending Personal Log';
$lang['email_subject_news_pending'] 		= 'Pending News Item';
$lang['email_subject_user_status_change'] 	= 'User Status Change Notification';
$lang['email_subject_award_nomination'] 	= 'Award Nomination';
$lang['email_subject_character_approved'] 	= 'Character Application Approved';
$lang['email_subject_character_rejected'] 	= 'Character Application Rejected';
$lang['email_subject_docking_user'] 		= 'Docking Request Received';
$lang['email_subject_docking_gm'] 			= 'Docking Request Received';
$lang['email_subject_docking_approved']		= 'Docking Request Approved';
$lang['email_subject_docking_rejected']		= 'Docking Request Rejected';

/*
|---------------------------------------------------------------
| CONTENT
|---------------------------------------------------------------
*/

$lang['email_content_news_comment_added'] = "A new comment has been added to your news item %s. The content of the comment is below.

%s";

$lang['email_content_log_comment_added'] = "A new comment has been added to your personal log %s. The content of the comment is below.

%s";

$lang['email_content_post_comment_added'] = "A new comment has been added to your mission post %s. The content of the comment is below.

%s";

$lang['email_content_wiki_comment_added'] = "A new comment has been added to your wiki page %s. The content of the comment is below.

%s";

$lang['email_content_join_user'] = "You recently applied to join the %s. Your application is currently under review and the game master will notify you of their decision in the near future. If you have further questions, please contact the game master directly. Your email address and password are provided below for reference.

Email: %s
Password: %s

This is an automatically generated email, do not reply to this message.";

$lang['email_content_join_gm'] = "There is currently an application waiting for your review. The content of the application is displayed below. You can log in to Nova to approve and reject this application.

This is an automatically generated email, do not reply to this message.";

$lang['email_content_docking_request'] = "You have received a docking request application. The content of the application is below. Please note: there is no database interaction with docking ships in this version of Nova. To accept this applicant, you must email them directly.";

$lang['email_content_password_reset'] = "Your password has been reset and is listed below. Next time you log in, you will be prompted to change your password to something else.

New password: %s

<a href='%s'>Click here</a> to login to site now.";

$lang['email_content_private_message'] = "This private message was sent to you from %s. Please log in to reply to this message.

%s

%s";

$lang['email_content_personal_log'] = "The following is a personal log from %s.

%s";

$lang['email_content_news_item'] = "The following is a news item from %s.

%s";

$lang['email_content_post_author'] = "A Mission Post by ";
$lang['email_content_post_timeline'] = "Timeline: ";
$lang['email_content_post_location'] = "Location: ";
$lang['email_content_post_mission'] = "Mission: ";
$lang['email_content_mission_post'] = "%s
%s
%s
%s

%s";

$lang['email_content_mission_post_saved'] = "This email is to notify you that your mission post, %s, has recently been updated. Please log in to make any changes you want before it is posted.  The content of the new post is below.  This is an automatically generated email. Please log in to continue working on this post: %s

%s
%s
%s
%s

%s";

$lang['email_content_mission_post_deleted'] = "This email is to notify you that your joint post, %s, has been deleted by %s.";

$lang['email_content_comment_pending'] = "A comment for the %s %s has been held for moderation and must be approved before it can appear on the site. For reference, the content of the pending comment is below.

%s

Please login using the link below to approve the comment.

%s";

$lang['email_content_entry_pending'] = "The %s %s by %s has been held for moderation and must be approved before it can be emailed to the crew and appear on the site. For reference, the content of the pending %s is below.

%s

Please login using the link below to approve the %s.

%s";

$lang['email_content_user_status_change'] = "%s has changed their status to %s. For reference, the content of the request is below.

New Status: %s
Duration: %s
Reason: %s

This is an automatically generated email, please do not respond.";

$lang['email_content_award_nomination'] = "%s has nominated %s for an award. You will need login to your site to approve or reject this nomination. For reference, the content of the nomination is below.

Award: %s
Nominee: %s
Nominated By: %s
Reason: %s

This is an automatically generated email, please do not respond.";

$lang['email_content_docking_user'] = "You recently applied to dock with the %s. Your application is currently under review and the game master will notify you of their decision in the near future. If you have further questions, please contact the game master directly.

This is an automatically generated email, do not reply to this message.";

$lang['email_content_docking_gm'] = "There is currently a docking request waiting for your review. The content of the application is displayed below. You can log in to Nova to approve and reject this request.

This is an automatically generated email, do not reply to this message.";
