<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| LANGUAGE FILE - ENGLISH
|---------------------------------------------------------------
| File: application/language/english/long_text_lang.php
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

$lang['text_im_instructions'] = 'Put each IM handle on its own line';

$lang['text_image_select'] = "Click on a link or image to add the image to the %s.";

$lang['text_upload_image'] = 'You can upload images to the server for use in your bios, award images, tour images or mission images. Select the type of image you'. RSQUO .'re uploading and the image and click upload.';

$lang['text_manage_decks'] = "You can change the order of your %s listing by dragging the blocks below into the order you want and clicking Update. If you would like to add a %s to the end of the list, simply type its name and click Add. If you want to edit the item, click on the text in the block. To remove a %s from the listing, click the close icon on its block.";

$lang['text_manage_positions'] = "%s are the heart and soul of Nova". RSQUO ."s character system and from here, you can update the %s available. We". RSQUO ."ve worked hard to move the things you don". RSQUO ."t need out of the way, so we only show the most used elements: the name and open slots (edited through a simple slider from 0 to 50). You can update those elements, or if you want to edit the rest of the %s entry, you can click on the More button to see the rest of the information. Once you have updated all the %s you want, you can click Update to run the update for all the %s on the page.\r\n\r\n<strong class='red'>Deleting and updating positions will affect characters. Proceed with caution!</strong>";

$lang['text_manage_depts'] = "From here, you can create, update and delete the %s available to put your %s into. Once you have updated all the %s you want, you can click Update to run the update for all the %s on the page.\r\n\r\n<strong class='red'>Deleting and updating departments will affect positions and characters. Proceed with caution!</strong>";
$lang['text_manage_dept_reassign'] = "If you want to reassign these %s to be parent level elements, please select none.";

$lang['text_manage_ranks'] = "From here, you can create, update and delete the %s available to assign to %s on the %s. Once you have updated all the %s you want, you can click Update to run the update for all the %s on the page. To delete a %s, simply check the delete box.\r\n\r\n<strong class='red'>Deleting and updating ranks will affect characters. Proceed with caution!</strong>\r\n\r\nThe box below contains all the %s and their %s available. Clicking one of the images will change the %s or %s to let you view the contents of the respective element.";

$lang['text_manage_missions'] = "From here, you can create, update and delete the %s available to play. Nova will automatically set the %s start and end times based on the status. If you are going from upcoming to current, Nova will set the start time automatically. If you are going from current to completed, Nova will set the end time automatically.\r\n\r\n<strong class='red'>Deleting and updating missions will affect %s. Proceed with caution!</strong>";

$lang['text_manage_newscats'] = "%s are divided in to categories to separate them into their respective content areas. From here, you can create, update and delete the %s categories available for %s. Once you have updated all the categories you want, you can click Update to run the update for all the categories on the page. To delete a category, simply check the delete box and then click Update.\r\n\r\n<strong class='red'>Deleting and updating categories will affect %s. Proceed with caution!</strong>";

$lang['text_site_simtypes'] = "Nova allows admins to set different types of sims and use those at various points throughout the system, including with menu items for automatically turning items on and off based on the sim type. Once you have updated all the types you want, you can click Update to run the update for all the types on the page. To delete a sim type, simply check the delete box and then click Update.\r\n\r\n<strong class='red'>Deleting and updating sim types will affect menu items. Proceed with caution!</strong>";

$lang['text_user_credential_confirm_1'] = 'In order to make updates to your account, you must provide your email address and password.';
$lang['text_user_credential_confirm_2'] = 'For security purposes, you must provide your login credentials in order to make updates to this account. You will need to do this for every account you update.';

$lang['text_security_question'] = 'Remember your security answer exactly as you type it!';

$lang['text_loa_request'] = 'Use the form below to notify the game master of any leave of absence you need to take from the game. When you come back from your LOA, remember to change your status here again.';

$lang['text_preferences'] = 'Nova includes a wide array of options for which emails the system will send you. Change your email preferences below by checking/unchecking the boxes you do/don&rsquo;t want to receive.';

$lang['text_logout'] = 'You must logout and log back in for your changes to be applied.';
$lang['text_logout_alt'] = 'In order for these changes to be applied the user must log out and log back in.';

$lang['text_link_characters'] = "Nova provides the ability for a single %s to be associated with multiple %s. From this page, you can link %s with a %s account. To add or remove a %s, click on the respective icon. If you want to change the main %s for a %s, click on the star next to the %s name. <strong>All changes require the %s to log out and log back in for the changes to be applied.</strong>";

$lang['text_award_nomination'] = "Using the fields below, select the %s and %s as well as a short reason why you". RSQUO ."re nominating them. Your submission will be sent to the command staff for their review and approval.";

$lang['text_leave_blank'] = "To help us combat spam from this page, please leave the field below blank.\r\nIf the field is filled in, the form will not submit.";

$lang['text_manage_uploads'] = "Nova provides the ability for users to upload character images, awards, mission images and tour images to the server through an easy-to-use interface. From here, you can manage the uploads available in the system. Removing uploads will delete the record from the database and Nova will attempt to delete the file from the server. You will be notified if Nova can". RSQUO ."t delete the file and you need to delete it manually.";

$lang['text_file_not_deleted'] = "While the record has been removed from the database there was a problem deleting the selected file(s) from the server. Please manually remove the files from the server.";

$lang['text_moderation_report'] = "The moderation status report gives an overview of which %s have been moderated for the different types of posts. Un-moderated users are shown with a green icon (%s) in the appropriate column while moderated users are shown with a red icon (%s) in the appropriate column.";

$lang['text_awardnom_report'] = "The award nomination report gives an overview of all %s nominations that have been submitted. Accepted %s are shown with a green icon (%s), pending %s are shown with a yellow icon (%s) and rejected %s are shown with a red icon (%s).";

$lang['text_applications_report'] = "The application report gives an overview of all application that have been submitted. Accepted applications are shown with a green icon <nobr>(%s)</nobr>, rejected application are shown with a red icon <nobr>(%s)</nobr>, deleted application are shown with a red X <nobr>(%s)</nobr> and applications that have yet to have an action taken on them are shown with a yellow icon <nobr>(%s)</nobr>. You can view the more details about the application by clicking on the view icon.";

$lang['text_dropdown_select'] = "For dropdown menus, please provide the values to be used by the menu. Each item should be on a separate line and have a comma-separated set of values, like: <strong>male,Male</strong>. In that example, the menu item's value would be male and the label seen in the menu would be Male. Your final output should look like:\r\n\r\nmale,Male\r\nfemale,Female\r\nneuter,Neuter";

$lang['text_sim_type'] = "Please choose the type of sim this menu item relates to. If the menu items is used for a specific type of sim, when the overall sim type is changed, Nova will automatically turn the proper items on and off for you.";

$lang['text_menu_access'] = "You can choose the login requirement as well as if a menu item requires access control. For the access control URL, you can put the URL of the page (controller/method) or the URL of another page.";

$lang['text_db_insert'] = "This is the value that will be inserted into the database";

$lang['text_dropdown_value'] = "This is what you will see in the dropdown menu";

$lang['text_stats_avg'] = "&dagger; Averages are calculated by taking the number of posts in the month and dividing by the number of users.  For the current month, the averages are calculated the same but will appear smaller until the end of the month.  End of the month averages will look similar to previous month average.";
$lang['text_stats_pace'] = "&Dagger; Pace is determined by dividing the number of posts in a month by the number of elapsed days, then multiplying by the number of days in a given month.  Actual end of the month numbers may vary.";
$lang['text_search_results'] = 'Your search returned the following %d %s.';
$lang['text_sim_dockingrequest'] = "Use the form below to request to dock with the sim. Your request will be emailed to the game master and they will make a decision in the next few days and notify you whether your request has been accepted or rejected.";
$lang['text_javascript_off'] = 'You must turn Javascript ON to use all of Nova'. RSQUO .'s features!';
$lang['text_display_x_of_y'] = 'Displaying %d of %d %s';
$lang['text_add_new_message'] = "Use the fields below to change any of the messages throughout the site. You can also add a new message and manually plug it in anywhere in Nova.";
$lang['text_add_new_setting'] = 'Nova gives game masters and admins the ability to create their own settings to be used throughout the system. Once a setting is created, it can be added to user-created page or extended core pages and changed through the Site Settings page. At this time, user-created settings can only be edited through a simple text field and you will not have the ability to create a setting that uses a radio button, textarea, or dropdown menu.';

$lang['text_bioform'] = 'Nova provides admins unparalleled control over the character biography and join form. Instead of a static page, the form itself is now built out of the database and the data stored in a dynamic way, giving admins all the control they could ever want. Using the page below, admins can edit the fields seen, delete unwanted fields and add entirely new fields to the form. Admins can create standard text fields, larger textareas or even dropdown menus for users to fill in. Use the links and pages below to start making the bio and join forms your own!';

$lang['text_biosections'] = 'Nova provides admins unparalleled control over the character biography and join form. Instead of a static page, the form itself is now built out of the database and the data stored in a dynamic way, giving admins all the control they could ever want. Using the page below, admins can edit the sections that break the character biography and join form up. If you do not want a section header, just leave the name blank.';

$lang['text_biotabs'] = 'Nova provides admins unparalleled control over the character biography. Instead of a static page, the page itself is now built out of the database and the data stored in a dynamic way, giving admins all the control they could ever want. Using the page below, admins can edit the tabs that break the sections of the character biography up. If you do not want to use tabs, simply set the display property on each item to NO.';

$lang['text_manage_coc'] = 'You can change the order of your chain of command by dragging the blocks below into the order you want and clicking Update. If you would like to add a character to the end of the list, select their name from the dropdown menu and click Add. To remove a character from the chain of command, click the close icon on their block.';

$lang['text_site_bioval'] = 'You can change the order of the field values by dragging the blocks below into the order you want and clicking Update. If you want to edit the item, click on the text in the block. If you would like to add a value to the end of the list, fill out the fields below and click Add. To remove a value from the list, click the close icon on the respective block.';

$lang['text_tourform'] = 'Nova provides admins unparalleled control over the tour form. Instead of a static page, the form itself is now built out of the database and the data stored in a dynamic way, giving admins all the control they could ever want. Using the page below, admins can edit the fields seen, delete unwanted fields and add entirely new fields to the form. Admins can create standard text fields, larger textareas or even dropdown menus to fill in with tour details. Use the links and pages below to start making the tour form your own!';

$lang['text_specsform'] = 'Nova provides admins unparalleled control over the specifications. Instead of a static page, the form itself is now built out of the database and the data stored in a dynamic way, giving admins all the control they could ever want. Using the page below, admins can edit the fields seen, delete unwanted fields and add entirely new fields to the form. Admins can create standard text fields, larger textareas or even dropdown menus to fill in with spec details. Use the links and pages below to start making the specs form your own!';

$lang['text_specssections'] = 'Nova provides admins unparalleled control over the specifications. Instead of a static page, the form itself is now built out of the database and the data stored in a dynamic way, giving admins all the control they could ever want. Using the page below, admins can edit the sections that break the specifications page up. If you do not want a section header, just leave the name blank.';

$lang['text_dockingform'] = 'Nova provides admins unparalleled control over the docking form. Instead of a static page, the form itself is now built out of the database and the data stored in a dynamic way, giving admins all the control they could ever want. Using the page below, admins can edit the fields seen, delete unwanted fields and add entirely new fields to the form. Admins can create standard text fields, larger textareas or even dropdown menus to fill in with docking request details. Use the links and pages below to start making the docking form your own!';

$lang['text_dockingsections'] = 'Nova provides admins unparalleled control over the docking form. Instead of a static page, the form itself is now built out of the database and the data stored in a dynamic way, giving admins all the control they could ever want. Using the page below, admins can edit the sections that break the docking form up. If you do not want a section header, just leave the name blank.';

$lang['text_rolepages'] = 'Nova provides robost access control that includes not only all pages that come with the system by default, but can include pages that you create. To begin adding your pages or editing existing pages, use the page below.';

$lang['text_roles'] = 'Nova provides robust access control that allows admins to put users into roles that define what access people in those roles can have. You can use the form below to create, update and delete roles then assign the roles to users through user management.';

$lang['text_role_groups'] = 'Nova provides robust access control that allows admins to put users into roles that define what access people in those roles can have. To make managing role pages easier, admins can put pages into groups. You can use this page to create, update and delete role page groups then assign the role pages to groups through role page management.';

$lang['text_catalogueranks'] = "Nova provides extensive control over system rank sets even down to the credits for each rank set. Use this page to manage all ranks available for the system. The system default rank set is indicated by the %s icon.";

$lang['text_catalogueskins'] = "Nova provides extensive control over system skins even down to the credits for each skin. Use this page to manage all skins available for the system. Default skin sections are indicated by the %s icon.";

$lang['text_manage_specs'] = 'Nova provides admins unparalleled control over the specifications. Instead of a static page, the form itself is now built out of the database and the data stored in a dynamic way, giving admins all the control they could ever want. Using the page below, admins can edit the specifications data to whatever they want. The links below will take you to the page for editing the form itself.';

$lang['text_quick_install'] = "Nova has detected the following %s aren't installed yet. Using Quick Install, Nova can install these %s quickly and easily. Simply click Install to start the process.";

$lang['text_docking_approve'] = "Are you sure you want to approve the docking request for %s? Accepting this request will notify the %s of your decision automatically using the email below.";

$lang['text_docking_reject'] = "Are you sure you want to reject the docking request for %s? Rejecting this request will notify the %s of your decision automatically using the email below and delete the record. This action is permanent and cannot be undone!";

$lang['text_dynamic_emails'] = "This message includes in the ability to set several variables in the body of the message that will be automatically replaced when the message is parsed. This message includes the following variables that can be used:<br /><br />%s";

$lang['text_mission_groups'] = "%s groups are a new way to organize your %s to make it easier to find related missions. Whether the %s are consecutive or not, you can assign them to groups to display them together on the %s Groups page and give players the ability to quickly see and move through groups of similar %s.";

/*
|---------------------------------------------------------------
| INFORMATIONAL MESSAGES
|---------------------------------------------------------------
*/

$lang['info_online_timespan'] = "The online timespan setting determines the time period in which Nova considers someone as being online. By default, this is set to 5 minutes, but can be changed to any value (in minutes) that you want. The higher the number, the more processing power is required.";

$lang['info_posting_req'] = "The posting requirement is the timespan (in days) in which users must post or risk having some form of disciplinary action taken against them. If a user has gone beyond this timespan, their name will appear in red on the crew activity report as well as the activity panel of the ACP. If you do not use a posting requirement, set this value to zero.";

$lang['info_post_count_format'] = 'Nova allows GMs to count posts in one of two ways. The first way (and default) is <strong>multiple</strong>. This format counts a post as many times as there are authors on the post. If a post has 3 authors, it will count as 3 posts. The second way is <strong>single</strong>. The single format counts a post once regardless of how many authors were part it.';

/*
|---------------------------------------------------------------
| SHORT MESSAGES
|---------------------------------------------------------------
*/

$lang['tags_separated'] = 'Separate tags by commas';
$lang['whats_this'] = '[What is this?]';
$lang['online_now'] = 'who'. RSQUO .'s online now';
$lang['open_gallery'] = 'Click the image to open the gallery';

/*
|---------------------------------------------------------------
| JAVASCRIPT MESSAGES
|---------------------------------------------------------------
*/

$lang['confirm_post_personallog'] = 'Are you sure you want to post this personal log?';
$lang['confirm_post_newsitem'] = 'Are you sure you want to post this news item?';
$lang['confirm_post_missionpost'] = 'Are you sure you want to post this mission entry?';

$lang['confirm_delete_personallog'] = 'Are you sure you want to delete this personal log? This action is permanent and cannot be undone!';
$lang['confirm_delete_newsitem'] = 'Are you sure you want to delete this news item? This action is permanent and cannot be undone!';
$lang['confirm_delete_missionpost'] = 'Are you sure you want to delete this mission entry? This action is permanent and cannot be undone!';

$lang['confirm_join'] = 'Before submitting your application, please make sure you have filled out all the appropriate fields. Are you sure you want to submit this application?';

$lang['alert_pcs_greater_than_zero'] = 'You must allow at least 1 playing character per user!';
$lang['alert_sys_email_off'] = 'Turning off system email will affect the entire system, including reset password emails not being sent out!';

/*
|---------------------------------------------------------------
| WIKI MESSAGES
|---------------------------------------------------------------
*/

$lang['wiki_categories_text'] = "Below are all of the %s that currently exist for the %s. Please click on the links to see a list of all pages in each %s.";

$lang['wiki_revert'] = "Are you sure you want to revert to this previous draft of %s?";

$lang['wiki_search_results'] = "%s search results also take in to account different drafts of a page. If you don't see what you searched for, it's likely in another draft of the pages provided.";

/* End of file long_text_lang.php */
/* Location: ./application/language/english/long_text_lang.php */