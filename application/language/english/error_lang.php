<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| LANGUAGE FILE - ENGLISH
|---------------------------------------------------------------
| File: application/language/english/error_lang.php
| System Version: 1.0
|
| English language file for the system. Punctuation constants are
| defined in ./application/config/constants.php
|
|---------------------------------------------------------------
| NOTES
|---------------------------------------------------------------
| The following should not be translated:
|
| NDASH		- translates to a medium dash
| RSQUO		- translates to a right single quote
| RARROW	- translates to a right double arrow
| LARROW	- translates to a left double array
| AMP		- translates to an ampersand
|
| Rules:
|
| # If you use an apostrophe (') in your translations, you shoud be
|   using the our constant for it (RSQUO). There are examples in the
|	translated content.
| # If you use a dash (-) in your translations, you should be using
|   the our constant for it (NDASH). There are examples in the
|	translated content.
| # All language items should be in lowercase unless the original
|   English uses mixed case or uppercase.
| # Do not translate the array keys (the text in the brackets), only
|   translate what is on the right side of the equal sign (=).
*/

$lang['error_pagetitle'] = 'Error!';

$lang['error_title_invalid_id'] = 'Error ' . NDASH . ' Invalid ID Number!';
$lang['error_title_id_not_found'] = 'Error ' . NDASH . ' No ID Found!';
$lang['error_title_invalid_char'] = 'Error ' . NDASH . ' Character Not Found!';
$lang['error_title_invalid_player'] = 'Error ' . NDASH . ' Player Not Found!';
$lang['error_title_invalid_mission'] = 'Error ' . NDASH . ' Mission Not Found!';

$lang['error_head_not_found'] = 'Error '. NDASH .' Not Found!';
$lang['error_head_general'] = 'Error!';

$lang['error_msg_news_id_numeric'] = 'News item ID numbers can only be numeric.';
$lang['error_msg_id_numeric'] = 'ID numbers can only be numeric. Please try again.';
$lang['error_msg_news_not_found'] = 'There was no news item found with that ID number. Please try again.';
$lang['error_msg_not_found'] = 'There was no item found with that ID number. Please try again.';
$lang['error_msg_invalid_char'] = 'You have specified a character that does not exist. Please try again.';
$lang['error_msg_invalid_player'] = 'You have specified a player that does not exist. Please try again.';
$lang['error_msg_no_awards'] = 'No awards found.';
$lang['error_msg_no_awardees'] = 'No one has been given this award yet.';
$lang['error_msg_no_depts'] = 'No departments found.';
$lang['error_msg_no_news'] = 'No news items found.';
$lang['error_msg_no_mission'] = 'No mission was found with that ID number. Please try again.';
$lang['error_msg_no_award_type'] = 'You must specify whether you want to view a character'. RSQUO .'s awards (c) or a player'. RSQUO .'s awards (p).';
$lang['error_msg_no_post_type'] = 'You must specify whether you want to view a character'. RSQUO .'s posts (c) or a player'. RSQUO .'s posts (p).';
$lang['error_msg_no_log_type'] = 'You must specify whether you want to view a character'. RSQUO .'s personal logs (c) or a player'. RSQUO .'s personal logs (p).';

$lang['error_login_1'] = 'You must login to continue!';
$lang['error_login_2'] = 'Email address not found, please try again.';
$lang['error_login_3'] = 'Your password does not match our records, please try again.';
$lang['error_login_4'] = 'We have found more than one account with your email address. Please contact the game master to resolve this issue.';
$lang['error_login_5'] = 'Maintenance mode has been activated! Only system administrators are allowed to login. Please try again later.';
$lang['error_login_6'] = 'You have attempted to login more times than the system allows. You must wait %d minutes before attempting to login again! %s';

$lang['error_last_login_time'] = 'Your last login was %d %s ago. You must wait another %d %s before you can login again.';

$lang['error_update_1'] = 'Maintenance mode is not active! The system cannot be updated until maintenance mode is turned on.';
$lang['error_update_2'] = 'You must be a system administrator to update this system!';
$lang['error_update_3'] = 'You must be a system administrator to modify this system' . RSQUO . 's database!';
$lang['error_update_4'] = 'The table you are attempting to create already exists!';
$lang['error_update_5'] = 'You must be logged in to update this system!';

$lang['error_admin_1'] = 'You are not authorized to view this page!';

$lang['error_no_coc'] = 'The chain of command has not been setup yet!';
$lang['error_no_logs'] = 'No personal logs found';
$lang['error_no_posts'] = 'No mission entries found';
$lang['error_no_news'] = 'No news items found';
$lang['error_no_missions'] = 'No missions found';
$lang['error_no_mission_summary'] = 'No mission summary found';
$lang['error_no_awards'] = 'No awards found';
$lang['error_no_decks'] = 'No deck listing found';
$lang['error_no_specs'] = 'No specifications found';
$lang['error_no_tour_all'] = 'No tour items found';
$lang['error_no_rank_history'] = 'No rank history found';
$lang['error_no_messages'] = 'No site messages found';
$lang['error_no_site_message'] = 'No site message found';
$lang['error_no_last_post'] = 'No posts recorded';
$lang['error_no_last_login'] = 'No login recorded';
$lang['error_no_inbox'] = 'No private messages found';
$lang['error_no_outbox'] = 'No sent private messages found';
$lang['error_no_pm'] = 'No private message with that ID found';
$lang['error_no_user_settings'] = 'No user-created settings found';
$lang['error_no_users'] = 'No users found';
$lang['error_no_catalogue_ranks'] = 'No ranks found';
$lang['error_no_catalogue_skins'] = 'No skins found';
$lang['error_no_catalogue_themes'] = 'No themes found';
$lang['error_no_award_nominations'] = 'No award nominations found';
$lang['error_no_awards_to_give'] = 'There are no awards to give for this character type!';

$lang['error_invalid_tab'] = 'Invalid tab '. NDASH .' Section will not display!';

$lang['error_private_news'] = 'You must be logged in to view a private news item. Please login and try again.';

$lang['error_admin_1'] = "You are not authorized to view this page. If you believe you have received this message in error, please contact the game master.\r\n\r\nYou attempted to access <strong>%s</strong>. In order to access that page, you must have at least the following credentials: %s.";
$lang['error_admin_2'] = 'You are only authorized to view private messages that you wrote or are a recipient of. If you believe you have received this message in error, please contact the game master.';
$lang['error_admin_3'] = 'You are only authorized to reply to private messages that you are a recipient of. If you believe you have received this message in error, please contact the game master.';
$lang['error_admin_4'] = 'You are only authorized to take action on saved item you own. If you believe you have received this message in error, please contact the game master.';
$lang['error_admin_5'] = 'You are not authorized to take action on items that are pending or have been activated. If you believe you have received this message in error, please contact the game master.';
$lang['error_admin_6'] = 'You are not authorized to edit entries where you are not one of the authors. If you believe you have received this message in error, please contact the game master.';
$lang['error_admin_7'] = 'You are not authorized to update any accounts except your own. If you believe you have received this message in error, please contact the game master.';

$lang['error_generic'] = 'An error has occurred that prevented your request from being completed. Please try your request again. If the problem persists, please contact the system administrator.';

$lang['error_skin_defaults'] = 'You do not have defaults set for each skin section. Please set the defaults now to prevent any problems throughout the system!';

$lang['error_no_mission_fail'] = "No current %s exist! In order to create a %s, you must first create a %s.";

/* End of file error_lang.php */
/* Location: ./application/language/english/error_lang.php */