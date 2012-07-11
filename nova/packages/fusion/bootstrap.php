<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2011 Fuel Development Team
 * @link       http://fuelphp.com
 */

Autoloader::add_core_namespace('Fusion');

Autoloader::add_classes(array(
	/**
	 * Classes
	 */
	'Fusion\\Location'						=> __DIR__.'/classes/location.php',
	'Fusion\\Model'							=> __DIR__.'/classes/model.php',
	'Fusion\\Nav'							=> __DIR__.'/classes/nav.php',
	'Fusion\\NovaForm'						=> __DIR__.'/classes/novaform.php',
	'Fusion\\QuickInstall'					=> __DIR__.'/classes/quickinstall.php',
	'Fusion\\SystemEvent'					=> __DIR__.'/classes/systemevent.php',
	'Fusion\\Utility'						=> __DIR__.'/classes/utility.php',

	/**
	 * Models
	 */
	'Fusion\\Model_Access_Role'				=> __DIR__.'/classes/model/access/role.php',
	'Fusion\\Model_Access_RoleTask'			=> __DIR__.'/classes/model/access/roletask.php',
	'Fusion\\Model_Access_Task'				=> __DIR__.'/classes/model/access/task.php',
	
	'Fusion\\Model_Announcement'			=> __DIR__.'/classes/model/announcement.php',
	'Fusion\\Model_AnnouncementCategory'	=> __DIR__.'/classes/model/announcementcategory.php',
	'Fusion\\Model_Application'				=> __DIR__.'/classes/model/application.php',
	
	'Fusion\\Model_Award'					=> __DIR__.'/classes/model/award.php',
	'Fusion\\Model_Award_Category'			=> __DIR__.'/classes/model/award/category.php',
	'Fusion\\Model_Award_Queue'				=> __DIR__.'/classes/model/award/queue.php',
	'Fusion\\Model_Award_Receive'			=> __DIR__.'/classes/model/award/receive.php',
	
	'Fusion\\Model_Ban'						=> __DIR__.'/classes/model/ban.php',
	
	'Fusion\\Model_Catalog_Module'			=> __DIR__.'/classes/model/catalog/module.php',
	'Fusion\\Model_Catalog_Rank'			=> __DIR__.'/classes/model/catalog/rank.php',
	'Fusion\\Model_Catalog_Skin'			=> __DIR__.'/classes/model/catalog/skin.php',
	'Fusion\\Model_Catalog_SkinSec'			=> __DIR__.'/classes/model/catalog/skinsec.php',
	'Fusion\\Model_Catalog_Widget'			=> __DIR__.'/classes/model/catalog/widget.php',
	
	'Fusion\\Model_Character'				=> __DIR__.'/classes/model/character.php',
	'Fusion\\Model_Character_Image'			=> __DIR__.'/classes/model/character/image.php',
	'Fusion\\Model_Character_Positions'		=> __DIR__.'/classes/model/character/positions.php',
	'Fusion\\Model_Character_Promotion'		=> __DIR__.'/classes/model/character/promotion.php',
	
	'Fusion\\Model_Comment'					=> __DIR__.'/classes/model/comment.php',
	'Fusion\\Model_Department'				=> __DIR__.'/classes/model/department.php',
	
	'Fusion\\Model_Form'					=> __DIR__.'/classes/model/form.php',
	'Fusion\\Model_Form_Data'				=> __DIR__.'/classes/model/form/data.php',
	'Fusion\\Model_Form_Field'				=> __DIR__.'/classes/model/form/field.php',
	'Fusion\\Model_Form_Section'			=> __DIR__.'/classes/model/form/section.php',
	'Fusion\\Model_Form_Tab'				=> __DIR__.'/classes/model/form/tab.php',
	'Fusion\\Model_Form_Value'				=> __DIR__.'/classes/model/form/value.php',
	
	'Fusion\\Model_Manifest'				=> __DIR__.'/classes/model/manifest.php',
	'Fusion\\Model_Media'					=> __DIR__.'/classes/model/media.php',
	'Fusion\\Model_Message'					=> __DIR__.'/classes/model/message.php',
	'Fusion\\Model_MessageRecipient'		=> __DIR__.'/classes/model/messagerecipient.php',
	'Fusion\\Model_Migration'				=> __DIR__.'/classes/model/migration.php',
	'Fusion\\Model_Mission'					=> __DIR__.'/classes/model/mission.php',
	'Fusion\\Model_MissionGroup'			=> __DIR__.'/classes/model/missiongroup.php',
	'Fusion\\Model_Moderation'				=> __DIR__.'/classes/model/moderation.php',
	'Fusion\\Model_Nav'						=> __DIR__.'/classes/model/nav.php',
	'Fusion\\Model_PersonalLog'				=> __DIR__.'/classes/model/personallog.php',
	'Fusion\\Model_Position'				=> __DIR__.'/classes/model/position.php',
	'Fusion\\Model_Post'					=> __DIR__.'/classes/model/post.php',
	'Fusion\\Model_PostAuthor'				=> __DIR__.'/classes/model/postauthor.php',
	'Fusion\\Model_Rank'					=> __DIR__.'/classes/model/rank.php',
	'Fusion\\Model_Session'					=> __DIR__.'/classes/model/session.php',
	'Fusion\\Model_Settings'				=> __DIR__.'/classes/model/settings.php',
	'Fusion\\Model_SimType'					=> __DIR__.'/classes/model/simtype.php',
	'Fusion\\Model_SiteContent'				=> __DIR__.'/classes/model/sitecontent.php',
	'Fusion\\Model_System'					=> __DIR__.'/classes/model/system.php',
	'Fusion\\Model_SystemEvent'				=> __DIR__.'/classes/model/systemevent.php',
	
	'Fusion\\Model_User'					=> __DIR__.'/classes/model/user.php',
	'Fusion\\Model_User_Loa'				=> __DIR__.'/classes/model/user/loa.php',
	'Fusion\\Model_User_Preferences'		=> __DIR__.'/classes/model/user/preferences.php',
	'Fusion\\Model_User_Suspend'			=> __DIR__.'/classes/model/user/suspend.php',
	
	'Fusion\\Model_Wiki_Category'			=> __DIR__.'/classes/model/wiki/category.php',
	'Fusion\\Model_Wiki_Draft'				=> __DIR__.'/classes/model/wiki/draft.php',
	'Fusion\\Model_Wiki_Page'				=> __DIR__.'/classes/model/wiki/page.php',
	'Fusion\\Model_Wiki_Restriction'		=> __DIR__.'/classes/model/wiki/restriction.php',

	/**
	 * Observers
	 */
	'Fusion\\Observer_Application'			=> __DIR__.'/classes/observer/application.php',
	'Fusion\\Observer_Character'			=> __DIR__.'/classes/observer/character.php',
	'Fusion\\Observer_User'					=> __DIR__.'/classes/observer/user.php',
	
	'Fusion\\Observer_Form_Field'			=> __DIR__.'/classes/observer/form/field.php',
	'Fusion\\Observer_Form_Section'			=> __DIR__.'/classes/observer/form/section.php',
	'Fusion\\Observer_Form_Tab'				=> __DIR__.'/classes/observer/form/tab.php',
));
