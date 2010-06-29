<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Database Data
 *
 * @package		Install
 * @category	Assets
 * @author		Anodyne Productions
 */

/**
 * Data array with the table/array names used
 */
$data = array(
	'access_groups',
	'access_pages',
	'access_roles',
	'catalogue_skins',
	'catalogue_skinsecs',
	'forms',
	'forms_fields',
	'forms_sections',
	'forms_tabs',
	'forms_values',
	'menu_categories',
	'menu_items',
	'messages',
	'news_categories',
	'user_prefs',
	'security_questions',
	'settings',
	'sim_type',
	'system_components',
	'system_info',
	'system_versions',
);

/**
 * Arrays of data with the information being inserted into the database
 */
$access_groups = array(
	array(
		'group_name' => 'General Admin',
		'group_order' => 0),
	array(
		'group_name' => 'Writing Features',
		'group_order' => 1),
	array(
		'group_name' => 'Site Management',
		'group_order' => 2),
	array(
		'group_name' => 'Data Management',
		'group_order' => 3),
	array(
		'group_name' => 'Reports',
		'group_order' => 4),
	array(
		'group_name' => 'Characters',
		'group_order' => 5),
	array(
		'group_name' => 'Users',
		'group_order' => 6),
	array(
		'group_name' => 'Wiki',
		'group_order' => 7),
);

$access_roles = array(
	array(
		'role_name' => 'System Administrator',
		'role_access' => '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,31,33,35,36,37,38,39,40,41,42,43,44,45,46,49,50,53,55,56,58,60,63,64',
		'role_desc' => 'System administrators can take any action in the system. Only give this access level out to people you implicitly trust.'),
	array(
		'role_name' => 'Basic Administrator',
		'role_access' => '1,2,3,4,5,6,7,8,20,21,22,27,31,33,35,37,39,40,41,42,43,44,45,46,49,53,54,58,59,63,64',
		'role_desc' => 'Basic administrators have power to do some of the tasks system administrators do, but with more restrictions. This role is intended to be used senior players on the RPG.'),
	array(
		'role_name' => 'Power User',
		'role_access' => '1,2,4,5,6,7,8,30,32,34,39,40,42,45,48,52,54,57,59,62',
		'role_desc' => 'Power users are users that can take more action than a standard user. This role is intended to be used for senior players on the RPG (department heads for example).'),
	array(
		'role_name' => 'Standard User',
		'role_access' => '1,2,4,5,6,7,8,30,32,34,39,40,42,45,51,54,57,59,61',
		'role_desc' => 'Standard users are generally the majority of players. This role gives them access to all the pieces they will need to play the game and use the system.'),
	array(
		'role_name' => 'Inactive User',
		'role_access' => '1,4,45,51,54,57',
		'role_desc' => 'Inactive players are players that have left the RPG. Instead of being completely locked out, the player can log in and take some very limited actions.')
);

$access_pages = array(
	array(
		'page_name' => "Admin Control Panel",
		'page_url' => 'admin/index',
		'page_group' => 1,
		'page_desc' => "Can access the admin control panel with recent posts, stats and other information"),
	array(
		'page_name' => "Upload Images",
		'page_url' => 'upload/index',
		'page_group' => 1,
		'page_desc' => "Can upload images to the server"),
	array(
		'page_name' => "Manage Uploads",
		'page_url' => 'upload/manage',
		'page_group' => 1,
		'page_desc' => "Can delete upload records"),
		
	array(
		'page_name' => "Private Messages",
		'page_url' => 'messages/index',
		'page_group' => 2,
		'page_desc' => "Can send and receive private messages"),
	array(
		'page_name' => "Writing Control Panel",
		'page_url' => 'write/index',
		'page_group' => 2,
		'page_desc' => "Can access the writing control panel with saved entries and recent posts"),
	array(
		'page_name' => "Write Mission Post",
		'page_url' => 'write/missionpost',
		'page_group' => 2,
		'page_desc' => "Can post a mission entry to the system"),
	array(
		'page_name' => "Write Personal Log",
		'page_url' => 'write/personallog',
		'page_group' => 2,
		'page_desc' => "Can post a personal log to the system"),
	array(
		'page_name' => "Write News Item",
		'page_url' => 'write/newsitem',
		'page_group' => 2,
		'page_desc' => "Can post a news items to the system"),
		
	array(
		'page_name' => "Site Settings",
		'page_url' => 'site/settings',
		'page_group' => 3,
		'page_desc' => "Can add, delete or edit any of the system settings"),
	array(
		'page_name' => "Site Messages",
		'page_url' => 'site/messages',
		'page_group' => 3,
		'page_desc' => "Can add, delete or edit any of the site messages for the system"),
	array(
		'page_name' => "Role Access",
		'page_url' => 'site/roles',
		'page_group' => 3,
		'page_desc' => "Can add, delete or edit access roles including access page sections and access pages"),
	array(
		'page_name' => "Bio/Join Form",
		'page_url' => 'site/bioform',
		'page_group' => 3,
		'page_desc' => "Can add to, edit or remove from the dynamic bio form including bio tabs and bio sections"),
	array(
		'page_name' => "Specs Form",
		'page_url' => 'site/specsform',
		'page_group' => 3,
		'page_desc' => "Can add to, edit or remove from the dynamic specifications form including specs sections"),
	array(
		'page_name' => "Tour Form",
		'page_url' => 'site/tourform',
		'page_group' => 3,
		'page_desc' => "Can add to, edit or remove from the dynamic tour form"),
	array(
		'page_name' => "Docking Form",
		'page_url' => 'site/dockingform',
		'page_group' => 3,
		'page_desc' => "Can add to, edit or remove from the dynamic docking form"),
	array(
		'page_name' => "Menus",
		'page_url' => 'site/menus',
		'page_group' => 3,
		'page_desc' => "Can add, delete and edit system menus"),
	array(
		'page_name' => "System Catalogue - Ranks",
		'page_url' => 'site/catalogueranks',
		'page_group' => 3,
		'page_desc' => "Can add, delete and edit system ranks"),
	array(
		'page_name' => "System Catalogue - Skins",
		'page_url' => 'site/catalogueskins',
		'page_group' => 3,
		'page_desc' => "Can add, delete and edit system skins"),
	array(
		'page_name' => "Manage Sim Types",
		'page_url' => 'site/simtypes',
		'page_group' => 3,
		'page_desc' => "Can add, delete and edit the different sim types"),
		
	array(
		'page_name' => "Specs",
		'page_url' => 'manage/specs',
		'page_group' => 4,
		'page_desc' => "Can update the specifications"),
	array(
		'page_name' => "Deck Listing",
		'page_url' => 'manage/decks',
		'page_group' => 4,
		'page_desc' => "Can add to, edit or remove from the deck listing"),
	array(
		'page_name' => "Manage Comments",
		'page_url' => 'manage/comments',
		'page_group' => 4,
		'page_desc' => "Can approve, delete and edit any comments"),
	array(
		'page_name' => "Manage Positions",
		'page_url' => 'manage/positions',
		'page_group' => 4,
		'page_desc' => "Can add, delete and edit positions"),
	array(
		'page_name' => "Manage Departments",
		'page_url' => 'manage/depts',
		'page_group' => 4,
		'page_desc' => "Can add, delete and edit departments"),
	array(
		'page_name' => "Manage Ranks",
		'page_url' => 'manage/ranks',
		'page_group' => 4,
		'page_desc' => "Can add, delete and edit ranks"),
	array(
		'page_name' => "Manage Awards",
		'page_url' => 'manage/awards',
		'page_group' => 4,
		'page_desc' => "Can add, delete and edit awards"),
	array(
		'page_name' => "Manage Tour Items",
		'page_url' => 'manage/tour',
		'page_group' => 4,
		'page_desc' => "Can add, delete and edit tour items"),
	array(
		'page_name' => "Manage Docked Items",
		'page_url' => 'manage/docked',
		'page_group' => 4,
		'page_desc' => "Can add, approve, delete, edit and reject docked items"),
	array(
		'page_name' => "Manage Missions",
		'page_url' => 'manage/missions',
		'page_group' => 4,
		'page_desc' => "Can add, delete and edit missions"),
	array(
		'page_name' => "Manage Mission Posts (Level 1)",
		'page_url' => 'manage/posts',
		'page_level' => 1,
		'page_group' => 4,
		'page_desc' => "Can delete and edit any of their own mission posts"),
	array(
		'page_name' => "Manage Mission Posts (Level 2)",
		'page_url' => 'manage/posts',
		'page_level' => 2,
		'page_group' => 4,
		'page_desc' => "Can delete and edit all mission posts in the system"),
	array(
		'page_name' => "Manage Personal Logs (Level 1)",
		'page_url' => 'manage/logs',
		'page_level' => 1,
		'page_group' => 4,
		'page_desc' => "Can delete and edit any of their own personal logs"),
	array(
		'page_name' => "Manage Personal Logs (Level 2)",
		'page_url' => 'manage/logs',
		'page_level' => 2,
		'page_group' => 4,
		'page_desc' => "Can delete and edit all personal logs in the system"),
	array(
		'page_name' => "Manage News Items (Level 1)",
		'page_url' => 'manage/news',
		'page_level' => 1,
		'page_group' => 4,
		'page_desc' => "Can delete and edit any of their own news items"),
	array(
		'page_name' => "Manage News Items (Level 2)",
		'page_url' => 'manage/news',
		'page_level' => 2,
		'page_group' => 4,
		'page_desc' => "Can delete and edit all news items in the system"),
	array(
		'page_name' => "Manage News Categories",
		'page_url' => 'manage/newscats',
		'page_group' => 4,
		'page_desc' => "Can manage all news categories available for news items"),
		
	array(
		'page_name' => "LOA Report",
		'page_url' => 'report/loa',
		'page_group' => 5,
		'page_desc' => "Can view a report on LOAs taken over the life of the system"),
	array(
		'page_name' => "System &amp; Versions",
		'page_url' => 'report/versions',
		'page_group' => 5,
		'page_desc' => "Can view a report on system information and all previous versions of the system"),
	array(
		'page_name' => "Crew Activity",
		'page_url' => 'report/activity',
		'page_group' => 5,
		'page_desc' => "Can view a report on active crew's activity levels"),
	array(
		'page_name' => "Posting Levels",
		'page_url' => 'report/posting',
		'page_group' => 5,
		'page_desc' => "Can view a report on posting levels for all playing characters"),
	array(
		'page_name' => "Moderation",
		'page_url' => 'report/moderation',
		'page_group' => 5,
		'page_desc' => "Can view a report on the moderation status of users"),
	array(
		'page_name' => "Milestones",
		'page_url' => 'report/milestones',
		'page_group' => 5,
		'page_desc' => "Can view a report on the milestones of users"),
	array(
		'page_name' => "Award Nominations",
		'page_url' => 'report/awardnominations',
		'page_group' => 5,
		'page_desc' => "Can view a report on all award nominations"),
	array(
		'page_name' => "Applications",
		'page_url' => 'report/applications',
		'page_group' => 5,
		'page_desc' => "Can view a report on all applications submitted through the system"),
	array(
		'page_name' => "Sim Statistics",
		'page_url' => 'report/stats',
		'page_group' => 5,
		'page_desc' => "Can view a report on sim statistics for the current and previous months"),
		
	array(
		'page_name' => "Character Management",
		'page_url' => 'characters/index',
		'page_group' => 6,
		'page_desc' => "Can manage all playing characters including accepting and rejecting applicants"),
	array(
		'page_name' => "NPC Management (Level 1)",
		'page_url' => 'characters/npcs',
		'page_level' => 1,
		'page_group' => 6,
		'page_desc' => "Can manage any non-playing characters in their primary department (first position only)"),
	array(
		'page_name' => "NPC Management (Level 2)",
		'page_url' => 'characters/npcs',
		'page_level' => 2,
		'page_group' => 6,
		'page_desc' => "Can manage any non-playing characters in any of their departments (first and second positions)"),
	array(
		'page_name' => "NPC Management (Level 3)",
		'page_url' => 'characters/npcs',
		'page_level' => 3,
		'page_group' => 6,
		'page_desc' => "Can manage all non-playing characters in the system"),
	array(
		'page_name' => "Chain of Command",
		'page_url' => 'characters/coc',
		'page_group' => 6,
		'page_desc' => "Can add, delete and edit the chain of command"),
	array(
		'page_name' => "Character Bio (Level 1)",
		'page_url' => 'characters/bio',
		'page_level' => 1,
		'page_group' => 6,
		'page_desc' => "Can edit the bio of any of their own characters"),
	array(
		'page_name' => "Character Bio (Level 2)",
		'page_url' => 'characters/bio',
		'page_level' => 2,
		'page_group' => 6,
		'page_desc' => "Can edit the bio of any of their characters as well as any NPC in the system"),
	array(
		'page_name' => "Character Bio (Level 3)",
		'page_url' => 'characters/bio',
		'page_level' => 3,
		'page_group' => 6,
		'page_desc' => "Can edit any character in the system, including rank and position"),
	array(
		'page_name' => "Create Character (Level 1)",
		'page_url' => 'characters/create',
		'page_level' => 1,
		'page_group' => 6,
		'page_desc' => "Can create playing and non-playing characters but playing characters require approval"),
	array(
		'page_name' => "Create Character (Level 2)",
		'page_url' => 'characters/create',
		'page_level' => 2,
		'page_group' => 6,
		'page_desc' => "Can create playing and non-playing characters without any approval"),
	array(
		'page_name' => "Give/Remove Award",
		'page_url' => 'characters/awards',
		'page_group' => 6,
		'page_desc' => "Can give/remove awards to/from any character in the system"),
	
	array(
		'page_name' => "User Account (Level 1)",
		'page_url' => 'user/account',
		'page_group' => 7,
		'page_level' => 1,
		'page_desc' => "Can update their own account settings"),
	array(
		'page_name' => "User Account (Level 2)",
		'page_url' => 'user/account',
		'page_group' => 7,
		'page_level' => 2,
		'page_desc' => "Can update any account in the system including moderation flags and admin items"),
	array(
		'page_name' => "Crew Award Nominations (Level 1)",
		'page_url' => 'user/nominate',
		'page_group' => 7,
		'page_level' => 1,
		'page_desc' => "Can nominate playing and non-playing characters for awards"),
	array(
		'page_name' => "Crew Award Nominations (Level 2)",
		'page_url' => 'user/nominate',
		'page_group' => 7,
		'page_level' => 2,
		'page_desc' => "Can nominate playing and non-playing characters for awards as well as approving/rejecting pending award nominations"),
		
	array(
		'page_name' => "Wiki Pages (Level 1)",
		'page_url' => 'wiki/page',
		'page_group' => 8,
		'page_level' => 1,
		'page_desc' => "Can create wiki pages and edit any pages they have created, including viewing history and reverting to previous drafts"),
	array(
		'page_name' => "Wiki Pages (Level 2)",
		'page_url' => 'wiki/page',
		'page_group' => 8,
		'page_level' => 2,
		'page_desc' => "Can create wiki pages and edit all pages, including viewing history and reverting to previous drafts"),
	array(
		'page_name' => "Wiki Pages (Level 3)",
		'page_url' => 'wiki/page',
		'page_group' => 8,
		'page_level' => 3,
		'page_desc' => "Can create, delete and edit all wiki pages, including viewing history and reverting to previous drafts"),
	array(
		'page_name' => "Wiki Categories",
		'page_url' => 'wiki/categories',
		'page_group' => 8,
		'page_desc' => "Can create, delete and edit wiki categories"),
);

$catalogue_skins = array(
	array(
		'skin_name' => 'Pulsar',
		'skin_location' => 'default',
		'skin_credits' => 'The Pulsar skin was created by Anodyne Productions. Edits are permissible as long as original credits stay intact. The Pulsar skin includes the jQuery BlockUI plugin by Malsup. More information can be found at <a href="http://malsup.com/jquery/block/">http://malsup.com/jquery/block/</a>.'),
);

$catalogue_skinsecs = array(
	array(
		'skinsec_section' => 'main',
		'skinsec_skin' => 'default',
		'skinsec_image_preview' => 'preview-main.jpg',
		'skinsec_default' => 'y'),
	array(
		'skinsec_section' => 'admin',
		'skinsec_skin' => 'default',
		'skinsec_image_preview' => 'preview-admin.jpg',
		'skinsec_default' => 'y'),
	array(
		'skinsec_section' => 'wiki',
		'skinsec_skin' => 'default',
		'skinsec_image_preview' => 'preview-wiki.jpg',
		'skinsec_default' => 'y'),
	array(
		'skinsec_section' => 'login',
		'skinsec_skin' => 'default',
		'skinsec_image_preview' => 'preview-login.jpg',
		'skinsec_default' => 'y'),
);

$forms = array(
	array(
		'form_key' => 'bio',
		'form_name' => 'Bio/Join Form'),
	array(
		'form_key' => 'specs',
		'form_name' => 'Specifications Form'),
	array(
		'form_key' => 'tour',
		'form_name' => 'Tour Form'),
	array(
		'form_key' => 'docking',
		'form_name' => 'Docking Form'),
	array(
		'form_key' => 'user',
		'form_name' => 'User Information'),
);

$forms_fields = array(
	array(
		'field_form' => 'bio',
		'field_section' => 1,
		'field_type' => 'select',
		'field_html_name' => 'gender',
		'field_html_id' => 'gender',
		'field_html_rows' => 0,
		'field_label' => 'Gender',
		'field_order' => 1),
	array(
		'field_form' => 'bio',
		'field_section' => 1,
		'field_type' => 'text',
		'field_html_name' => 'species',
		'field_html_id' => 'species',
		'field_html_rows' => 0,
		'field_label' => 'Species',
		'field_placeholder' => 'e.g. Human',
		'field_order' => 2),
	array(
		'field_form' => 'bio',
		'field_section' => 1,
		'field_type' => 'text',
		'field_html_name' => 'age',
		'field_html_id' => 'age',
		'field_html_rows' => 0,
		'field_html_class' => 'small',
		'field_label' => 'Age',
		'field_placeholder' => 'Age',
		'field_order' => 3),
	array(
		'field_form' => 'bio',
		'field_section' => 2,
		'field_type' => 'text',
		'field_html_name' => 'height',
		'field_html_id' => 'height',
		'field_html_rows' => 0,
		'field_html_class' => 'medium',
		'field_label' => 'Height',
		'field_placeholder' => 'e.g. 6\'2"',
		'field_order' => 1),
	array(
		'field_form' => 'bio',
		'field_section' => 2,
		'field_type' => 'text',
		'field_html_name' => 'weight',
		'field_html_id' => 'weight',
		'field_html_rows' => 0,
		'field_html_class' => 'medium',
		'field_label' => 'Weight',
		'field_placeholder' => 'e.g. 215 lbs.',
		'field_order' => 2),
	array(
		'field_form' => 'bio',
		'field_section' => 2,
		'field_type' => 'text',
		'field_html_name' => 'hair_color',
		'field_html_id' => 'hair_color',
		'field_html_rows' => 0,
		'field_label' => 'Hair Color',
		'field_placeholder' => 'Hair Color',
		'field_order' => 3),
	array(
		'field_form' => 'bio',
		'field_section' => 2,
		'field_type' => 'text',
		'field_html_name' => 'eye_color',
		'field_html_id' => 'eye_color',
		'field_html_rows' => 0,
		'field_label' => 'Eye Color',
		'field_placeholder' => 'Eye Color',
		'field_order' => 4),
	array(
		'field_form' => 'bio',
		'field_section' => 2,
		'field_type' => 'textarea',
		'field_html_name' => 'physical_desc',
		'field_html_id' => 'physical_desc',
		'field_html_rows' => 3,
		'field_label' => 'Physical Description',
		'field_placeholder' => 'Enter your physical description here',
		'field_order' => 5),
	array(
		'field_form' => 'bio',
		'field_section' => 3,
		'field_type' => 'text',
		'field_html_name' => 'spouse',
		'field_html_id' => 'spouse',
		'field_html_rows' => 0,
		'field_label' => 'Spouse',
		'field_placeholder' => 'Spouse',
		'field_order' => 1),
	array(
		'field_form' => 'bio',
		'field_section' => 3,
		'field_type' => 'textarea',
		'field_html_name' => 'children',
		'field_html_id' => 'children',
		'field_html_rows' => 3,
		'field_label' => 'Children',
		'field_placeholder' => 'Enter your character\'s children here',
		'field_order' => 2),
	array(
		'field_form' => 'bio',
		'field_section' => 3,
		'field_type' => 'text',
		'field_html_name' => 'father',
		'field_html_id' => 'father',
		'field_html_rows' => 0,
		'field_label' => 'Father',
		'field_placeholder' => 'Father',
		'field_order' => 3),
	array(
		'field_form' => 'bio',
		'field_section' => 3,
		'field_type' => 'text',
		'field_html_name' => 'mother',
		'field_html_id' => 'mother',
		'field_html_rows' => 0,
		'field_label' => 'Mother',
		'field_placeholder' => 'Mother',
		'field_order' => 4),
	array(
		'field_form' => 'bio',
		'field_section' => 3,
		'field_type' => 'textarea',
		'field_html_name' => 'siblings',
		'field_html_id' => 'siblings',
		'field_html_rows' => 3,
		'field_label' => 'Siblings',
		'field_placeholder' => 'Enter your character\'s siblings here',
		'field_order' => 5),
	array(
		'field_form' => 'bio',
		'field_section' => 3,
		'field_type' => 'text',
		'field_html_name' => 'other_family',
		'field_html_id' => 'other_family',
		'field_html_rows' => 3,
		'field_label' => 'Other Family',
		'field_placeholder' => 'Enter your character\'s other family here',
		'field_order' => 6),
	array(
		'field_form' => 'bio',
		'field_section' => 4,
		'field_type' => 'textarea',
		'field_html_name' => 'personality',
		'field_html_id' => 'personality',
		'field_html_rows' => 5,
		'field_label' => 'General Overview',
		'field_placeholder' => 'Enter your character\'s general personality overview here',
		'field_order' => 1),
	array(
		'field_form' => 'bio',
		'field_section' => 4,
		'field_type' => 'textarea',
		'field_html_name' => 'strengths',
		'field_html_id' => 'strengths',
		'field_html_rows' => 5,
		'field_label' => 'Strengths &amp; Weaknesses',
		'field_placeholder' => 'Enter your character\'s strengths and weaknesses here',
		'field_order' => 2),
	array(
		'field_form' => 'bio',
		'field_section' => 4,
		'field_type' => 'textarea',
		'field_html_name' => 'ambitions',
		'field_html_id' => 'ambitions',
		'field_html_rows' => 5,
		'field_label' => 'Ambitions',
		'field_placeholder' => 'Enter your character\'s ambitions here',
		'field_order' => 3),
	array(
		'field_form' => 'bio',
		'field_section' => 4,
		'field_type' => 'textarea',
		'field_html_name' => 'hobbies',
		'field_html_id' => 'hobbies',
		'field_html_rows' => 5,
		'field_label' => 'Hobbies &amp; Interests',
		'field_placeholder' => 'Enter your character\'s hobbies and interests here',
		'field_order' => 4),
	array(
		'field_form' => 'bio',
		'field_section' => 5,
		'field_type' => 'textarea',
		'field_html_name' => 'history',
		'field_html_id' => 'history',
		'field_html_rows' => 15,
		'field_label' => 'History',
		'field_placeholder' => 'Enter your character\'s personal history here',
		'field_order' => 1),
	array(
		'field_form' => 'bio',
		'field_section' => 5,
		'field_type' => 'textarea',
		'field_html_name' => 'service_record',
		'field_html_id' => 'service_record',
		'field_html_rows' => 15,
		'field_label' => 'Service Record',
		'field_placeholder' => 'Enter your character\'s service record here',
		'field_order' => 2),
	array(
		'field_form' => 'docking',
		'field_section' => 6,
		'field_type' => 'text',
		'field_html_name' => 'duration',
		'field_html_id' => 'duration',
		'field_html_rows' => 0,
		'field_label' => 'Duration',
		'field_placeholder' => 'Enter the duration of your stay',
		'field_order' => 1),
	array(
		'field_form' => 'docking',
		'field_section' => 6,
		'field_type' => 'textarea',
		'field_html_name' => 'reason',
		'field_html_id' => 'reason',
		'field_html_rows' => 5,
		'field_label' => 'Reason for Docking',
		'field_placeholder' => 'Enter your reason for docking here',
		'field_order' => 2),
	array(
		'field_form' => 'specs',
		'field_section' => 7,
		'field_type' => 'text',
		'field_html_name' => 'class',
		'field_html_id' => 'class',
		'field_html_rows' => 0,
		'field_label' => 'Class',
		'field_placeholder' => 'Enter the class of vessel',
		'field_order' => 0),
	array(
		'field_form' => 'specs',
		'field_section' => 7,
		'field_type' => 'text',
		'field_html_name' => 'role',
		'field_html_id' => 'role',
		'field_html_rows' => 0,
		'field_label' => 'Role',
		'field_placeholder' => 'Enter the role of the vessel',
		'field_order' => 1),
	array(
		'field_form' => 'specs',
		'field_section' => 7,
		'field_type' => 'text',
		'field_html_name' => 'duration',
		'field_html_id' => 'duration',
		'field_html_rows' => 0,
		'field_label' => 'Duration',
		'field_placeholder' => 'Enter the duration of the vessel',
		'field_order' => 2),
	array(
		'field_form' => 'specs',
		'field_section' => 7,
		'field_type' => 'text',
		'field_html_name' => 'refit',
		'field_html_id' => 'refit',
		'field_html_rows' => 0,
		'field_label' => 'Time Between Refits',
		'field_placeholder' => 'Enter the time between refits for this vessel',
		'field_order' => 3),
	array(
		'field_form' => 'specs',
		'field_section' => 7,
		'field_type' => 'text',
		'field_html_name' => 'resupply',
		'field_html_id' => 'resupply',
		'field_html_rows' => 0,
		'field_label' => 'Time Between Resupply',
		'field_placeholder' => 'Enter the time between resupply of this vessel',
		'field_order' => 0),
	array(
		'field_form' => 'specs',
		'field_section' => 8,
		'field_type' => 'text',
		'field_html_name' => 'length',
		'field_html_id' => 'length',
		'field_html_rows' => 0,
		'field_label' => 'Length',
		'field_placeholder' => 'e.g. 415 meters',
		'field_order' => 0),
	array(
		'field_form' => 'specs',
		'field_section' => 8,
		'field_type' => 'text',
		'field_html_name' => 'width',
		'field_html_id' => 'width',
		'field_html_rows' => 0,
		'field_label' => 'Width',
		'field_placeholder' => 'e.g. 75 meters',
		'field_order' => 1),
	array(
		'field_form' => 'specs',
		'field_section' => 8,
		'field_type' => 'text',
		'field_html_name' => 'height',
		'field_html_id' => 'height',
		'field_html_rows' => 0,
		'field_label' => 'Height',
		'field_placeholder' => 'e.g. 45 meters',
		'field_order' => 2),
	array(
		'field_form' => 'specs',
		'field_section' => 8,
		'field_type' => 'text',
		'field_html_name' => 'decks',
		'field_html_id' => 'decks',
		'field_html_rows' => 0,
		'field_html_class' => 'medium',
		'field_label' => 'Decks',
		'field_placeholder' => 'e.g. 10',
		'field_order' => 3),
	array(
		'field_form' => 'specs',
		'field_section' => 9,
		'field_type' => 'text',
		'field_html_name' => 'compliment_officers',
		'field_html_id' => 'compliment_officers',
		'field_html_rows' => 0,
		'field_html_class' => 'medium',
		'field_label' => 'Officers',
		'field_placeholder' => 'e.g. 60',
		'field_order' => 0),
	array(
		'field_form' => 'specs',
		'field_section' => 9,
		'field_type' => 'text',
		'field_html_name' => 'compliment_enlisted',
		'field_html_id' => 'compliment_enlisted',
		'field_html_rows' => 0,
		'field_html_class' => 'medium',
		'field_label' => 'Enlisted Crew',
		'field_placeholder' => 'e.g. 500',
		'field_order' => 1),
	array(
		'field_form' => 'specs',
		'field_section' => 9,
		'field_type' => 'text',
		'field_html_name' => 'compliment_marines',
		'field_html_id' => 'compliment_marines',
		'field_html_rows' => 0,
		'field_html_class' => 'medium',
		'field_label' => 'Marines',
		'field_placeholder' => 'e.g. 48',
		'field_order' => 2),
	array(
		'field_form' => 'specs',
		'field_section' => 9,
		'field_type' => 'text',
		'field_html_name' => 'compliment_civilians',
		'field_html_id' => 'compliment_civilians',
		'field_html_rows' => 0,
		'field_html_class' => 'medium',
		'field_label' => 'Civilians',
		'field_placeholder' => 'e.g. 200',
		'field_order' => 3),
	array(
		'field_form' => 'specs',
		'field_section' => 9,
		'field_type' => 'text',
		'field_html_name' => 'compliment_emergency',
		'field_html_id' => 'compliment_emergency',
		'field_html_rows' => 0,
		'field_html_class' => 'medium',
		'field_label' => 'Emergency Capacity',
		'field_placeholder' => 'e.g. 2000',
		'field_order' => 4),
	array(
		'field_form' => 'specs',
		'field_section' => 10,
		'field_type' => 'text',
		'field_html_name' => 'speed_normal',
		'field_html_id' => 'speed_normal',
		'field_html_rows' => 0,
		'field_html_class' => 'medium',
		'field_label' => 'Cruise Speed',
		'field_placeholder' => 'e.g. Warp 6',
		'field_order' => 0),
	array(
		'field_form' => 'specs',
		'field_section' => 10,
		'field_type' => 'text',
		'field_html_name' => 'speed_max',
		'field_html_id' => 'speed_max',
		'field_html_rows' => 0,
		'field_html_class' => 'medium',
		'field_label' => 'Maximum Speed',
		'field_placeholder' => 'e.g. Warp 9',
		'field_order' => 1),
	array(
		'field_form' => 'specs',
		'field_section' => 10,
		'field_type' => 'text',
		'field_html_name' => 'speed_emergency',
		'field_html_id' => 'speed_emergency',
		'field_html_rows' => 0,
		'field_html_class' => 'medium',
		'field_label' => 'Emergency Speed',
		'field_placeholder' => 'e.g. Warp 9.9975',
		'field_order' => 2),
	array(
		'field_form' => 'specs',
		'field_section' => 11,
		'field_type' => 'textarea',
		'field_html_name' => 'defensive',
		'field_html_id' => 'defensive',
		'field_html_rows' => 5,
		'field_label' => 'Shields',
		'field_placeholder' => 'e.g. Enter your vessel\'s defensive systems here',
		'field_order' => 0),
	array(
		'field_form' => 'specs',
		'field_section' => 11,
		'field_type' => 'textarea',
		'field_html_name' => 'weapons',
		'field_html_id' => 'weapons',
		'field_html_rows' => 5,
		'field_label' => 'Weapon Systems',
		'field_placeholder' => 'e.g. Enter your vessel\'s weapon systems here',
		'field_order' => 1),
	array(
		'field_form' => 'specs',
		'field_section' => 11,
		'field_type' => 'textarea',
		'field_html_name' => 'armament',
		'field_html_id' => 'armament',
		'field_html_rows' => 5,
		'field_label' => 'Armament',
		'field_placeholder' => 'e.g. Enter your vessel\'s armament here',
		'field_order' => 2),
	array(
		'field_form' => 'specs',
		'field_section' => 12,
		'field_type' => 'text',
		'field_html_name' => 'shuttlebays',
		'field_html_id' => 'shuttlebays',
		'field_html_rows' => 0,
		'field_html_class' => 'small',
		'field_label' => 'Shuttlebays',
		'field_order' => 0),
	array(
		'field_form' => 'specs',
		'field_section' => 12,
		'field_type' => 'textarea',
		'field_html_name' => 'shuttles',
		'field_html_id' => 'shuttles',
		'field_html_rows' => 5,
		'field_label' => 'Shuttles',
		'field_placeholder' => 'Enter your vessel\'s shuttles here',
		'field_order' => 1),
	array(
		'field_form' => 'specs',
		'field_section' => 12,
		'field_type' => 'textarea',
		'field_html_name' => 'fighters',
		'field_html_id' => 'fighters',
		'field_html_rows' => 5,
		'field_label' => 'Fighters',
		'field_placeholder' => 'Enter your vessel\'s fighters here',
		'field_order' => 2),
	array(
		'field_form' => 'specs',
		'field_section' => 12,
		'field_type' => 'textarea',
		'field_html_name' => 'runabouts',
		'field_html_id' => 'runabouts',
		'field_html_rows' => 5,
		'field_label' => 'Runabouts',
		'field_placeholder' => 'Enter your vessel\'s runabouts here',
		'field_order' => 3),
	array(
		'field_form' => 'tour',
		'field_type' => 'text',
		'field_html_name' => 'location',
		'field_html_id' => 'location',
		'field_html_rows' => 0,
		'field_label' => 'Location',
		'field_placeholder' => 'Enter the tour item\'s location here',
		'field_order' => 0),
	array(
		'field_form' => 'tour',
		'field_type' => 'textarea',
		'field_html_name' => 'long_desc',
		'field_html_id' => 'long_desc',
		'field_html_rows' => 5,
		'field_label' => 'Description',
		'field_placeholder' => 'Enter the tour item\'s description here',
		'field_order' => 1),
	array(
		'field_form' => 'user',
		'field_type' => 'text',
		'field_html_name' => 'location',
		'field_html_id' => 'location',
		'field_html_rows' => 0,
		'field_label' => 'Location',
		'field_placeholder' => 'Enter your location here',
		'field_order' => 0),
	array(
		'field_form' => 'user',
		'field_type' => 'textarea',
		'field_html_name' => 'interests',
		'field_html_id' => 'interests',
		'field_html_rows' => 5,
		'field_label' => 'Interests',
		'field_placeholder' => 'Enter your interests here',
		'field_order' => 1),
	array(
		'field_form' => 'user',
		'field_type' => 'textarea',
		'field_html_name' => 'bio',
		'field_html_id' => 'bio',
		'field_html_rows' => 5,
		'field_label' => 'Bio',
		'field_placeholder' => 'Enter your bio information here',
		'field_order' => 2),
);

$forms_sections = array(
	array(
		'section_form' => 'bio',
		'section_tab' => 1,
		'section_name' => 'Character Information',
		'section_order' => 0),
	array(
		'section_form' => 'bio',
		'section_tab' => 1,
		'section_name' => 'Physical Appearance',
		'section_order' => 1),
	array(
		'section_form' => 'bio',
		'section_tab' => 1,
		'section_name' => 'Family',
		'section_order' => 2),
	array(
		'section_form' => 'bio',
		'section_tab' => 2,
		'section_name' => 'Personality &amp; Traits',
		'section_order' => 0),
	array(
		'section_form' => 'bio',
		'section_tab' => 3,
		'section_name' => '',
		'section_order' => 0),
	array(
		'section_form' => 'docking',
		'section_name' => 'Details',
		'section_order' => 0),
	array(
		'section_form' => 'specs',
		'section_name' => 'General',
		'section_order' => 0),
	array(
		'section_form' => 'specs',
		'section_name' => 'Dimensions',
		'section_order' => 1),
	array(
		'section_form' => 'specs',
		'section_name' => 'Personnel',
		'section_order' => 2),
	array(
		'section_form' => 'specs',
		'section_name' => 'Speed',
		'section_order' => 3),
	array(
		'section_form' => 'specs',
		'section_name' => 'Weapons &amp; Defensive Systems',
		'section_order' => 4),
	array(
		'section_form' => 'specs',
		'section_name' => 'Auxiliary Craft',
		'section_order' => 5),
);

$forms_tabs = array(
	array(
		'tab_form' => 'bio',
		'tab_name' => 'Basic Info',
		'tab_link_id' => 'one',
		'tab_order' => 1),
	array(
		'tab_form' => 'bio',
		'tab_name' => 'Personality',
		'tab_link_id' => 'two',
		'tab_order' => 2),
	array(
		'tab_form' => 'bio',
		'tab_name' => 'History',
		'tab_link_id' => 'three',
		'tab_order' => 3),
);

$forms_values = array(
	array(
		'value_field' => 1,
		'value_html_name' => 'gender',
		'value_html_value' => 'Male',
		'value_html_id' => 'male',
		'value_content' => 'Male',
		'value_order' => 1),
	array(
		'value_field' => 1,
		'value_html_name' => 'gender',
		'value_html_value' => 'Female',
		'value_html_id' => 'female',
		'value_content' => 'Female',
		'value_order' => 2),
	array(
		'value_field' => 1,
		'value_html_name' => 'gender',
		'value_html_value' => 'Hermaphrodite',
		'value_html_id' => 'hermaphrodite',
		'value_content' => 'Hermaphrodite',
		'value_order' => 3),
	array(
		'value_field' => 1,
		'value_html_name' => 'gender',
		'value_html_value' => 'Neuter',
		'value_html_id' => 'neuter',
		'value_content' => 'Neuter',
		'value_order' => 4),
);

$menu_categories = array(
	array(
		'menucat_name' => 'Main',
		'menucat_order' => 0,
		'menucat_menu_cat' => 'main',
		'menucat_type' => 'sub'),
	array(
		'menucat_name' => 'Personnel',
		'menucat_order' => 1,
		'menucat_menu_cat' => 'personnel',
		'menucat_type' => 'sub'),
	array(
		'menucat_name' => 'The Sim',
		'menucat_order' => 2,
		'menucat_menu_cat' => 'sim',
		'menucat_type' => 'sub'),
	array(
		'menucat_name' => 'Admin Control Panel',
		'menucat_order' => 3,
		'menucat_menu_cat' => 'admin',
		'menucat_type' => 'adminsub'),
	array(
		'menucat_name' => 'Write',
		'menucat_order' => 4,
		'menucat_menu_cat' => 'write',
		'menucat_type' => 'adminsub'),
	array(
		'menucat_name' => 'Private Messages',
		'menucat_order' => 5,
		'menucat_menu_cat' => 'messages',
		'menucat_type' => 'adminsub'),
	array(
		'menucat_name' => 'Site Management',
		'menucat_order' => 6,
		'menucat_menu_cat' => 'site',
		'menucat_type' => 'adminsub'),
	array(
		'menucat_name' => 'Management',
		'menucat_order' => 7,
		'menucat_menu_cat' => 'manage',
		'menucat_type' => 'adminsub'),
	array(
		'menucat_name' => 'Characters',
		'menucat_order' => 8,
		'menucat_menu_cat' => 'characters',
		'menucat_type' => 'adminsub'),
	array(
		'menucat_name' => 'User',
		'menucat_order' => 9,
		'menucat_menu_cat' => 'user',
		'menucat_type' => 'adminsub'),
	array(
		'menucat_name' => 'Reports',
		'menucat_order' => 10,
		'menucat_menu_cat' => 'report',
		'menucat_type' => 'adminsub'),
	array(
		'menucat_name' => 'Wiki',
		'menucat_order' => 11,
		'menucat_menu_cat' => 'wiki',
		'menucat_type' => 'sub'),
);

$menu_items = array(
	array(
		'menu_name' => 'Main',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'main/index',
		'menu_sim_type' => 1,
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'Personnel',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'personnel/index',
		'menu_sim_type' => 1,
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'Sim',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'sim/index',
		'menu_sim_type' => 1,
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'Wiki',
		'menu_group' => 0,
		'menu_order' => 3,
		'menu_link' => 'wiki/index',
		'menu_sim_type' => 1,
		'menu_cat' => 'main',
		'menu_display' => 'y'),
	array(
		'menu_name' => 'Search',
		'menu_group' => 0,
		'menu_order' => 4,
		'menu_link' => 'search/index',
		'menu_sim_type' => 1,
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'Control Panel',
		'menu_group' => 0,
		'menu_order' => 5,
		'menu_link' => 'admin/index',
		'menu_sim_type' => 1,
		'menu_cat' => 'main',
		'menu_need_login' => 'y'),
	array(
		'menu_name' => 'Login',
		'menu_group' => 0,
		'menu_order' => 6,
		'menu_link' => 'login/index',
		'menu_sim_type' => 1,
		'menu_cat' => 'main',
		'menu_need_login' => 'n'),
	array(
		'menu_name' => 'Logout',
		'menu_group' => 0,
		'menu_order' => 7,
		'menu_link' => 'login/logout',
		'menu_sim_type' => 1,
		'menu_cat' => 'main',
		'menu_need_login' => 'y'),
		
	array(
		'menu_name' => 'Main',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'main/index',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'News',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'main/news',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'Contact',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'main/contact',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'Credits',
		'menu_group' => 0,
		'menu_order' => 3,
		'menu_link' => 'main/credits',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'Join',
		'menu_group' => 0,
		'menu_order' => 4,
		'menu_link' => 'main/join',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'main'),
	array(
		'menu_name' => 'Search',
		'menu_group' => 0,
		'menu_order' => 5,
		'menu_link' => 'search/index',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'main'),
		
	array(
		'menu_name' => 'Manifest',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'personnel/index',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'personnel'),
	array(
		'menu_name' => 'Chain of Command',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'personnel/coc',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'personnel'),
	array(
		'menu_name' => 'Crew Awards',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'sim/awards',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'personnel'),
	array(
		'menu_name' => 'Join',
		'menu_group' => 0,
		'menu_order' => 3,
		'menu_link' => 'main/join',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'personnel'),
	
	array(
		'menu_name' => 'The Sim',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'sim/index',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Missions',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'sim/missions',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Mission Groups',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'sim/missions/group',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Personal Logs',
		'menu_group' => 0,
		'menu_order' => 3,
		'menu_link' => 'sim/listlogs',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Stats',
		'menu_group' => 0,
		'menu_order' => 4,
		'menu_link' => 'sim/stats',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Crew Awards',
		'menu_group' => 0,
		'menu_order' => 5,
		'menu_link' => 'sim/awards',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Tour',
		'menu_group' => 1,
		'menu_order' => 0,
		'menu_link' => 'sim/tour',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Specifications',
		'menu_group' => 1,
		'menu_order' => 1,
		'menu_link' => 'sim/specs',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Deck Listing',
		'menu_group' => 1,
		'menu_order' => 2,
		'menu_link' => 'sim/decks',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Departments',
		'menu_group' => 1,
		'menu_order' => 3,
		'menu_link' => 'sim/departments',
		'menu_sim_type' => 1,
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Docked Items',
		'menu_group' => 2,
		'menu_order' => 0,
		'menu_link' => 'sim/docked',
		'menu_sim_type' => 3,
		'menu_display' => 'n',
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
	array(
		'menu_name' => 'Docking Request',
		'menu_group' => 2,
		'menu_order' => 1,
		'menu_link' => 'sim/dockingrequest',
		'menu_sim_type' => 3,
		'menu_display' => 'n',
		'menu_type' => 'sub',
		'menu_cat' => 'sim'),
		
	array(
		'menu_name' => 'Main Page',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'wiki/index',
		'menu_sim_type' => 1,
		'menu_display' => 'y',
		'menu_type' => 'sub',
		'menu_cat' => 'wiki'),
	array(
		'menu_name' => 'Recent Changes',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'wiki/recent',
		'menu_sim_type' => 1,
		'menu_display' => 'y',
		'menu_type' => 'sub',
		'menu_cat' => 'wiki'),
	array(
		'menu_name' => 'Categories',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'wiki/categories',
		'menu_sim_type' => 1,
		'menu_display' => 'y',
		'menu_type' => 'sub',
		'menu_cat' => 'wiki'),
	array(
		'menu_name' => 'Manage Pages',
		'menu_group' => 1,
		'menu_order' => 0,
		'menu_link' => 'wiki/managepages',
		'menu_sim_type' => 1,
		'menu_display' => 'y',
		'menu_type' => 'sub',
		'menu_use_access' => 'y',
		'menu_access' => 'wiki/page',
		'menu_need_login' => 'y',
		'menu_cat' => 'wiki'),
	array(
		'menu_name' => 'Manage Categories',
		'menu_group' => 1,
		'menu_order' => 1,
		'menu_link' => 'wiki/managecategories',
		'menu_sim_type' => 1,
		'menu_display' => 'y',
		'menu_type' => 'sub',
		'menu_use_access' => 'y',
		'menu_access' => 'wiki/categories',
		'menu_need_login' => 'y',
		'menu_cat' => 'wiki'),
	array(
		'menu_name' => 'Create New Page',
		'menu_group' => 2,
		'menu_order' => 0,
		'menu_link' => 'wiki/page',
		'menu_sim_type' => 1,
		'menu_display' => 'y',
		'menu_type' => 'sub',
		'menu_use_access' => 'y',
		'menu_access' => 'wiki/page',
		'menu_need_login' => 'y',
		'menu_cat' => 'wiki'),
		
	array(
		'menu_name' => 'Control Panel',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'admin/index',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'admin',
		'menu_use_access' => 'y',
		'menu_access' => 'admin/index'),
	array(
		'menu_name' => "What's New",
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'admin/whatsnew',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'admin',
		'menu_use_access' => 'y',
		'menu_access' => 'admin/index'),
		
	array(
		'menu_name' => 'Writing Control Panel',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'write/index',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'write',
		'menu_use_access' => 'y',
		'menu_access' => 'write/index'),
	array(
		'menu_name' => 'Write Mission Post',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'write/missionpost',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'write',
		'menu_use_access' => 'y',
		'menu_access' => 'write/missionpost'),
	array(
		'menu_name' => 'Write Personal Log',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'write/personallog',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'write',
		'menu_use_access' => 'y',
		'menu_access' => 'write/personallog'),
	array(
		'menu_name' => 'Write News Item',
		'menu_group' => 0,
		'menu_order' => 3,
		'menu_link' => 'write/newsitem',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'write',
		'menu_use_access' => 'y',
		'menu_access' => 'write/newsitem'),
		
	array(
		'menu_name' => 'Inbox',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'messages/index',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'messages',
		'menu_use_access' => 'y',
		'menu_access' => 'messages/index'),
	array(
		'menu_name' => 'Sent Messages',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'messages/index/sent',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'messages',
		'menu_use_access' => 'y',
		'menu_access' => 'messages/index'),
	array(
		'menu_name' => 'Write New Message',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'messages/write',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'messages',
		'menu_use_access' => 'y',
		'menu_access' => 'messages/index'),
		
	array(
		'menu_name' => 'Settings',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'site/settings',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/settings'),
	array(
		'menu_name' => 'Messages &amp; Titles',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'site/messages',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/messages'),
	array(
		'menu_name' => 'Menu Items',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'site/menus',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/menus'),
	array(
		'menu_name' => 'Access Roles',
		'menu_group' => 0,
		'menu_order' => 3,
		'menu_link' => 'site/roles',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/roles'),
	array(
		'menu_name' => 'Bio Form',
		'menu_group' => 1,
		'menu_order' => 0,
		'menu_link' => 'site/bioform',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/bioform'),
	array(
		'menu_name' => 'Specs Form',
		'menu_group' => 1,
		'menu_order' => 1,
		'menu_link' => 'site/specsform',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/specsform'),
	array(
		'menu_name' => 'Tour Form',
		'menu_group' => 1,
		'menu_order' => 2,
		'menu_link' => 'site/tourform',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/tourform'),
	array(
		'menu_name' => 'Docking Form',
		'menu_group' => 1,
		'menu_order' => 3,
		'menu_link' => 'site/dockingform',
		'menu_sim_type' => 3,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/dockingform'),
	array(
		'menu_name' => 'Sim Types',
		'menu_group' => 2,
		'menu_order' => 0,
		'menu_link' => 'site/simtypes',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/simtypes'),
	array(
		'menu_name' => 'Rank Catalogue',
		'menu_group' => 2,
		'menu_order' => 1,
		'menu_link' => 'site/catalogueranks',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/catalogueranks'),
	array(
		'menu_name' => 'Skin Catalogue',
		'menu_group' => 2,
		'menu_order' => 2,
		'menu_link' => 'site/catalogueskins',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'site',
		'menu_use_access' => 'y',
		'menu_access' => 'site/catalogueskins'),
		
	array(
		'menu_name' => 'Awards',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'manage/awards',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/awards'),
	array(
		'menu_name' => 'Departments',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'manage/depts',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/depts'),
	array(
		'menu_name' => 'Positions',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'manage/positions',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/positions'),
	array(
		'menu_name' => 'Ranks',
		'menu_group' => 0,
		'menu_order' => 3,
		'menu_link' => 'manage/ranks',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/ranks'),
	array(
		'menu_name' => 'Missions',
		'menu_group' => 1,
		'menu_order' => 0,
		'menu_link' => 'manage/missions',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/missions'),
	array(
		'menu_name' => 'Mission Groups',
		'menu_group' => 1,
		'menu_order' => 1,
		'menu_link' => 'manage/missiongroups',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/missions'),
	array(
		'menu_name' => 'Mission Posts',
		'menu_group' => 1,
		'menu_order' => 2,
		'menu_link' => 'manage/posts',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/posts'),
	array(
		'menu_name' => 'Personal Logs',
		'menu_group' => 1,
		'menu_order' => 3,
		'menu_link' => 'manage/logs',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/logs'),
	array(
		'menu_name' => 'News Items',
		'menu_group' => 1,
		'menu_order' => 4,
		'menu_link' => 'manage/news',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/news'),
	array(
		'menu_name' => 'News Categories',
		'menu_group' => 1,
		'menu_order' => 5,
		'menu_link' => 'manage/newscats',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/newscats'),
	array(
		'menu_name' => 'Comments',
		'menu_group' => 1,
		'menu_order' => 6,
		'menu_link' => 'manage/comments',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/comments'),
	array(
		'menu_name' => 'Specs',
		'menu_group' => 2,
		'menu_order' => 0,
		'menu_link' => 'manage/specs',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/specs'),
	array(
		'menu_name' => 'Tour',
		'menu_group' => 2,
		'menu_order' => 1,
		'menu_link' => 'manage/tour',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/tour'),
	array(
		'menu_name' => 'Deck Listing',
		'menu_group' => 2,
		'menu_order' => 2,
		'menu_link' => 'manage/decks',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/decks'),
	array(
		'menu_name' => 'Docked Items',
		'menu_group' => 2,
		'menu_order' => 3,
		'menu_link' => 'manage/docked',
		'menu_sim_type' => 3,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'manage/docked'),
		
	array(
		'menu_name' => 'Upload Images',
		'menu_group' => 3,
		'menu_order' => 0,
		'menu_link' => 'upload/index',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'n'),
	array(
		'menu_name' => 'Manage Uploads',
		'menu_group' => 3,
		'menu_order' => 1,
		'menu_link' => 'upload/manage',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'manage',
		'menu_use_access' => 'y',
		'menu_access' => 'upload/manage'),
		
	array(
		'menu_name' => 'All Characters',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'characters/index',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'characters',
		'menu_use_access' => 'y',
		'menu_access' => 'characters/index'),
	array(
		'menu_name' => 'All NPCs',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'characters/npcs',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'characters',
		'menu_use_access' => 'y',
		'menu_access' => 'characters/npcs'),
	array(
		'menu_name' => 'Create Character',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'characters/create',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'characters',
		'menu_use_access' => 'y',
		'menu_access' => 'characters/create'),
	array(
		'menu_name' => 'Chain of Command',
		'menu_group' => 1,
		'menu_order' => 0,
		'menu_link' => 'characters/coc',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'characters',
		'menu_use_access' => 'y',
		'menu_access' => 'characters/coc'),
	array(
		'menu_name' => 'Give/Remove Awards',
		'menu_group' => 1,
		'menu_order' => 1,
		'menu_link' => 'characters/awards',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'characters',
		'menu_use_access' => 'y',
		'menu_access' => 'characters/awards'),
		
	array(
		'menu_name' => 'My Account',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'user/account',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'user',
		'menu_use_access' => 'y',
		'menu_access' => 'user/account'),
	array(
		'menu_name' => 'My Bio',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'characters/bio',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'user',
		'menu_use_access' => 'y',
		'menu_access' => 'characters/bio'),
	array(
		'menu_name' => 'Site Options',
		'menu_group' => 1,
		'menu_order' => 0,
		'menu_link' => 'user/options',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'user',
		'menu_use_access' => 'y',
		'menu_access' => 'user/account'),
	array(
		'menu_name' => 'Request LOA',
		'menu_group' => 1,
		'menu_order' => 1,
		'menu_link' => 'user/status',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'user',
		'menu_use_access' => 'y',
		'menu_access' => 'user/account'),
	array(
		'menu_name' => 'Award Nominations',
		'menu_group' => 1,
		'menu_order' => 2,
		'menu_link' => 'user/nominate',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'user',
		'menu_use_access' => 'y',
		'menu_access' => 'user/nominate'),
	array(
		'menu_name' => 'All Users',
		'menu_group' => 1,
		'menu_order' => 3,
		'menu_link' => 'user/all',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'user',
		'menu_use_access' => 'y',
		'menu_access' => 'user/account',
		'menu_access_level' => 2),
	array(
		'menu_name' => 'Link Characters',
		'menu_group' => 1,
		'menu_order' => 4,
		'menu_link' => 'user/characterlink',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'user',
		'menu_use_access' => 'y',
		'menu_access' => 'user/account',
		'menu_access_level' => 2),
		
	array(
		'menu_name' => 'Crew Activity',
		'menu_group' => 0,
		'menu_order' => 0,
		'menu_link' => 'report/activity',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/activity'),
	array(
		'menu_name' => 'Posting Levels',
		'menu_group' => 0,
		'menu_order' => 1,
		'menu_link' => 'report/posting',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/posting'),
	array(
		'menu_name' => 'Sim Statistics',
		'menu_group' => 0,
		'menu_order' => 2,
		'menu_link' => 'report/stats',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/stats'),
	array(
		'menu_name' => 'Moderation',
		'menu_group' => 1,
		'menu_order' => 0,
		'menu_link' => 'report/moderation',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/moderation'),
	array(
		'menu_name' => 'Milestones',
		'menu_group' => 1,
		'menu_order' => 1,
		'menu_link' => 'report/milestones',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/milestones'),
	array(
		'menu_name' => 'LOA Records',
		'menu_group' => 1,
		'menu_order' => 2,
		'menu_link' => 'report/loa',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/loa'),
	array(
		'menu_name' => 'Award Nominations',
		'menu_group' => 1,
		'menu_order' => 3,
		'menu_link' => 'report/awardnominations',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/awardnominations'),
	array(
		'menu_name' => 'Applications',
		'menu_group' => 1,
		'menu_order' => 4,
		'menu_link' => 'report/applications',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/applications'),
	array(
		'menu_name' => 'System &amp; Versions',
		'menu_group' => 1,
		'menu_order' => 5,
		'menu_link' => 'report/versions',
		'menu_sim_type' => 1,
		'menu_type' => 'adminsub',
		'menu_cat' => 'report',
		'menu_use_access' => 'y',
		'menu_access' => 'report/versions'),
);

$messages = array(
	array(
		'message_key' => 'welcome_msg',
		'message_label' => 'Welcome Page Message',
		'message_content' => "Define your welcome message and welcome page header through the Site Messages page.",
		'message_type' => 'message'),
	array(
		'message_key' => 'sim',
		'message_label' => 'Sim Message',
		'message_content' => "Define your sim message through the Site Messages page.",
		'message_type' => 'message'),
	array(
		'message_key' => 'wiki_main',
		'message_label' => 'Wiki Main Page Message',
		'message_content' => "Welcome to Thresher Release 1, Anodyne's integrated mini-wiki included with Nova. You can change this message through the Site Messages page.",
		'message_type' => 'message'),
	array(
		'message_key' => 'credits_perm',
		'message_label' => 'Permanent Credits',
		'message_content' => "Nova has been developed on the <a href='http://www.codeigniter.com' target='_blank'>CodeIgniter</a> PHP framework by <a href='http://www.ellislab.com' target='_blank'>EllisLab</a>.\r\n\r\nIcons used throughout Nova were created by <a href='http://www.famfamfam.com'>FamFamFam</a> and <a href='http://www.pinvoke.com'>Pinvoke</a>.",
		'message_protected' => 'y',
		'message_type' => 'message'),
	array(
		'message_key' => 'credits',
		'message_label' => 'Credits',
		'message_content' => "Define your site credits through the Site Messages page.",
		'message_type' => 'message'),
	array(
		'message_key' => 'join_disclaimer',
		'message_label' => 'Join Disclaimer',
		'message_content' => "Members are expected to follow the rules and regulations of both the sim and fleet at all times, both in character and out of character. By continuing, you affirm that you will sim in a proper and adequate manner. Members who choose to make ultra short posts, post very infrequently, or post posts with explicit content (above PG-13) will be removed immediately, and by continuing, you agree to this. In addition, in compliance with the Children's Online Privacy Protection Act of 1998 (COPPA), we do not accept players under the age of 13.  Any players found to be under the age of 13 will be immediately removed without question.  By agreeing to these terms, you are also saying that you are above the age of 13.",
		'message_type' => 'other'),
	array(
		'message_key' => 'join_instructions',
		'message_label' => 'Join Instructions',
		'message_content' => "Define your join instructions through the Site Message page.",
		'message_type' => 'message'),
	array(
		'message_key' => 'join_post',
		'message_label' => 'Join Sample Post',
		'message_content' => "Define your join sample post through the Site Message page.",
		'message_type' => 'other'),
	array(
		'message_key' => 'accept_message',
		'message_label' => 'User Acceptance Email',
		'message_content' => "Define your user acceptance message through the Site Message page.",
		'message_type' => 'other'),
	array(
		'message_key' => 'reject_message',
		'message_label' => 'User Rejection Message',
		'message_content' => "Define your user rejection message through the Site Messages page.",
		'message_type' => 'other'),
	array(
		'message_key' => 'docking_accept_message',
		'message_label' => 'Docking Acceptance Email',
		'message_content' => "Define your docking acceptance message through the Site Message page.",
		'message_type' => 'other'),
	array(
		'message_key' => 'docking_reject_message',
		'message_label' => 'Docking Rejection Message',
		'message_content' => "Define your docking rejection message through the Site Messages page.",
		'message_type' => 'other'),
	array(
		'message_key' => 'contact',
		'message_label' => 'Contact Instructions',
		'message_content' => 'Please use the form below to contact the sim with questions. You can choose to email the game master, the command staff, or the webmaster with your questions and/or comments.',
		'message_type' => 'message'),
	
	array(
		'message_key' => 'welcome_head',
		'message_label' => 'Welcome Header',
		'message_content' => "Welcome to Nova!",
		'message_type' => 'title'),
	array(
		'message_key' => 'main_credits_title',
		'message_label' => 'Site Credits Header',
		'message_content' => 'Site Credits',
		'message_type' => 'title'),
	array(
		'message_key' => 'main_join_title',
		'message_label' => 'Join Page Header',
		'message_content' => 'Join',
		'message_type' => 'title'),
);

$news_categories = array(
	array('newscat_name' => 'General News'),
	array('newscat_name' => 'Out of Character'),
	array('newscat_name' => 'Sim Announcement'),
	array('newscat_name' => 'Website Update')
);

$user_prefs = array(
	array(
		'pref_key' => 'email_new_news_comments',
		'pref_label' => 'Email News Comments',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_new_log_comments',
		'pref_label' => 'Email Log Comments',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_new_post_comments',
		'pref_label' => 'Email Post Comments',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_new_wiki_comments',
		'pref_label' => 'Email Wiki Comments',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_private_message',
		'pref_label' => 'Email Private Messages',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_personal_logs',
		'pref_label' => 'Email Personal Logs',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_news_items',
		'pref_label' => 'Email News Items',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_mission_posts',
		'pref_label' => 'Email Mission Posts',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_mission_posts_save',
		'pref_label' => 'Email Mission Post Saved Notifications',
		'pref_default' => 'y'),
	array(
		'pref_key' => 'email_mission_posts_delete',
		'pref_label' => 'Email Mission Post Delete Notifications',
		'pref_default' => 'y'),
);

$security_questions = array(
	array('question_value' => "What is your father's middle name?"),
	array('question_value' => "What was the name of your first pet?"),
	array('question_value' => "What city were you born in?"),
	array('question_value' => "What is your favorite animal?"),
	array('question_value' => "Who was your favorite teacher?"),
	array('question_value' => "What is the last book you read?")
);

$settings = array(
	array(
		'setting_key' => 'sim_name',
		'setting_value' => '',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'sim_year',
		'setting_value' => '',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'sim_type',
		'setting_value' => 2,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'maintenance',
		'setting_value' => 'off',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'skin_main',
		'setting_value' => 'default',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'skin_admin',
		'setting_value' => 'default',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'skin_wiki',
		'setting_value' => 'default',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'skin_login',
		'setting_value' => 'default',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'display_rank',
		'setting_value' => 'default',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'bio_num_awards',
		'setting_value' => 10,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'allowed_chars_playing',
		'setting_value' => 1,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'allowed_chars_npc',
		'setting_value' => 3,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'system_email',
		'setting_value' => 'on',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'email_subject',
		'setting_value' => '',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'timezone',
		'setting_value' => 'UTC',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'daylight_savings',
		'setting_value' => 'FALSE',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'date_format',
		'setting_value' => 'D M jS, Y @ g:ia',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'list_logs_num',
		'setting_value' => 25,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'list_posts_num',
		'setting_value' => 25,
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'manifest_defaults',
		'setting_value' => "$('tr.active').show();,$('tr.npc').show();",
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'updates',
		'setting_value' => 'all',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'show_news',
		'setting_value' => 'y',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'post_count_format',
		'setting_value' => 'multiple',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'use_sample_post',
		'setting_value' => 'y',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'default_email_name',
		'setting_value' => '',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'default_email_address',
		'setting_value' => '',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'use_mission_notes',
		'setting_value' => 'y',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'online_timespan',
		'setting_value' => '5',
		'setting_user_created' => 'n'),
	array(
		'setting_key' => 'posting_requirement',
		'setting_value' => 14,
		'setting_user_created' => 'n'),
);

$sim_type = array(
	array('simtype_name' => 'all'),
	array('simtype_name' => 'ship'),
	array('simtype_name' => 'base'),
	array('simtype_name' => 'colony'),
	array('simtype_name' => 'unit'),
	array('simtype_name' => 'realm'),
	array('simtype_name' => 'planet'),
	array('simtype_name' => 'organization')
);

$system_components = array(
	array(
		'comp_name' => 'Kohana',
		'comp_version' => '3.0.5',
		'comp_url' => 'http://kohanaframework.org/',
		'comp_desc' => 'Kohana is an elegant HMVC PHP5 framework that provides a rich set of components for building web applications. It requires very little configuration, fully supports UTF-8 and I18N, and provides many of the tools that a developer needs within a highly flexible system. The integrated class auto-loading, cascading filesystem, highly consistent API, and easy integration with vendor libraries make it viable for any project, large or small.'),
	array(
		'comp_name' => 'Thresher',
		'comp_version' => 'Release 1',
		'comp_url' => '',
		'comp_desc' => "Thresher is Anodyne Productions' integrated mini-wiki for Nova."),
	array(
		'comp_name' => 'Jelly',
		'comp_version' => '0.9.6.2',
		'comp_desc' => "Jelly is a compact but powerful object relational mapper for Kohana 3. Its small, clean and well-documented codebase makes it incredibly lightweight and with complete support for column aliases and an extensible field architecture, Jelly makes database interaction a breeze.",
		'comp_url' => 'http://jelly.jonathan-geiger.com/'),
	array(
		'comp_name' => 'Swift Mailer',
		'comp_version' => '4.0.6',
		'comp_desc' => "Swift Mailer integrates into any web app written in PHP 5, offering a flexible and elegant object-oriented approach to sending emails with a multitude of features.",
		'comp_url' => 'http://swiftmailer.org/'),
	array(
		'comp_name' => 'jQuery',
		'comp_version' => '1.4.2',
		'comp_url' => 'http://www.jquery.com/',
		'comp_desc' => 'jQuery is a lightweight JavaScript library that emphasizes interaction between JavaScript and HTML.'),
	array(
		'comp_name' => 'jQuery UI',
		'comp_version' => '1.8.2',
		'comp_url' => 'http://jqueryui.com/',
		'comp_desc' => 'jQuery UI is a lightweight, easily customizable interface library for the jQuery Javascript library.'),
	array(
		'comp_name' => 'jQuery ColorBox',
		'comp_version' => '1.3.8',
		'comp_desc' => "A light-weight, customizable lightbox plugin for jQuery.",
		'comp_url' => 'http://colorpowered.com/colorbox/'),
	array(
		'comp_name' => 'FancyBox',
		'comp_version' => '1.3.1',
		'comp_desc' => "FancyBox is a tool for displaying images, html content and multi-media in a Mac-style 'lightbox' that floats overtop of web page. It was built using the jQuery library and licensed under both MIT and GPL licenses.",
		'comp_url' => 'http://fancybox.net/home'),
	array(
		'comp_name' => 'Facebox',
		'comp_version' => '1.2',
		'comp_desc' => "Facebox is a jQuery-based lightbox which can display images, divs, or entire remote pages.",
		'comp_url' => 'http://famspam.com/facebox'),
	array(
		'comp_name' => 'AjaxQ',
		'comp_version' => '0.0.1',
		'comp_desc' => "AjaxQ is a jQuery plugin that implements an AJAX request queueing mechanism.",
		'comp_url' => 'http://plugins.jquery.com/project/ajaxq'),
	array(
		'comp_name' => 'TipTip',
		'comp_version' => '1.3',
		'comp_desc' => "TipTip is a sweet and simple custom tooltip that behaves just like the browser tooltip. TipTip detects the edges of the browser window and will make sure the tooltip stays within the current window size. As a result the tooltip will adjust itself to be displayed above, below, to the left or to the right of the element with TipTip applied to it, depending on what is necessary to stay within the browser window. TipTip is a very lightweight and intelligent custom tooltip jQuery plugin that uses ZERO images and is completely customizable via CSS.",
		'comp_url' => 'http://code.drewwilson.com/entry/tiptip-jquery-plugin'),
	array(
		'comp_name' => 'Lazy',
		'comp_version' => '1.5',
		'comp_desc' => "Lazy is an on-demand jQuery plugin loader, also known as a lazy loader. Instead of downloading all jQuery plugins you might or might not need when the page loads, Lazy downloads the plugins when you actually use them. Lazy is very lightweight, super fast, and smart. Lazy will keep track of all your plugins and dependencies and make sure that they are only downloaded once.",
		'comp_url' => 'http://www.unwrongest.com/projects/lazy/'),
	array(
		'comp_name' => 'Elastic',
		'comp_version' => '1.6.4',
		'comp_desc' => "Elastic is a jQuery plugin that makes your textareas grow and shrink to fit its content. It was inspired by the auto-growing textareas on Facebook. The major difference between Elastic and its competitors is its weight.",
		'comp_url' => 'http://www.unwrongest.com/projects/elastic/'),
	array(
		'comp_name' => 'Reflection.js',
		'comp_version' => '2.0',
		'comp_desc' => "Reflection.js allows you to add reflections to images on your webpages. It uses unobtrusive Javascript to keep your code clean.",
		'comp_url' => 'http://cow.neondragon.net/stuff/reflection/'),
	array(
		'comp_name' => 'jQuery QuickSearch',
		'comp_version' => '',
		'comp_desc' => "QuickSearch is a simple plugin for filtering tables, lists and paragraphs.",
		'comp_url' => 'http://rikrikrik.com/jquery/quicksearch/'),
	array(
		'comp_name' => 'jwysiwyg',
		'comp_version' => '0.9.2',
		'comp_desc' => "A simple rich text editor plugin using jQuery.",
		'comp_url' => 'http://github.com/akzhan/jwysiwyg'),
	array(
		'comp_name' => 'sfYAML',
		'comp_version' => '1.4',
		'comp_desc' => "sfYAML is the YAML parser component from the symfony PHP framework.",
		'comp_url' => 'http://www.symfony-project.org/'),
	array(
		'comp_name' => 'jQuery Countdown',
		'comp_version' => '',
		'comp_desc' => "A simple plugin that counts down and updates the text every second.",
		'comp_url' => 'http://davidwalsh.name/jquery-countdown-plugin'),
	array(
		'comp_name' => 'Uniform',
		'comp_version' => '1.5',
		'comp_desc' => "Uniform masks your standard form controls with custom themed controls. It works in sync with your real form elements to ensure accessibility and compatibility.",
		'comp_url' => 'http://pixelmatrixdesign.com/uniform/'),
);

$system_info = array(
	array(
		'sys_uid' => text::random('alnum', 32),
		'sys_install_date' => date::now(),
		'sys_version_major' => 1,
		'sys_version_minor' => 0,
		'sys_version_update' => 5)
);

$system_versions = array(
	array(
		'version' => '1.0.0',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '0',
		'version_date' => 1271393940,
		'version_launch'	=> 'Nova 1.0 is the first release of the next generation RPG management software from Anodyne Productions.',
		'version_changes'	=> "* Initial release"),
	array(
		'version' => '1.0.1',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '1',
		'version_date' => 1271424600,
		'version_launch'	=> 'Nova 1.0.1 is a maintenance release that fixes two important issues with Nova 1.0. The release fixes a bug where the upgrade process did not create a necessary field in the missions table as well as two issues with installations oh PHP4 servers. This update is recommended for all users who have upgraded from SMS and/or are running on a PHP4 server.',
		'version_changes'	=> "* fixed bug in the upgrade process where a database field wasn't added to the table
* fixed bug where models couldn't be autoloaded because Base4 doesn't extend MY_Loader
* fixed error that was thrown because the date_default_timezone_set function doesn't exist in PHP before version 5.1"),
	array(
		'version' => '1.0.2',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '2',
		'version_date' => 1271817000,
		'version_launch'	=> 'Nova 1.0.2 is a maintenance release that fixes a majority of the outstanding issues with Nova 1.0, including: login issues, post display issues and bug with posting mission entries. See the changelog after updating for a complete list of changes. This update is recommended for all users.',
		'version_changes'	=> "* added the 1.0.2 update file
* added the MY\_Input library to add a call to a text cleanup function after filtering for XSS
* updated the database schema to use a genre field in the rank catalogue table
* updated the genre install files to populate the new genre field in the rank catalogue table on creation
* updated the language files
    * [base\_lang] added labels_genre key
    * [error\_lang] added error_login_7
* updated the ranks model to pull the genre when looking for the default rank catalogue item
* updated the ranks model to pull only the ranks sets from a genre when getting all ranks
* updated the ranks model to only pull rank catalogue items for the given genre
* updated the site controller to handle adding and editing the genre for a rank catalogue item
* updated the ajax controller to handle adding and editing the genre for a rank catalogue item
* updated the upload management page to show messages if uploaded images weren't found in specific categories
* updated the write news item page to not allow a user to have a news item without a category
* updated the index file to use a higher debug to allow people to see any errors for debugging purposes
* updated the upgrade process to fix some minor schema differences between sms and nova
* updated the ranks model so the get\_group\_ranks() method had a customizable identifier
* updated the auth library to check for a user's status and not allow pending users to log in to the system
* updated the login page to handle the new pending user error
* updated the Auth library to increase the login attempts allowed to 5
* updated the Auth library to attempt a fix to the remember me lockout issue
* updated the user account page to reset the cookie in the event of a password reset if the user has elected to have nova remember them
* updated the admin controller so that nova resets the cookie password after an SMS upgrade if the user has elected to have nova remember them
* fixed bug where the menu library wouldn't respect any access control put on main navigation menu items (#101)
* fixed bug where the menu library wouldn't respect any access control put on sub navigation menu items
* fixed undefined variable error thrown on site/catalogueranks
* fixed bug where rank catalogue items didn't work well when multiple genres were installed (#102)
* fixed bug where uploaded images besides bio images couldn't be deleted
* fixed bug where authors were being dropped off of posts because of faulty logic
* fixed bug where sample post wasn't sent out in the email sent to game masters
* fixed bug in IE where ranks couldn't be added
* fixed bug where rank classes wouldn't be shown for ranks sets without a blank name rank item
* fixed bug where the user bio pointed to the wrong location for user posts and awards
* fixed bug where listing all of a users' posts would display posts besides their own
* fixed error thrown on commenting on a mission post
* fixed fatal error thrown when updating a news item
* fixed fatal error thrown when updating a personal log
* fixed a presentational bug in login error #6
* fixed bug where the mission dropdown wasn't properly populated when viewing a saved post"),
	array(
		'version' => '1.0.3',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '3',
		'version_date' => 1272321000,
		'version_launch'	=> "Nova 1.0.3 is the third maintainance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, several bugs with Thresher, changes to the update center to allow users to update even if they can't get the update information from the Anodyne server, NPC removal issues, updates to the user removal process and much more. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
		'version_changes'	=> "* added the 1.0.3 update file
* updated the install data
    * menu items
    * version info
* updated the language files
    * [base\_lang] added labels_you
    * [text\_lang] added character_change
* updated the versions array file
* updated the ajax controller to have a separate method for removing NPCs instead of piggybacking off of the delete character method
* updated the characters controller to put the NPC removal inside its own method instead of using the character removal process
* updated the posts model to clean some code up and added a parameter to the unattended posts method
* updated the dynamic form management pages (bio, docking, specs) to show notices if there are no fields in a section
* updated the panel tabs on the control panel to display a notice if there's no content available
* updated thresher to use the proper regions in the template config file
* updated the user deactivation process to deactivate a users' characters at the same time
* updated the update center to show the links to start the update regardless of whether there's information about the update or not
* updated the auth library to add some debugging code to help track down the remember me bug
* updated the process of updating the system to remove dependence on the versions array file and instead pull a listing of the update directory (we still use the versions array file in the event the directory listing fails)
* fixed bug where the create wiki entry page wasn't showing up in the sub navigation menu
* fixed bug where the posts model wasn't accurately counting unattended posts when a character ID was passed in as an integer instead of array
* fixed bug where errors were thrown when deleting characters and NPCs
* fixed an error being thrown on the write mission post page
* fixed bug where the post notification stayed active even after the post had been updated and/or sent out
* fixed errors that were thrown when adding a rank
* fixed error thrown when there are no fields in a specs form section
* fixed error thrown in the dashboard
* fixed bug where wiki pages were being put in the uncategorized section even if they had categories
* fixed error thrown for missing option parameters
* fixed error thrown during accepting/rejecting a docked ship application"),
	array(
		'version' => '1.0.4',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '4',
		'version_date' => 1273705200,
		'version_launch'	=> "Nova 1.0.4 is the fourth maintainance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, bugs with emails not being sent out on some servers, user access errors and filtering text before going into the database. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
		'version_changes'	=> "* added the 1.0.4 update file
* added the MY\_Email library file
* updated the version update files to make sure the values get reset at the start of every file
* updated jquery ui to version 1.8.1
* updated markItUp! to version 1.1.7
* updated the textile parser to fix some bugs (thanks to dustin for catching this)
* updated the wiki controller to show an error message if the server is running php 4
* updated the archives controller to show an error message if the server is running php 4
* updated the MY\_Input library to try and do filtering for MS Word characters a little better
* fixed error thrown when a user with level 1 user account privileges updates their account
* fixed bug where saved personal logs could be shown in along with activated logs for users with multiple characters associated with their account
* fixed bug where IE threw an exception on the post, log, news and docked item management pages
* fixed error thrown on the contact page
* fixed errors thrown on the manage bio page for users with level 1 privileges
* fixed bug with the manage bio page where positions were updated when they shouldn't be
* fixed bug where the status change request email wasn't populated properly"),
	array(
		'version' => '1.0.5',
		'version_major' => '1',
		'version_minor' => '0',
		'version_update' => '5',
		'version_date' => 1273705200,
		'version_launch'	=> "Nova 1.0.5 is the fifth maintainance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, bugs with emails not being sent out on some servers, user access errors and filtering text before going into the database. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
		'version_changes'	=> ""),
	array(
		'version' => '2.0.0',
		'version_major' => '2',
		'version_minor' => '0',
		'version_update' => '0',
		'version_date' => date::now(),
		'version_launch'	=> "Nova 2 is a development release for the second generation of Anodyne's Nova RPG management software. Bugs should be reported to the Anodyne forums.",
		'version_changes'	=> ""),
);