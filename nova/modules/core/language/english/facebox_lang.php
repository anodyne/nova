<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * English language file - Facebox text
 *
 * @package		Nova
 * @category	Language
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 * @version		2.0
 */

$lang['fbx_head'] = "%s %s";

$lang['fbx_item_users_role'] = 'users with this role';

/*
|---------------------------------------------------------------
| CONTENT TEXT
|---------------------------------------------------------------
*/

$lang['fbx_change_password_text'] = "You have recently reset your password. Before you continue, please change your password to something you'll remember.";

$lang['fbx_content_info_users_with_role'] = "The following users have been granted the <strong>%s</strong> access role:";

$lang['fbx_content_info_release_post_lock'] = "The lock on the %s <strong>%s</strong> has been released. Click OK to continue.";

$lang['fbx_content_add_site_message'] = 'Using the form below you can create new messages that you will be able to manually put in to your own pages or replace existing messages. You must have all 3 fields below. The key is used to reference the message. It should be short and simple and contain no spaces. The label is how it will appear in the Site Messages page.';
$lang['fbx_content_add_user_setting'] = "Using the form below you can create new system settings that can be inserted into your own created pages or supplement Nova's settings by extending the system core. A label and key are required. At this time, user-created settings are only editable through a simple text field.";
$lang['fbx_content_add_bio_field'] = "Using the form below you can create new field to be used on the bio and join pages. If you select dropdown menu as the type, you can specify the values of the dropdown at the bottom of this box.";
$lang['fbx_content_add_bio_tab'] = "Using the form below you can create new tab to be used on the character bio page. <strong>Note:</strong> the link ID field needs to be a unique identifier for the tab between the words one and ten. Make sure that your link ID isn't used elsewhere on the bio page. Nova uses IDs one, two and three by default.";
$lang['fbx_content_add_bio_sec'] = "Using the form below you can create new section to be used on the character bio and join pages. <strong>Note:</strong> if you do not have tabs set up, you can set the tab to Please Select One. If you do have tabs set up and do not specify a tab, your section will appear in the first tab of the character biography page.";
$lang['fbx_content_add_tour_field'] = "Using the form below you can create new field to be used on the tour form. If you select dropdown menu as the type, you can specify the values of the dropdown at the bottom of this box.";
$lang['fbx_content_add_spec_sec'] = "Using the form below you can create new section to be used on the specs page. Once created, you will be able to assign fields to specific sections.";
$lang['fbx_content_add_spec_field'] = "Using the form below you can create new field to be used on the specifications page. If you select dropdown menu as the type, you can specify the values of the dropdown at the bottom of this box.";
$lang['fbx_content_add_docking_field'] = "Using the form below you can create new field to be used on the docking form. If you select dropdown menu as the type, you can specify the values of the dropdown at the bottom of this box.";
$lang['fbx_content_add_docking_sec'] = "Using the form below you can create new section to be used on the docking form. Once created, you will be able to assign fields to specific sections.";
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
$lang['fbx_content_del_docking_field'] = "Are you sure you want to delete the <strong>%s</strong> docking field? All data associated with this field will be deleted. This action will affect the docking form, is permanent and cannot be undone!";
$lang['fbx_content_del_docking_sec'] = "Are you sure you want to delete the <strong>%s</strong> docking section? This action will affect the docking form, is permanent and cannot be undone! Please select the new section that all fields currently associated with this section will be moved to.";
$lang['fbx_content_del_role'] = "Are you sure you want to delete the <strong>%s</strong> role? This action will affect user accounts, is permanent and cannot be undone! Please select the new role that all users currently with this role will be reassigned to.";
$lang['fbx_content_del_role_group'] = "Are you sure you want to delete the <strong>%s</strong> role page group? This action will affect role pages, is permanent and cannot be undone! Please select the new group that all pages currently with this group will be reassigned to.";
$lang['fbx_content_del_menu'] = "Are you sure you want to delete the <strong>%s</strong> menu item? This action will affect the entire system, is permanent and cannot be undone!";
$lang['fbx_content_del_menucat'] = "Are you sure you want to delete the <strong>%s</strong> menu category? This action will affect the entire system, is permanent and cannot be undone!";
$lang['fbx_content_del_catalogue_rank'] = "Are you sure you want to delete the <strong>%s</strong> rank set? This action will affect the entire system, is permanent and cannot be undone! Please select a new rank set to update all users currently using this rank set to.";
$lang['fbx_content_del_catalogue_skin'] = "Are you sure you want to delete the <strong>%s</strong> skin? This action will affect the entire system, is permanent and cannot be undone! %s";
$lang['fbx_content_del_catalogue_skin_wsections'] = "Use the menus below to set the new skins to update all users who are currently using this skin to.";
$lang['fbx_content_del_catalogue_skinsec'] = "Are you sure you want to delete the %s <strong>%s</strong> theme? This action will affect the entire system, is permanent and cannot be undone! Please select a new theme to update all users currently using this theme to.";
$lang['fbx_content_del_dept'] = "Are you sure you want to delete the <strong>%s</strong> %s? This action will affect the entire system, is permanent and cannot be undone! Please select a new %s to move all %s within this %s into to. Additionally, you can choose to delete all %s from this %s by checking the Delete checkbox.";

$lang['fbx_content_del_entry'] = "Are you sure you want to delete the %s <strong>%s</strong>? This action is permanent and cannot be undone!";

$lang['fbx_content_del_character'] = "Are you sure you want to delete the %s <strong>%s</strong>? This action is permanent and cannot be undone! If this %s is associated with an account, it will be removed. If this %s is someone". RSQUO ."s main %s, Nova will automatically assign them a new main %s from their list of %s.";

$lang['fbx_content_approve_entry'] = "Are you sure you want to approve the %s <strong>%s</strong>%s?";

$lang['fbx_content_draft_cleanup'] = "Like most wiki software, Thresher stores each saved version of a wiki page as a draft. This allows you to do a bunch of work, and if you don't like it, revert back to the previous version of the page. If you have a lot of pages and drafts, your database can get pretty large. If you're concerned about the size of your database, you can clean up some of the wiki drafts. Use the dropdown below to select which drafts you want to clean up.\r\n\r\n<strong class='red'>Warning:</strong> Removing old drafts will clear the history for each page and you won't be able to revert to old versions. Proceed with caution!";

$lang['fbx_content_user_deactivate'] = "Are you sure you want to deactivate <strong>%s (%s)</strong>? Deactivating this user will prevent them from logging in and participating in the game. Additionally, any %s associated with this account will be deactivated. Click Submit to the continue.";
$lang['fbx_content_user_activate'] = "Are you sure you want to activate <strong>%s (%s)</strong>? Activating this user will allow them to log in and participate in the game. You can select from the %s associated with this %s account to activate along with the user below. Please make your selections and click Submit to the continue.";
$lang['fbx_content_user_password_reset'] = "Are you sure you want to reset the password for <strong>%s (%s)</strong>? The %s will be emailed a new password and prompted to change their password next time they log in. Click Submit to continue.";

$lang['fbx_content_character_selections'] = "Please make your selections and click Submit to continue.";

$lang['fbx_content_character_activate'] = "Are you sure you want to activate <strong>%s</strong>? Activating this %s will make them part of the active crew and appear on the manifest.\r\n\r\nYou can select the %s to associate this %s with and if it should be the primary %s (if you choose to make this the primary %s, the current primary %s will still be associated with the %s). %s";

$lang['fbx_content_character_deactivate'] = "Are you sure you want to deactivate <strong>%s</strong>? Deactivating this %s will remove them from the active crew. %s %s %s %s";
$lang['fbx_content_character_deactivate_userdeac'] = "This action will remove all active %s from the %s. You can deactivate the %s by selecting the checkbox below.";
$lang['fbx_content_character_deactivate_newmainchar'] = "This %s is the primary %s for the %s and you will need to choose a new primary %s for the %s from the dropdown menu.";

$lang['fbx_content_character_npc'] = "Are you sure you want to change <strong>%s</strong> to be a %s %s? %s %s %s %s";
$lang['fbx_content_character_npc_removeuser'] = "You can remove the %s association for this %s by selecting the checkbox below.";
$lang['fbx_content_character_npc_deacuser'] = "If this %s is the only active %s for this %s, you can deactivate the %s.";
$lang['fbx_content_character_npc_newmain'] = "Because this %s is the main %s for a %s, you will need to select a new main %s.";

$lang['fbx_content_character_playing'] = "Are you sure you want to change <strong>%s</strong> to be a %s %s?\r\n\r\nYou can change the %s this %s is associated with (if the %s you select is inactive, they will be reactivated). You can also set this %s to be the new main %s for the %s you select. %s";
