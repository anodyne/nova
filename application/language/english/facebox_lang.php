<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| LANGUAGE FILE - ENGLISH
|---------------------------------------------------------------
| File: application/language/english/facebox_lang.php
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

$lang['fbx_change_password'] = 'Change Password';
$lang['fbx_change_password_text'] = "You have recently reset your password. Before you continue, please change your password to something you'll remember.";

/*
|---------------------------------------------------------------
| HEADER ASSETS
|---------------------------------------------------------------
*/

$lang['fbx_head'] = "%s %s";

$lang['fbx_action_add'] 	= 'add';
$lang['fbx_action_create'] 	= 'create';
$lang['fbx_action_del'] 	= 'delete';
$lang['fbx_action_edit'] 	= 'edit';
$lang['fbx_action_info'] 	= 'info '. NDASH .' ';
$lang['fbx_action_update'] 	= 'update';
$lang['fbx_action_dup']		= 'duplicate';

/*
|---------------------------------------------------------------
| ITEMS
|---------------------------------------------------------------
*/

$lang['fbx_item_award_img_large'] = 'large award image directory';
$lang['fbx_item_post_count'] = 'post count format';
$lang['fbx_item_users_role'] = 'users with this role';
$lang['fbx_item_role_page'] = 'role page';
$lang['fbx_item_role_group'] = 'role page group';
$lang['fbx_item_role'] = 'role';
$lang['fbx_item_site_message'] = 'site message';
$lang['fbx_item_site_setting'] = 'site setting';
$lang['fbx_item_bio_field'] = 'bio field';
$lang['fbx_item_bio_field_value'] = 'bio field value';
$lang['fbx_item_bio_tab'] = 'bio tab';
$lang['fbx_item_bio_sec'] = 'bio section';
$lang['fbx_item_tour_field'] = 'tour field';
$lang['fbx_item_tour_field_value'] = 'tour field value';
$lang['fbx_item_specs_field'] = 'specifications field';
$lang['fbx_item_specs_field_value'] = 'specifications field value';
$lang['fbx_item_specs_sec'] = 'specifications section';
$lang['fbx_item_news_comment'] = 'news item comment';
$lang['fbx_item_log_comment'] = 'personal log comment';
$lang['fbx_item_post_comment'] = 'mission post comment';
$lang['fbx_item_menu'] = 'menu item';
$lang['fbx_item_menucat'] = 'menu category';
$lang['fbx_item_catalogue_ranks'] = 'rank catalogue item';
$lang['fbx_item_catalogue_skins'] = 'skin catalogue item';
$lang['fbx_item_catalogue_skinsecs'] = 'skin section';
$lang['fbx_item_deck'] = 'deck';
$lang['fbx_item_online_timespan'] = "Who". RSQUO ."s Online Timespan";
$lang['fbx_item_position'] = 'position';
$lang['fbx_item_dept'] = 'department';
$lang['fbx_item_rank'] = 'rank';
$lang['fbx_item_posting_req'] = 'posting requirement';

/*
|---------------------------------------------------------------
| CONTENT TEXT
|---------------------------------------------------------------
*/

$lang['fbx_content_info_users_with_role'] = "The following users have been granted the <strong>%s</strong> access role:";

$lang['fbx_content_add_role_page'] = 'Use the form below to create a new page that will be available under access control';
$lang['fbx_content_add_site_message'] = 'Using the form below you can create new messages that you will be able to manually put in to your own pages or replace existing messages. You must have all 3 fields below. The key is used to reference the message. It should be short and simple and contain no spaces. The label is how it will appear in the Site Messages page.';
$lang['fbx_content_add_user_setting'] = "Using the form below you can create new system settings that can be inserted into your own created pages or supplement Nova's settings by extending the system core. A label and key are required. At this time, user-created settings are only editable through a simple text field.";
$lang['fbx_content_add_bio_field'] = "Using the form below you can create new field to be used on the bio and join pages. If you select dropdown menu as the type, you can specify the values of the dropdown at the bottom of this box.";
$lang['fbx_content_add_bio_tab'] = "Using the form below you can create new tab to be used on the character bio page. <strong>Note:</strong> the link ID field needs to be a unique identifier for the tab between the words one and ten. Make sure that your link ID isn't used elsewhere on the bio page. Nova uses IDs one, two and three by default.";
$lang['fbx_content_add_bio_sec'] = "Using the form below you can create new section to be used on the character bio and join pages. <strong>Note:</strong> if you do not have tabs set up, you can set the tab to Please Select One. If you do have tabs set up and do not specify a tab, your section will appear in the first tab of the character biography page.";
$lang['fbx_content_add_tour_field'] = "Using the form below you can create new field to be used on the tour form. If you select dropdown menu as the type, you can specify the values of the dropdown at the bottom of this box.";
$lang['fbx_content_add_spec_sec'] = "Using the form below you can create new section to be used on the specs page. Once created, you will be able to assign fields to specific sections.";
$lang['fbx_content_add_spec_field'] = "Using the form below you can create new field to be used on the specifications page. If you select dropdown menu as the type, you can specify the values of the dropdown at the bottom of this box.";
$lang['fbx_content_add_role_group'] = 'Use the form below to create a new role page group that will be available for organizing your role pages.';
$lang['fbx_content_add_menucat'] = "Use the fields below to create a new menu category that will be available for organizing your admin menu items. The category field should be the same as the menu category from the menu items you want to group together.";
$lang['fbx_content_add_rank'] = "Use the fields below to create a new rank item. For the image field, you only need to provide the name of the image. The image extension is set by the rank catalogue and is shown after the image field for reference.";

$lang['fbx_content_del_site_message'] = "Are you sure you want to delete the <strong>%s</strong> site message? This action is permanent and cannot be undone!";
$lang['fbx_content_del_role_page'] = "Are you sure you want to delete the <strong>%s</strong> role page? This action will affect system roles, is permanent and cannot be undone!";
$lang['fbx_content_del_user_setting'] = "Are you sure you want to delete the <strong>%s</strong> system setting? This action will affect system settings, is permanent and cannot be undone!";
$lang['fbx_content_del_bio_tab'] = "Are you sure you want to delete the <strong>%s</strong> bio tab? This action will affect character biographies, is permanent and cannot be undone! Please select the new tab that all sections currently associated with this tab will be moved to.";
$lang['fbx_content_del_bio_sec'] = "Are you sure you want to delete the <strong>%s</strong> bio section? This action will affect character biographies, is permanent and cannot be undone! Please select the new section that all fields currently associated with this section will be moved to.";
$lang['fbx_content_del_bio_field'] = "Are you sure you want to delete the <strong>%s</strong> bio field? All data associated with this field will be deleted. This action will affect character biographies, is permanent and cannot be undone!";
$lang['fbx_content_del_tour_field'] = "Are you sure you want to delete the <strong>%s</strong> tour field? All data associated with this field will be deleted. This action will affect tour items, is permanent and cannot be undone!";
$lang['fbx_content_del_specs_sec'] = "Are you sure you want to delete the <strong>%s</strong> specifications section? This action will affect the specs page, is permanent and cannot be undone! Please select the new section that all fields currently associated with this section will be moved to.";
$lang['fbx_content_del_specs_field'] = "Are you sure you want to delete the <strong>%s</strong> specifications field? All data associated with this field will be deleted. This action will affect specifications, is permanent and cannot be undone!";
$lang['fbx_content_del_role'] = "Are you sure you want to delete the <strong>%s</strong> role? This action will affect user accounts, is permanent and cannot be undone! Please select the new role that all users currently with this role will be reassigned to.";
$lang['fbx_content_del_role_group'] = "Are you sure you want to delete the <strong>%s</strong> role page group? This action will affect role pages, is permanent and cannot be undone! Please select the new group that all pages currently with this group will be reassigned to.";
$lang['fbx_content_del_menu'] = "Are you sure you want to delete the <strong>%s</strong> menu item? This action will affect the entire system, is permanent and cannot be undone!";
$lang['fbx_content_del_menucat'] = "Are you sure you want to delete the <strong>%s</strong> menu category? This action will affect the entire system, is permanent and cannot be undone!";
$lang['fbx_content_del_catalogue_rank'] = "Are you sure you want to delete the <strong>%s</strong> rank set? This action will affect the entire system, is permanent and cannot be undone! Please select a new rank set to update all users currently using this rank set to.";
$lang['fbx_content_del_catalogue_skin'] = "Are you sure you want to delete the <strong>%s</strong> skin? This action will affect the entire system, is permanent and cannot be undone! Before deleting this skin, please make sure you have changed all the skin section defaults! Failure to change the defaults could result in skin display problems for all users.";
$lang['fbx_content_del_catalogue_skinsec'] = "Are you sure you want to delete the %s <strong>%s</strong> theme? This action will affect the entire system, is permanent and cannot be undone! Please select a new theme to update all users currently using this theme to.";
$lang['fbx_content_del_dept'] = "Are you sure you want to delete the <strong>%s</strong> %s? This action will affect the entire system, is permanent and cannot be undone! Please select a new %s to move all %s within this %s into to. Additionally, you can choose to delete all %s from this %s by checking the Delete checkbox.";

$lang['fbx_content_del_entry'] = "Are you sure you want to delete the %s <strong>%s</strong>? This action is permanent and cannot be undone!";

$lang['fbx_content_del_character'] = "Are you sure you want to delete the %s <strong>%s</strong>? This action is permanent and cannot be undone! If this %s is associated with an account, it will be removed. If this %s is someone". RSQUO ."s main %s, Nova will automatically assign them a new main %s from their list of %s.";

$lang['fbx_content_approve_entry'] = "Are you sure you want to approve the %s <strong>%s</strong>%s?";

/* End of file facebox_lang.php */
/* Location: ./application/language/english/facebox_lang.php */