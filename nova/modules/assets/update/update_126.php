<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Update Nova from 1.2.6 to 2.0
 */
$system_versions	= null;
$system_info		= null;
$add_tables			= null;
$drop_tables		= null;
$rename_tables		= null;
$add_column			= null;
$modify_column		= null;
$drop_column		= null;

/**
 * Version info for the database
 */
$system_versions = array(
		'version'			=> '2.0.0',
		'version_major'		=> 2,
		'version_minor'		=> 0,
		'version_update'	=> 0,
		'version_date'		=> 1328389200,
		'version_launch'	=> "You've spoken and we've listened. The feedback we've consistently heard about Nova is that it's great, but there are some things that could be better. Instead of waiting for the next generation of Nova, we've decided to address some of theses issues now. Think Nova is difficult to update? We've fixed that with a brand-new file structure that makes updating as easy as deleting a folder and uploading a new copy of that folder. Think Thresher is a bit limited? We've addressed that with enhancements to just about every part of the wiki (all-new category selection UI, creating categories while creating/editing pages, page restrictions, the ability to edit the content of core wiki pages, better UIs for several pages, etc.). Frustrated by editing a post only to have it wiped out because someone was editing the post at the same time? No more with a brand-new post locking feature that makes sure those frustrations are a thing of the past. On top of that, we've added or enhanced a ton of features in Nova 2 (users will be automatically removed from a post if they didn't participate in it, add previous disallowed HTML content in site messages like script tags and embedded videos, simplified user and character management controls, all-new character selection mechanism for posts and messages, private messaging updates, a new look and feel for Pulsar and Titan, Writing Control Panel improvements, and much more). No matter what way you slice, Nova 2 is a big step forward. More information about these features and everything else in Nova 2 (plus a full changelog) can be found at AnodyneDocs. This update is recommended for all users.",
		'version_changes'	=> "* Site Messages can now contain previously disallowed HTML tags (like `embed`, `iframe`, etc) for adding media from YouTube and Vimeo to site messages (like the welcome message) without needing to use seamless substitution.
* Mission groups can now be added inside other mission groups (nesting only allowed one level deep).
* Users with Level 2 user admin access rights can now reset someone's password for them. The new password will be generated and emailed to the user and they'll be prompted to reset the password the next time they log in. At no time does the user with Level 2 user admin access rights see what the newly generated password is. ([#16](https://github.com/anodyne/nova/issues/16))
* Multi-author posts are now locked during editing to prevent users editing the same post at the same time. The lock is released after the user saves their changes or they've gone 5 minutes without making a change. (In the event a user has changed something and walked away, their changes will be saved to the post first.)
* Admins now have the option of showing the latest personal logs and mission posts on the main page. (Admins will be able to select any combination of news, logs and posts.)
* Admins now have the option of setting the top open positions (from Position Management) that will be shown at the top of each manifest (not manifest-specific).
* Added a rules page to the main section that can be updated from the Site Messages page.
* The instructions on the upload page now include the maximum file size and maximum image dimensions (pulled from the upload config file) for reference to anyone uploading images. ([#143](https://github.com/anodyne/nova/issues/143))
* The deck listing page now uses a table-less layout for a cleaner look.
* The deck listing page now has a menu of decks at the top of the page for quickly moving to a deck item without having to scroll. (We think RPGs with a lot of decks are going to love this!)
* Overhauled the user interface for mission groups to provide more information (and look a lot better too).
* When composing a mission post, the dropdown will now show who owns a linked NPC.
* When composing a mission post, personal log or private message, users only have to start typing a name and the options will be narrowed down for them. ([#23](https://github.com/anodyne/nova/issues/23))
* The skin catalogue now allows removing an entire skin (with sections) and letting admins choose which skin users will beupdated to for each section.
* The user account page now has options to make activating and deactivating users a lot easier.
    * When deactivating a user, all active characters associated with that account with also be deactivated.
    * When activating a user, admins will be prompted about which of the user's inactive characters should be reactivated.
* The character bio page now has options to make activating and deactivating characters a lot easier.
    * Activating an inactive character (and all related actions) can now be done with the push of a button.
    * Deactivating an active character (and all related actions) can now be done with the push of a button.
    * Making an NPC an active character (and all related actions) can now be done with the push of a button.
    * Making a character an NPC (and all related actions) can now be done with the push of a button.
* When viewing a character's posts, the entries will be paginated to help with load times and usability.
* When viewing a character's logs, the entries will be paginated to help with load times and usability.
* Site manifests can now store default view information so that different manifests can have different view settings. (This is now handled through Site Manifest management instead of Site Settings.) ([#157](https://github.com/anodyne/nova/issues/157))
* Gave the Pulsar skin a refreshed look and feel.
* Gave the Titan skin a refreshed look and feel. (If you're interested in changing the header image, please see Titan's README.md file for instructions.)
* The Writing Control Panel now shows a notification for any entires that have been commented on in the last 30 days (along with a link to the comments section of the entry).
* The manifest has been reorganized (for the first time ever) with a slightly different look.
* The email sent to the game master when a user applies now goes to anyone who can approve or reject character applications.
* Acceptance and rejection emails now CC in anyone who can approve or reject character applications.
* Users can now search within their sent and received private messages.
* Private messages have now been split in to separate inbox and sent message pages. This will help improve performance since the page doesn't have to load all the messages at once then split them off in to tabs.
* Private messages in the inbox and sent messages list are now paginated.
* The Reply to All link when reading a private message is only displayed if there's more than one recipient.
* The Reply, Reply to All and Forward options when reading a private message are now displayed above and below the private message.
* Users can now mark all unread private messages as read with a single click.
* An all-new redesigned character bio page provides a better, cleaner user experience.
* Moved to CodeIgniter 2.1 (was previously 1.7.3).
* Moved to a brand new file structure that further removes the Nova Core from any changes an admin might be making.
* Added __experimental__ module support.
* Updated to jQuery 1.7.1.
* Updated to jQuery UI 1.8.17.
* Updated to jQuery Uniform 1.7.5.
* Updated to jQuery prettyPhoto 3.1.3.
* Updated to markItUp! 1.1.12.
* Added the jQuery Chosen plugin.
* Added the Bootstrap by Twitter Twipsy plugin (version 1.4).
* Added the Bootstrap by Twitter Popover plugin (version 1.4).
* Removed the qTip plugin. (Please use the Bootstrap Twipsy plugin instead.)
* Changed the `banned.php` file to `message.php` that now contains notifications of Level 2 bans, a missing `nova` directory and incompatible PHP version information.
* Seamless substitution can now be used to override email view files from the `_base_override` directory.
* Added seaQuest DSV as a genre option. ([#144](https://github.com/anodyne/nova/issues/144))
* Changed the Location helper into a library with static methods (`Location::view` instead of `view_location`).
* Removed the RSS model. (It isn't necessary since most of the calls were duplicated in the appropriate post type models.)
* Added constants to the Access model for the default access roles.
* The Missions model now allows group missions to be pulled from `get_all_missions()`.
* The Missions model now has a method to count mission groups: `count_mission_groups()`.
* The Users model now has a method to pull all of a user's LOA records: `get_user_loa_records()`.
* The Auth library now uses static methods to be able to call quicker (`Auth::check_access()` instead of `auth->check_access()`).
* Nova will always check for the existence of the database config file. If the file isn't found, Nova will enter a new config setup wizard that will walk admins through setting up the config file, test the connection and then write the file for them.
* The SMS Upgrade process will now migrate SMS Database entries to the Thresher wiki page format.
* Completely re-wrote the upgrade process to not use config files (admins select the components they want upgraded through a user interface), to show more useful validation messages and be a shorter, more pleasant process (reduced the number of steps from 14 to 4).
* View files now check for the existence of the BASEPATH constant before rendering. On some servers, random `error_log` files are generated all over the place. A big part of this is view files that are accessed apart from the framework and generate PHP fatal errors. This fix should help eliminate those error log files.
* In preparation for future deprecation, we've removed all references to jQuery's `.live()` method. Third party developers should ensure their own code is updated as soon as possible to avoid any issues once the method is removed from the jQuery core.
* Changed the way users manage categories when creating and editing a wiki page. ([#137](https://github.com/anodyne/nova/issues/137))
* Users with the proper permissions can now create categories when creating and editing a wiki page. ([#64](https://github.com/anodyne/nova/issues/64))
* If there are no categories set in Thresher and the user has the proper permissions, they will be prompted to create some new categories when creating and editing a wiki page.
* Changed the user experience for managing wiki pages that puts more controls at the user's disposal and simplifies the entire page. ([#141](https://github.com/anodyne/nova/issues/141))
* Changed the user interface for viewing wiki pages to make it simpler.
* Users must have Level 1 wiki page access to see the page history now.
* Only users who are logged in can see comments on a wiki page.
* Added system pages to Thresher that allow some of the system pages to have their content changed like a normal wiki page. ([#123](https://github.com/anodyne/nova/issues/123))
* Users can now search Thresher from the main Thresher page.
* Fixed several bugs with the listing of Thresher search results.
* Removed the recently changed and recently updated listings from the main Thresher page.
* Users can now subscribe to an RSS feed for created wiki pages as well as updated wiki pages.
* Admins can now restrict access to a wiki page based on access role. ([#11](https://github.com/anodyne/nova/issues/11), [#12](https://github.com/anodyne/nova/issues/12))
* Seamless substitution of images wouldn't work when the images were in the `_base_override` directory.
* The `RE:` and `FWD:` tags would be added to private message subjects when replying and forwarding indefinitely until there was no space left for the actual subject line. Now, Nova will make sure it's only added once. ([#158](https://github.com/anodyne/nova/issues/158))
* When replying to a private message, the author of the message would be added to the recipient list, so any message they send would also show up in their inbox as well. (This behavior can be duplicated by manually adding themselves to the recipients list.)
* The join form could be submitted without an email address or password.
* Users who were deactivated kept their account flags (system administrator, game master, webmaster) and their access role. Now, all account flags and access roles are changed on deactivation.
* Users who were reactivated didn't have their access role set to Standard User.
* Inactive users were shown a link in the sub-navigation to upload an image even though they don't have permissions to upload images.
* A password could be reset for a user even if they don't have a security question chosen.
* Patched several potential security and access issues.
* Positions weren't properly updated when deleting an active character.
* Pulsar styling issues in Internet Explorer 9.
* Titan styling issues in Internet Explorer 9.
* When viewing character or user award, the 'Nominated By' line was shown even if there was no nomineed. (This is only an issue for RPGs who upgraded from SMS.)
* The Enterprise-era (ENT) genre install file had several issues and typos. ([#155](https://github.com/anodyne/nova/issues/155))
* The database automatically set a default rank for pending users potentially resulting in some confusion as to why a pending user already has a rank. ([#148](https://github.com/anodyne/nova/issues/148))
* If there is only one specification item, the list of items would be dispalyed instead of automatically sending the user to the only specification item. ([#146](https://github.com/anodyne/nova/issues/146))
* If there is only one specification item, the list of decks would be dispalyed instead of automatically sending the user to the only deck listing. ([#147](https://github.com/anodyne/nova/issues/147))
* During fresh installs, the user ID constraint wasn't consistent with the rest of the user ID fields throughout the system."
);

$system_info = array(
	'sys_last_update'		=> now(),
	'sys_version_major'		=> 2,
	'sys_version_minor'		=> 0,
	'sys_version_update'	=> 0
);

/*
|---------------------------------------------------------------
| TABLES TO ADD
|
| $add_tables = array(
|	'table_name' => array(
|		'id' => 'table_id',
|		'fields' => 'fields_table_name')
| );
|
| $fields_table_name = array(
|	'table_id' => array(
|		'type' => 'INT',
|		'constraint' => 6,
|		'auto_increment' => TRUE),
|	'table_field_1' => array(
|		'type' => 'VARCHAR',
|		'constraint' => 255,
|		'default' => ''),
|	'table_field_2' => array(
|		'type' => 'INT',
|		'constraint' => 4,
|		'default' => '99')
| );
|---------------------------------------------------------------
*/

$add_tables = array(
	'wiki_restrictions' => array(
		'id' => 'restr_id',
		'fields' => 'fields_wiki_restrictions'),
);

$fields_wiki_restrictions = array(
	'restr_id' => array(
		'type' => 'INT',
		'constraint' => 10,
		'auto_increment' => TRUE),
	'restr_page' => array(
		'type' => 'INT',
		'constraint' => 10),
	'restr_created_at' => array(
		'type' => 'BIGINT',
		'constraint' => 20),
	'restr_created_by' => array(
		'type' => 'INT',
		'constraint' => 8),
	'restr_updated_at' => array(
		'type' => 'BIGINT',
		'constraint' => 20),
	'restr_updated_by' => array(
		'type' => 'INT',
		'constraint' => 8),
	'restrictions' => array(
		'type' => 'TEXT'),
);

if ($add_tables !== null)
{
	foreach ($add_tables as $key => $value)
	{
		$this->dbforge->add_field($$value['fields']);
		$this->dbforge->add_key($value['id'], true);
		$this->dbforge->create_table($key, true);
	}
}

/*
|---------------------------------------------------------------
| TABLES TO DROP
|
| $drop_tables = array('table_name');
|---------------------------------------------------------------
*/

if ($drop_tables !== null)
{
	foreach ($drop_tables as $value)
	{
		$this->dbforge->drop_table($value);
	}
}

/*
|---------------------------------------------------------------
| TABLES TO RENAME
|
| $rename_tables = array('old_table_name' => 'new_table_name');
|---------------------------------------------------------------
*/

if ($rename_tables !== null)
{
	foreach ($rename_tables as $key => $value)
	{
		$this->dbforge->rename_table($key, $value);
	}
}

/*
|---------------------------------------------------------------
| COLUMNS TO ADD
|
| $add_column = array(
|	'table_name' => array(
|		'field_name_1' => array('type' => 'TEXT'),
|		'field_name_2' => array(
|			'type' => 'VARCHAR',
|			'constraint' => 100)
|	)
| );
|---------------------------------------------------------------
*/

$add_column = array(
	'wiki_pages' => array(
		'page_type' => array(
			'type' => 'ENUM',
			'constraint' => "'standard','system'",
			'default' => 'standard'),
		'page_key' => array(
			'type' => 'VARCHAR',
			'constraint' => 100,
			'default' => ''),
	),
	'posts' => array(
		'post_participants' => array(
			'type' => 'TEXT'),
		'post_lock_user' => array(
			'type' => 'INT',
			'constraint' => 8),
		'post_lock_date' => array(
			'type' => 'BIGINT',
			'constraint' => 20),
	),
	'mission_groups' => array(
		'misgroup_parent' => array(
			'type' => 'INT',
			'constraint' => 5,
			'default' => 0),
	),
	'manifests' => array(
		'manifest_view' => array(
			'type' => 'TEXT'),
	),
	'positions_'.GENRE => array(
		'pos_top_open' => array(
			'type' => 'ENUM',
			'constraint' => "'y','n'",
			'default' => 'n')
	),
);

if ($add_column !== null)
{
	foreach ($add_column as $key => $value)
	{
		$this->dbforge->add_column($key, $value);
	}
}

/*
|---------------------------------------------------------------
| COLUMNS TO MODIFY
|
| $modify_column = array(
|	'table_name' => array(
|		'old_field_name' => array(
|			'name' => 'new_field_name',
|			'type' => 'TEXT')
|	)
| );
|---------------------------------------------------------------
*/

$modify_column = array(
	'characters' => array(
		'rank' => array(
			'name' => 'rank',
			'type' => 'INT',
			'constraint' => 10,
			'default' => 0)
	),
	'sessions' => array(
		'user_agent' => array(
			'name' => 'user_agent',
			'type' => 'VARCHAR',
			'constraint' => 120,
			'default' => '')
	),
);

if ($modify_column !== null)
{
	foreach ($modify_column as $key => $value)
	{
		$this->dbforge->modify_column($key, $value);
	}
}

/*
|---------------------------------------------------------------
| COLUMNS TO DROP
|
| $drop_column = array(
|	'table_name' => array('field_name')
| );
|---------------------------------------------------------------
*/

if ($drop_column !== null)
{
	foreach ($drop_column as $key => $value)
	{
		$this->dbforge->drop_column($key, $value[0]);
	}
}

/**
 * Create the sessions index
 */
$sess_table = $this->db->dbprefix('sessions');
$this->db->query("CREATE INDEX last_activity_idx ON $sess_table(last_activity)");

/**
 * Add the new settings fields
 */
$this->db->insert('settings', array(
	'setting_key' => 'show_logs',
	'setting_value' => 'y',
	'setting_user_created' => 'n'
));
$this->db->insert('settings', array(
	'setting_key' => 'show_posts',
	'setting_value' => 'y',
	'setting_user_created' => 'n'
));

/**
 * Data to insert/update/delete
 */

// update the CI version info
$this->db->where('comp_name', 'CodeIgniter');
$this->db->update('system_components', array('comp_version' => '2.1.0'));

// update the lazy version info
$this->db->where('comp_name', 'Lazy');
$this->db->update('system_components', array('comp_version' => '1.5'));

// update the jquery version info
$this->db->where('comp_name', 'jQuery');
$this->db->update('system_components', array('comp_version' => '1.7.1'));

// update the jquery ui version info
$this->db->where('comp_name', 'jQuery UI');
$this->db->update('system_components', array('comp_version' => '1.8.17'));

// update the jquery prettyphoto info
$this->db->where('comp_name', 'prettyPhoto');
$this->db->update('system_components', array('comp_version' => '3.1.3'));

// update the markItUp! info
$this->db->where('comp_name', 'markItUp!');
$this->db->update('system_components', array('comp_version' => '1.1.12'));

// update the thresher info
$this->db->where('comp_name', 'Thresher');
$this->db->update('system_components', array('comp_version' => 'Release 2'));

// update the template library info
$this->db->where('comp_name', 'Template Library');
$this->db->update('system_components', array(
	'comp_version' => '',
	'comp_desc' => "Simple template engine designed by wiredesignz to work with Modular CI.",
	'comp_url' => 'http://codeigniter.com/forums/viewthread/67028/'
));

// remove the qTip plugin
$this->db->delete('system_components', array('comp_name' => 'qTip'));

// add the bootstrap component
$this->db->insert('system_components', array(
	'comp_name' => 'Bootstrap, from Twitter',
	'comp_version' => '1.4.0',
	'comp_desc' => "Bootstrap is a toolkit from Twitter designed to kickstart development of webapps and sites. It includes base CSS and HTML for typography, forms, buttons, tables, grids, navigation, and more.",
	'comp_url' => 'http://twitter.github.com/bootstrap/'
));

// update the upload images menu item
$this->db->where('menu_link', 'upload/index');
$this->db->update('menu_items', array('menu_use_access' => 'y', 'menu_access' => 'upload/index'));

// update the sent messages menu item
$this->db->where('menu_name', 'Sent Messages');
$this->db->update('menu_items', array('menu_link' => 'messages/sent'));

// add the chosen plugin to the list of components
$additem = array(
	'comp_name' => 'Chosen',
	'comp_version' => '',
	'comp_desc' => "Chosen is a JavaScript plugin that makes long, unwieldy select boxes much more user-friendly.",
	'comp_url' => 'http://harvesthq.github.com/chosen/'
);
$this->db->insert('system_components', $additem);

// add the use_post_participants setting
$additem = array(
	'setting_key' => 'use_post_participants',
	'setting_value' => 'y',
	'setting_user_created' => 'n'
);
$this->db->insert('settings', $additem);

// add the rules menu item
$menu = array(
	'menu_name' => 'Rules',
	'menu_group' => 0,
	'menu_order' => 10,
	'menu_link' => 'main/rules',
	'menu_sim_type' => 1,
	'menu_type' => 'sub',
	'menu_cat' => 'main'
);
$this->db->insert('menu_items', $menu);

// add the rules message
$msg = array(
	'message_key' => 'rules',
	'message_label' => 'Rules Message',
	'message_content' => "Define your sim's rules through the Site Messages page.",
	'message_type' => 'message'
);
$this->db->insert('messages', $msg);

// update the level 3 wiki page item
$this->db->where('page_url', 'wiki/page');
$this->db->where('page_level', 3);
$this->db->update('access_pages', array('page_desc' => "Can create, delete and edit all wiki pages (including system pages), including viewing history and reverting to previous drafts. Level 3 permissions can bypass all access restrictions on a wiki page."));

// move the manifest view setting into the manifests table
$manifests = $this->db->get('manifests');

if ($manifests->num_rows() > 0)
{
	$this->db->from('settings')->where('setting_key', 'manifest_defaults');
	$result = $this->db->get();
	$row = ($result->num_rows() > 0) ? $result->row() : false;
	$default_view = $row->setting_value;
	
	foreach ($manifests->result() as $m)
	{
		$this->db->update('manifests', array('manifest_view' => $default_view));
	}
}

/**
 * Thresher system pages.
 */
$data = array(
	array(
		'draft' => array(
			'draft_title' => 'Welcome to Thresher',
			'draft_author_user' => 0,
			'draft_author_character' => 0,
			'draft_summary' => "This is the main wiki system page.",
			'draft_content' => "<p>Welcome to Thresher R2. Thresher is Nova's built-in mini-wiki to help your RPG collaborate and share information easily. You can change this message by editing the system page from the Wiki Page Management page.</p>",
			'draft_created_at' => now()),
		'page' => array(
			'page_created_at' => now(),
			'page_created_by_user' => 0,
			'page_created_by_character' => 0,
			'page_comments' => 'closed',
			'page_type' => 'system',
			'page_key' => 'index'),
	),
	array(
		'draft' => array(
			'draft_title' => 'Create Wiki Page',
			'draft_author_user' => 0,
			'draft_author_character' => 0,
			'draft_summary' => "",
			'draft_content' => "",
			'draft_created_at' => now()),
		'page' => array(
			'page_created_at' => now(),
			'page_created_by_user' => 0,
			'page_created_by_character' => 0,
			'page_comments' => 'closed',
			'page_type' => 'system',
			'page_key' => 'create'),
	),
	array(
		'draft' => array(
			'draft_title' => 'Edit Wiki Page',
			'draft_author_user' => 0,
			'draft_author_character' => 0,
			'draft_summary' => "",
			'draft_content' => "",
			'draft_created_at' => now()),
		'page' => array(
			'page_created_at' => now(),
			'page_created_by_user' => 0,
			'page_created_by_character' => 0,
			'page_comments' => 'closed',
			'page_type' => 'system',
			'page_key' => 'edit'),
	),
	array(
		'draft' => array(
			'draft_title' => 'Wiki Categories',
			'draft_author_user' => 0,
			'draft_author_character' => 0,
			'draft_summary' => "Categories in Thresher allow pages to be broken up in to different subject matters and categorized in a way that makes sense. Below is the complete list of categories. Clicking on one of the categories will show all pages associated with that category.",
			'draft_content' => "",
			'draft_created_at' => now()),
		'page' => array(
			'page_created_at' => now(),
			'page_created_by_user' => 0,
			'page_created_by_character' => 0,
			'page_comments' => 'closed',
			'page_type' => 'system',
			'page_key' => 'categories'),
	),
	array(
		'draft' => array(
			'draft_title' => 'Wiki Category Page',
			'draft_author_user' => 0,
			'draft_author_character' => 0,
			'draft_summary' => "",
			'draft_content' => "",
			'draft_created_at' => now()),
		'page' => array(
			'page_created_at' => now(),
			'page_created_by_user' => 0,
			'page_created_by_character' => 0,
			'page_comments' => 'closed',
			'page_type' => 'system',
			'page_key' => 'category'),
	),
);

foreach ($data as $key => $value)
{
	// insert the draft
	$this->db->insert('wiki_drafts', $value['draft']);
	$draftID = $this->db->insert_id();
	
	// update the page record
	$value['page']['page_draft'] = $draftID;
	
	// insert the page
	$this->db->insert('wiki_pages', $value['page']);
	$pageID = $this->db->insert_id();
	
	// update the draft record
	$this->db->where('draft_id', $draftID);
	$this->db->update('wiki_drafts', array('draft_page' => $pageID));
}

/**
 * need to take in to account that some sims may have
 * more than one genre installed, so we need to do the
 * positions table update for all the genres so that
 * nova doesn't break in the even they change their genre
 */

// get all the tables
$tables = $this->db->list_tables();

// grab the db table prefix
$prefix = $this->db->dbprefix;

// count the characters in the prefix and add "positions_" to it
$prefixChars = strlen($prefix);
$totalChars = $prefixChars + 10;

foreach ($tables as $key => $value)
{
	if (substr($value, 0, $totalChars) == $prefix.'positions_' and $value != $prefix.'positions_'.GENRE)
	{
		// the key used for the add column array
		$t = 'positions_'.GENRE;
		
		// the table name minus the prefix
		$table = str_replace($prefix, '', $value);
		
		// add the column to all of the department tables
		$this->dbforge->add_column($table, $add_column[$t]);
	}
}
