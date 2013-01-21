<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * English language file - Error messages
 *
 * @package		Nova
 * @category	Language
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 * @version		2.0
 */

$lang['error_pagetitle'] = 'Error!';

$lang['error_title_invalid_id'] = 'Error ' . NDASH . ' Invalid ID Number!';
$lang['error_title_id_not_found'] = 'Error ' . NDASH . ' No ID Found!';
$lang['error_title_invalid_char'] = "Error ".NDASH." %s Not Found!";
$lang['error_title_invalid_user'] = "Error ".NDASH." %s Not Found!";

$lang['error_head_not_found'] = 'Error '. NDASH .' Not Found!';
$lang['error_head_general'] = 'Error!';

$lang['error_msg_news_id_numeric'] = "%s ID numbers can only be numeric.";
$lang['error_msg_id_numeric'] = 'ID numbers can only be numeric. Please try again.';
$lang['error_msg_news_not_found'] = "There was no %s found with that ID number. Please try again.";
$lang['error_msg_not_found'] = 'There was no item found with that ID number. Please try again.';
$lang['error_msg_invalid_char'] = "You have specified a %s that does not exist. Please try again.";
$lang['error_msg_invalid_user'] = "You have specified a %s that does not exist. Please try again.";
$lang['error_msg_no_awardees'] = "No one has been given this %s yet.";
$lang['error_msg_no_mission'] = "No %s was found with that ID number. Please try again.";
$lang['error_msg_no_award_type'] = "You must specify whether you want to view a %s's awards (c) or a %s's awards (u).";
$lang['error_msg_no_post_type'] = "You must specify whether you want to view a %s's posts (c) or a %s's posts (u).";
$lang['error_msg_no_log_type'] = "You must specify whether you want to view a %s's personal logs (c) or a %s's personal logs (u).";

$lang['error_login_1'] = 'You must log in to continue!';
$lang['error_login_2'] = 'Email address not found, please try again.';
$lang['error_login_3'] = 'Your password does not match our records, please try again.';
$lang['error_login_4'] = 'We have found more than one account with your email address. Please contact the game master to resolve this issue.';
$lang['error_login_5'] = 'Maintenance mode has been activated! Only system administrators are allowed to log in. Please try again later.';
$lang['error_login_6'] = 'You have attempted to log in more times than the system allows. You must wait %d minutes before attempting to login again! %s';
$lang['error_login_7'] = 'Your account is currently pending %s review. You will not be allowed to log in until your application has been accepted. Please contact the %s if you have questions.';

$lang['error_last_login_time'] = 'Your last log in was %d %s ago. You must wait another %d %s before you can log in again.';

$lang['error_update_1'] = 'Maintenance mode is not active! The system cannot be updated until maintenance mode is turned on.';
$lang['error_update_2'] = 'You must be a system administrator to update this system!';
$lang['error_update_3'] = "You must be a system administrator to modify this system's database!";
$lang['error_update_4'] = 'The table you are attempting to create already exists!';
$lang['error_update_5'] = 'You must be logged in to update this system!';

$lang['error_admin_1'] = 'You are not authorized to view this page!';

$lang['error_no_coc'] = 'The chain of command has not been setup yet!';
$lang['error_no_last_post'] = 'No posts recorded';
$lang['error_no_last_login'] = 'No login recorded';
$lang['error_no_pm'] = 'No private message with that ID found';

$lang['error_not_found'] = "No %s found";

$lang['error_invalid_tab'] = 'Invalid tab '.NDASH.' Section will not display!';

$lang['error_private_news'] = "You must be logged in to view a private %s. Please login and try again.";

$lang['error_admin_1'] = "You are not authorized to view this page. If you believe you have received this message in error, please contact the game master.";
$lang['error_admin_2'] = 'You are only authorized to view private messages that you wrote or are a recipient of. If you believe you have received this message in error, please contact the game master.';
$lang['error_admin_3'] = 'You are only authorized to reply to private messages that you are a recipient of. If you believe you have received this message in error, please contact the game master.';
$lang['error_admin_4'] = 'You are only authorized to take action on saved item you own. If you believe you have received this message in error, please contact the game master.';
$lang['error_admin_5'] = 'You are not authorized to take action on items that are pending or have been activated. If you believe you have received this message in error, please contact the game master.';
$lang['error_admin_6'] = 'You are not authorized to edit entries where you are not one of the authors. If you believe you have received this message in error, please contact the game master.';
$lang['error_admin_7'] = 'You are not authorized to update any accounts except your own. If you believe you have received this message in error, please contact the game master.';

$lang['error_wcp_1'] = 'You do not have a %s associated with your account. Without a %s associated with your account, you cannot continue. Please have the system administrator assign a %s to your account, log out, log back in and try again.';

$lang['error_generic'] = 'An error has occurred that prevented your request from being completed. Please try your request again. If the problem persists, please contact the system administrator.';

$lang['error_skin_defaults'] = 'You do not have defaults set for each skin section. Please set the defaults now to prevent any problems throughout the system!';

$lang['error_no_mission_fail'] = "No current %s exist! In order to create a %s, you must first create a %s.";

$lang['error_illegal_post'] = 'Your entry was not posted because you are not a member of the post.';

$lang['error_wiki_1'] = "The wiki page you attempted to view is a restricted page that you are not authorized to view. If you believe you've received this message in error, please contact the %s.";
$lang['error_wiki_2'] = "The wiki page draft you attempted to view is associated with a restricted wiki page which you are not authorized to view. If you believe you've received this message in error, please contact the %s.";
$lang['error_wiki_3'] = "You are not authorized to view page drafts. If you believe you've received this message in error, please contact the %s.";
