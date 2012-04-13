<?php
/**
 * When Nova is installed, some basic data is necessary for the system
 * to work as expected (and to reduce the burden on admins to create a
 * ton of content before they can even start using Nova).
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Asset
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

/**
 * Data array with the table/array names used
 */
$data = array(
	'announcement_categories',
	'catalog_skins',
	'catalog_skinsecs',
	'forms',
	'form_fields',
	'form_sections',
	'form_tabs',
	'form_values',
	'navigation',
	'settings',
	'sim_types',
	'site_contents',
	'system_info',
	'roles',
	'roles_tasks',
	'tasks',
);

/**
 * Arrays of data with the information being inserted into the database
 */
$announcement_categories = array(
	array('name' => 'General'),
	array('name' => 'Sim'),
	array('name' => 'In-Character'),
	array('name' => 'Out-of-Character'),
	array('name' => 'Website Update'),
);

$catalog_skins = array(
	array(
		'name' => 'Default',
		'location' => 'default',
		'credits' => '',
		'version' => ''),
);

$catalog_skinsecs = array(
	array(
		'section' => 'main',
		'skin' => 'default',
		'preview' => 'preview-main.jpg',
		'default' => (int) true),
	array(
		'section' => 'login',
		'skin' => 'default',
		'preview' => 'preview-login.jpg',
		'default' => (int) true),
	array(
		'section' => 'admin',
		'skin' => 'default',
		'preview' => 'preview-admin.jpg',
		'default' => (int) true),
);

$forms = array(
	array(
		'key' => 'bio',
		'name' => 'Bio/Join Form'),
	array(
		'key' => 'specs',
		'name' => 'Specifications Form'),
	array(
		'key' => 'tour',
		'name' => 'Tour Form'),
	array(
		'key' => 'user',
		'name' => 'User Information'),
);

$form_fields = array(
	array(
		'form_key' => 'bio',
		'section_id' => 1,
		'type' => 'select',
		'html_name' => 'gender',
		'html_id' => 'gender',
		'html_rows' => 0,
		'label' => 'Gender',
		'order' => 1),
	array(
		'form_key' => 'bio',
		'section_id' => 1,
		'type' => 'text',
		'html_name' => 'species',
		'html_id' => 'species',
		'html_rows' => 0,
		'label' => 'Species',
		'placeholder' => 'e.g. Human',
		'order' => 2),
	array(
		'form_key' => 'bio',
		'section_id' => 1,
		'type' => 'text',
		'html_name' => 'age',
		'html_id' => 'age',
		'html_rows' => 0,
		'html_class' => 'span2',
		'label' => 'Age',
		'placeholder' => 'Age',
		'order' => 3),
	array(
		'form_key' => 'bio',
		'section_id' => 2,
		'type' => 'text',
		'html_name' => 'height',
		'html_id' => 'height',
		'html_rows' => 0,
		'label' => 'Height',
		'placeholder' => 'e.g. 6\'2"',
		'order' => 1),
	array(
		'form_key' => 'bio',
		'section_id' => 2,
		'type' => 'text',
		'html_name' => 'weight',
		'html_id' => 'weight',
		'html_rows' => 0,
		'label' => 'Weight',
		'placeholder' => 'e.g. 215 lbs.',
		'order' => 2),
	array(
		'form_key' => 'bio',
		'section_id' => 2,
		'type' => 'text',
		'html_name' => 'hair_color',
		'html_id' => 'hair_color',
		'html_rows' => 0,
		'label' => 'Hair Color',
		'placeholder' => 'Hair Color',
		'order' => 3),
	array(
		'form_key' => 'bio',
		'section_id' => 2,
		'type' => 'text',
		'html_name' => 'eye_color',
		'html_id' => 'eye_color',
		'html_rows' => 0,
		'label' => 'Eye Color',
		'placeholder' => 'Eye Color',
		'order' => 4),
	array(
		'form_key' => 'bio',
		'section_id' => 2,
		'type' => 'textarea',
		'html_name' => 'physical_desc',
		'html_id' => 'physical_desc',
		'html_rows' => 3,
		'html_class' => 'span8',
		'label' => 'Physical Description',
		'placeholder' => 'Enter your physical description here',
		'order' => 5),
	array(
		'form_key' => 'bio',
		'section_id' => 3,
		'type' => 'text',
		'html_name' => 'spouse',
		'html_id' => 'spouse',
		'html_rows' => 0,
		'label' => 'Spouse',
		'placeholder' => 'Spouse',
		'order' => 1),
	array(
		'form_key' => 'bio',
		'section_id' => 3,
		'type' => 'textarea',
		'html_name' => 'children',
		'html_id' => 'children',
		'html_rows' => 3,
		'label' => 'Children',
		'placeholder' => 'Enter your character\'s children here',
		'order' => 2),
	array(
		'form_key' => 'bio',
		'section_id' => 3,
		'type' => 'text',
		'html_name' => 'father',
		'html_id' => 'father',
		'html_rows' => 0,
		'label' => 'Father',
		'placeholder' => 'Father',
		'order' => 3),
	array(
		'form_key' => 'bio',
		'section_id' => 3,
		'type' => 'text',
		'html_name' => 'mother',
		'html_id' => 'mother',
		'html_rows' => 0,
		'label' => 'Mother',
		'placeholder' => 'Mother',
		'order' => 4),
	array(
		'form_key' => 'bio',
		'section_id' => 3,
		'type' => 'textarea',
		'html_name' => 'siblings',
		'html_id' => 'siblings',
		'html_rows' => 3,
		'label' => 'Siblings',
		'placeholder' => 'Enter your character\'s siblings here',
		'order' => 5),
	array(
		'form_key' => 'bio',
		'section_id' => 3,
		'type' => 'textarea',
		'html_name' => 'other_family',
		'html_id' => 'other_family',
		'html_rows' => 3,
		'label' => 'Other Family',
		'placeholder' => 'Enter your character\'s other family here',
		'order' => 6),
	array(
		'form_key' => 'bio',
		'section_id' => 4,
		'type' => 'textarea',
		'html_name' => 'personality',
		'html_id' => 'personality',
		'html_rows' => 5,
		'html_class' => 'span8',
		'label' => 'General Overview',
		'placeholder' => 'Enter your character\'s general personality overview here',
		'order' => 1),
	array(
		'form_key' => 'bio',
		'section_id' => 4,
		'type' => 'textarea',
		'html_name' => 'strengths',
		'html_id' => 'strengths',
		'html_rows' => 5,
		'html_class' => 'span8',
		'label' => 'Strengths &amp; Weaknesses',
		'placeholder' => 'Enter your character\'s strengths and weaknesses here',
		'order' => 2),
	array(
		'form_key' => 'bio',
		'section_id' => 4,
		'type' => 'textarea',
		'html_name' => 'ambitions',
		'html_id' => 'ambitions',
		'html_rows' => 5,
		'html_class' => 'span8',
		'label' => 'Ambitions',
		'placeholder' => 'Enter your character\'s ambitions here',
		'order' => 3),
	array(
		'form_key' => 'bio',
		'section_id' => 4,
		'type' => 'textarea',
		'html_name' => 'hobbies',
		'html_id' => 'hobbies',
		'html_rows' => 5,
		'html_class' => 'span8',
		'label' => 'Hobbies &amp; Interests',
		'placeholder' => 'Enter your character\'s hobbies and interests here',
		'order' => 4),
	array(
		'form_key' => 'bio',
		'section_id' => 4,
		'type' => 'textarea',
		'html_name' => 'languages',
		'html_id' => 'languages',
		'html_rows' => 2,
		'html_class' => 'span8',
		'label' => 'Languages',
		'placeholder' => 'Enter your character\'s known languages here',
		'order' => 5),
	array(
		'form_key' => 'bio',
		'section_id' => 5,
		'type' => 'textarea',
		'html_name' => 'history',
		'html_id' => 'history',
		'html_rows' => 15,
		'html_class' => 'span8',
		'label' => 'History',
		'placeholder' => 'Enter your character\'s personal history here',
		'order' => 1),
	array(
		'form_key' => 'bio',
		'section_id' => 5,
		'type' => 'textarea',
		'html_name' => 'service_record',
		'html_id' => 'service_record',
		'html_rows' => 15,
		'html_class' => 'span8',
		'label' => 'Service Record',
		'placeholder' => 'Enter your character\'s service record here',
		'order' => 2),
	array(
		'form_key' => 'specs',
		'section_id' => 7,
		'type' => 'text',
		'html_name' => 'class',
		'html_id' => 'class',
		'html_rows' => 0,
		'label' => 'Class',
		'placeholder' => 'Enter the class of vessel',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'section_id' => 7,
		'type' => 'text',
		'html_name' => 'role',
		'html_id' => 'role',
		'html_rows' => 0,
		'label' => 'Role',
		'placeholder' => 'Enter the role of the vessel',
		'order' => 1),
	array(
		'form_key' => 'specs',
		'section_id' => 7,
		'type' => 'text',
		'html_name' => 'duration',
		'html_id' => 'duration',
		'html_rows' => 0,
		'label' => 'Duration',
		'placeholder' => 'Enter the duration of the vessel',
		'order' => 2),
	array(
		'form_key' => 'specs',
		'section_id' => 7,
		'type' => 'text',
		'html_name' => 'refit',
		'html_id' => 'refit',
		'html_rows' => 0,
		'label' => 'Time Between Refits',
		'placeholder' => 'Enter the time between refits for this vessel',
		'order' => 3),
	array(
		'form_key' => 'specs',
		'section_id' => 7,
		'type' => 'text',
		'html_name' => 'resupply',
		'html_id' => 'resupply',
		'html_rows' => 0,
		'label' => 'Time Between Resupply',
		'placeholder' => 'Enter the time between resupply of this vessel',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'section_id' => 8,
		'type' => 'text',
		'html_name' => 'length',
		'html_id' => 'length',
		'html_rows' => 0,
		'label' => 'Length',
		'placeholder' => 'e.g. 415 meters',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'section_id' => 8,
		'type' => 'text',
		'html_name' => 'width',
		'html_id' => 'width',
		'html_rows' => 0,
		'label' => 'Width',
		'placeholder' => 'e.g. 75 meters',
		'order' => 1),
	array(
		'form_key' => 'specs',
		'section_id' => 8,
		'type' => 'text',
		'html_name' => 'height',
		'html_id' => 'height',
		'html_rows' => 0,
		'label' => 'Height',
		'placeholder' => 'e.g. 45 meters',
		'order' => 2),
	array(
		'form_key' => 'specs',
		'section_id' => 8,
		'type' => 'text',
		'html_name' => 'decks',
		'html_id' => 'decks',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Decks',
		'placeholder' => 'e.g. 10',
		'order' => 3),
	array(
		'form_key' => 'specs',
		'section_id' => 9,
		'type' => 'text',
		'html_name' => 'compliment_officers',
		'html_id' => 'compliment_officers',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Officers',
		'placeholder' => 'e.g. 60',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'section_id' => 9,
		'type' => 'text',
		'html_name' => 'compliment_enlisted',
		'html_id' => 'compliment_enlisted',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Enlisted Crew',
		'placeholder' => 'e.g. 500',
		'order' => 1),
	array(
		'form_key' => 'specs',
		'section_id' => 9,
		'type' => 'text',
		'html_name' => 'compliment_marines',
		'html_id' => 'compliment_marines',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Marines',
		'placeholder' => 'e.g. 48',
		'order' => 2),
	array(
		'form_key' => 'specs',
		'section_id' => 9,
		'type' => 'text',
		'html_name' => 'compliment_civilians',
		'html_id' => 'compliment_civilians',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Civilians',
		'placeholder' => 'e.g. 200',
		'order' => 3),
	array(
		'form_key' => 'specs',
		'section_id' => 9,
		'type' => 'text',
		'html_name' => 'compliment_emergency',
		'html_id' => 'compliment_emergency',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Emergency Capacity',
		'placeholder' => 'e.g. 2000',
		'order' => 4),
	array(
		'form_key' => 'specs',
		'section_id' => 10,
		'type' => 'text',
		'html_name' => 'speed_normal',
		'html_id' => 'speed_normal',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Cruise Speed',
		'placeholder' => 'e.g. Warp 6',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'section_id' => 10,
		'type' => 'text',
		'html_name' => 'speed_max',
		'html_id' => 'speed_max',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Maximum Speed',
		'placeholder' => 'e.g. Warp 9',
		'order' => 1),
	array(
		'form_key' => 'specs',
		'section_id' => 10,
		'type' => 'text',
		'html_name' => 'speed_emergency',
		'html_id' => 'speed_emergency',
		'html_rows' => 0,
		'html_class' => 'medium',
		'label' => 'Emergency Speed',
		'placeholder' => 'e.g. Warp 9.9975',
		'order' => 2),
	array(
		'form_key' => 'specs',
		'section_id' => 11,
		'type' => 'textarea',
		'html_name' => 'defensive',
		'html_id' => 'defensive',
		'html_rows' => 5,
		'label' => 'Shields',
		'placeholder' => 'e.g. Enter your vessel\'s defensive systems here',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'section_id' => 11,
		'type' => 'textarea',
		'html_name' => 'weapons',
		'html_id' => 'weapons',
		'html_rows' => 5,
		'label' => 'Weapon Systems',
		'placeholder' => 'e.g. Enter your vessel\'s weapon systems here',
		'order' => 1),
	array(
		'form_key' => 'specs',
		'section_id' => 11,
		'type' => 'textarea',
		'html_name' => 'armament',
		'html_id' => 'armament',
		'html_rows' => 5,
		'label' => 'Armament',
		'placeholder' => 'e.g. Enter your vessel\'s armament here',
		'order' => 2),
	array(
		'form_key' => 'specs',
		'section_id' => 12,
		'type' => 'text',
		'html_name' => 'shuttlebays',
		'html_id' => 'shuttlebays',
		'html_rows' => 0,
		'html_class' => 'small',
		'label' => 'Shuttlebays',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'section_id' => 12,
		'type' => 'textarea',
		'html_name' => 'shuttles',
		'html_id' => 'shuttles',
		'html_rows' => 5,
		'label' => 'Shuttles',
		'placeholder' => 'Enter your vessel\'s shuttles here',
		'order' => 1),
	array(
		'form_key' => 'specs',
		'section_id' => 12,
		'type' => 'textarea',
		'html_name' => 'fighters',
		'html_id' => 'fighters',
		'html_rows' => 5,
		'label' => 'Fighters',
		'placeholder' => 'Enter your vessel\'s fighters here',
		'order' => 2),
	array(
		'form_key' => 'specs',
		'section_id' => 12,
		'type' => 'textarea',
		'html_name' => 'runabouts',
		'html_id' => 'runabouts',
		'html_rows' => 5,
		'label' => 'Runabouts',
		'placeholder' => 'Enter your vessel\'s runabouts here',
		'order' => 3),
	array(
		'form_key' => 'tour',
		'type' => 'text',
		'html_name' => 'location',
		'html_id' => 'location',
		'html_rows' => 0,
		'label' => 'Location',
		'placeholder' => 'Enter the tour item\'s location here',
		'order' => 0),
	array(
		'form_key' => 'tour',
		'type' => 'textarea',
		'html_name' => 'long_desc',
		'html_id' => 'long_desc',
		'html_rows' => 5,
		'label' => 'Description',
		'placeholder' => 'Enter the tour item\'s description here',
		'order' => 1),
	array(
		'form_key' => 'user',
		'type' => 'text',
		'html_name' => 'location',
		'html_id' => 'location',
		'html_rows' => 0,
		'label' => 'Location',
		'placeholder' => 'Enter your location here',
		'order' => 0),
	array(
		'form_key' => 'user',
		'type' => 'textarea',
		'html_name' => 'interests',
		'html_id' => 'interests',
		'html_rows' => 5,
		'label' => 'Interests',
		'placeholder' => 'Enter your interests here',
		'order' => 1),
	array(
		'form_key' => 'user',
		'type' => 'textarea',
		'html_name' => 'bio',
		'html_id' => 'bio',
		'html_rows' => 5,
		'label' => 'Bio',
		'placeholder' => 'Enter your bio information here',
		'order' => 2),
);

$form_sections = array(
	array(
		'form_key' => 'bio',
		'tab_id' => 1,
		'name' => 'Character Information',
		'order' => 0),
	array(
		'form_key' => 'bio',
		'tab_id' => 1,
		'name' => 'Physical Appearance',
		'order' => 1),
	array(
		'form_key' => 'bio',
		'tab_id' => 1,
		'name' => 'Family',
		'order' => 2),
	array(
		'form_key' => 'bio',
		'tab_id' => 2,
		'name' => 'Personality &amp; Traits',
		'order' => 0),
	array(
		'form_key' => 'bio',
		'tab_id' => 3,
		'name' => '',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'name' => 'General',
		'order' => 0),
	array(
		'form_key' => 'specs',
		'name' => 'Dimensions',
		'order' => 1),
	array(
		'form_key' => 'specs',
		'name' => 'Personnel',
		'order' => 2),
	array(
		'form_key' => 'specs',
		'name' => 'Speed',
		'order' => 3),
	array(
		'form_key' => 'specs',
		'name' => 'Weapons &amp; Defensive Systems',
		'order' => 4),
	array(
		'form_key' => 'specs',
		'name' => 'Auxiliary Craft',
		'order' => 5),
);

$form_tabs = array(
	array(
		'form_key' => 'bio',
		'name' => 'Basic Info',
		'link_id' => 'one',
		'order' => 1),
	array(
		'form_key' => 'bio',
		'name' => 'Personality',
		'link_id' => 'two',
		'order' => 2),
	array(
		'form_key' => 'bio',
		'name' => 'History',
		'link_id' => 'three',
		'order' => 3),
);

$form_values = array(
	array(
		'field_id' => 1,
		'value' => 'Male',
		'content' => 'Male',
		'order' => 1),
	array(
		'field_id' => 1,
		'value' => 'Female',
		'content' => 'Female',
		'order' => 2),
	array(
		'field_id' => 1,
		'value' => 'Hermaphrodite',
		'content' => 'Hermaphrodite',
		'order' => 3),
	array(
		'field_id' => 1,
		'value' => 'Neuter',
		'content' => 'Neuter',
		'order' => 4),
);

$navigation = array(
	/**
	 * Main Navigation
	 */
	array(
		'name' => 'Main',
		'group' => 0,
		'order' => 0,
		'url' => 'main/index',
		'category' => 'main'),
	/*array(
		'name' => 'Personnel',
		'group' => 0,
		'order' => 1,
		'url' => 'personnel/index',
		'sim_type' => 1,
		'category' => 'main'),
	array(
		'name' => 'Sim',
		'group' => 0,
		'order' => 2,
		'url' => 'sim/index',
		'sim_type' => 1,
		'category' => 'main'),
	array(
		'name' => 'Wiki',
		'group' => 0,
		'order' => 3,
		'url' => 'wiki/index',
		'sim_type' => 1,
		'category' => 'main',
		'display' => (int) true),
	array(
		'name' => 'Forums',
		'group' => 0,
		'order' => 3,
		'url' => 'forums/index',
		'sim_type' => 1,
		'category' => 'main',
		'display' => (int) true),
	array(
		'name' => 'Search',
		'group' => 0,
		'order' => 4,
		'url' => 'search/index',
		'sim_type' => 1,
		'category' => 'main'),
	*/
	
	/**
	 * Sub Navigation
	 */	
	array(
		'name' => 'Main',
		'group' => 0,
		'order' => 0,
		'url' => 'main/index',
		'type' => 'sub',
		'category' => 'main'),
	/*array(
		'name' => 'Announcements',
		'group' => 0,
		'order' => 1,
		'url' => 'main/announcements',
		'type' => 'sub',
		'category' => 'main'),
	array(
		'name' => 'Contact',
		'group' => 0,
		'order' => 2,
		'url' => 'main/contact',
		'type' => 'sub',
		'category' => 'main'),*/
	array(
		'name' => 'Credits',
		'group' => 0,
		'order' => 3,
		'url' => 'main/credits',
		'type' => 'sub',
		'category' => 'main'),
	array(
		'name' => 'Join',
		'group' => 0,
		'order' => 4,
		'url' => 'main/join',
		'type' => 'sub',
		'category' => 'main'),
	/*array(
		'name' => 'Search',
		'group' => 1,
		'order' => 0,
		'url' => 'search/index',
		'type' => 'sub',
		'category' => 'main'),
	array(
		'name' => 'Manifest',
		'group' => 0,
		'order' => 0,
		'url' => 'personnel/index',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'personnel'),
	array(
		'name' => 'Chain of Command',
		'group' => 0,
		'order' => 1,
		'url' => 'personnel/coc',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'personnel'),
	array(
		'name' => 'Awards',
		'group' => 0,
		'order' => 2,
		'url' => 'sim/awards',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'personnel'),
	array(
		'name' => 'Join',
		'group' => 0,
		'order' => 3,
		'url' => 'main/join',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'personnel'),
	array(
		'name' => 'The Sim',
		'group' => 0,
		'order' => 0,
		'url' => 'sim/index',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Missions',
		'group' => 0,
		'order' => 1,
		'url' => 'sim/missions',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Mission Groups',
		'group' => 0,
		'order' => 2,
		'url' => 'sim/missions/group',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Personal Logs',
		'group' => 0,
		'order' => 3,
		'url' => 'sim/listlogs',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Stats',
		'group' => 0,
		'order' => 4,
		'url' => 'sim/stats',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Crew Awards',
		'group' => 0,
		'order' => 5,
		'url' => 'sim/awards',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Tour',
		'group' => 1,
		'order' => 0,
		'url' => 'sim/tour',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Specifications',
		'group' => 1,
		'order' => 1,
		'url' => 'sim/specs',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Deck Listing',
		'group' => 1,
		'order' => 2,
		'url' => 'sim/decks',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
	array(
		'name' => 'Departments',
		'group' => 1,
		'order' => 3,
		'url' => 'sim/departments',
		'sim_type' => 1,
		'type' => 'sub',
		'category' => 'sim'),
		
	array(
		'name' => 'Main Page',
		'group' => 0,
		'order' => 0,
		'url' => 'wiki/index',
		'sim_type' => 1,
		'display' => 1,
		'type' => 'sub',
		'category' => 'wiki'),
	array(
		'name' => 'Recent Changes',
		'group' => 0,
		'order' => 1,
		'url' => 'wiki/recent',
		'sim_type' => 1,
		'display' => 1,
		'type' => 'sub',
		'category' => 'wiki'),
	array(
		'name' => 'Categories',
		'group' => 0,
		'order' => 2,
		'url' => 'wiki/categories',
		'sim_type' => 1,
		'display' => 1,
		'type' => 'sub',
		'category' => 'wiki'),
	array(
		'name' => 'Manage Pages',
		'group' => 1,
		'order' => 0,
		'url' => 'wiki/managepages',
		'sim_type' => 1,
		'display' => 1,
		'type' => 'sub',
		'use_access' => 1,
		'access' => 'wiki/page',
		'needs_login' => 'y',
		'category' => 'wiki'),
	array(
		'name' => 'Manage Categories',
		'group' => 1,
		'order' => 1,
		'url' => 'wiki/managecategories',
		'sim_type' => 1,
		'display' => 1,
		'type' => 'sub',
		'use_access' => 1,
		'access' => 'wiki/categories',
		'needs_login' => 'y',
		'category' => 'wiki'),
	array(
		'name' => 'Create New Page',
		'group' => 2,
		'order' => 0,
		'url' => 'wiki/page',
		'sim_type' => 1,
		'display' => 1,
		'type' => 'sub',
		'use_access' => 1,
		'access' => 'wiki/page',
		'needs_login' => 'y',
		'category' => 'wiki'),
	*/
	
	/**
	 * Admin Main Navigation
	 */
	array(
		'name' => 'Control Panel',
		'group' => 0,
		'order' => 0,
		'url' => 'admin/index',
		'type' => 'admin',
		'category' => 'admin'),
	array(
		'name' => 'Messages',
		'group' => 0,
		'order' => 1,
		'type' => 'admin',
		'category' => 'messages',
		'access' => 'messages|read|0'),
	array(
		'name' => 'Writing',
		'group' => 0,
		'order' => 2,
		'type' => 'admin',
		'category' => 'write'),
	array(
		'name' => 'Manage',
		'group' => 0,
		'order' => 3,
		'type' => 'admin',
		'category' => 'manage'),
	array(
		'name' => 'Characters &amp; Users',
		'group' => 0,
		'order' => 4,
		'type' => 'admin',
		'category' => 'users'),
	array(
		'name' => 'Report Center',
		'group' => 0,
		'order' => 5,
		'url' => 'admin/report/index',
		'type' => 'admin',
		'category' => 'report',
		'access' => 'report|read|1'),

	/**
	 * Admin Sub Navigation
	 */
	array(
		'name' => 'Writing Control Panel',
		'group' => 0,
		'order' => 0,
		'url' => 'admin/write/index',
		'type' => 'adminsub',
		'category' => 'write'),
	array(
		'name' => 'Mission Post',
		'group' => 1,
		'order' => 0,
		'url' => 'admin/write/post',
		'type' => 'adminsub',
		'category' => 'write',
		'access' => 'post|create|0'),
	array(
		'name' => 'Personal Log',
		'group' => 1,
		'order' => 1,
		'url' => 'admin/write/log',
		'type' => 'adminsub',
		'category' => 'write',
		'access' => 'log|create|0'),
	array(
		'name' => 'Announcement',
		'group' => 1,
		'order' => 2,
		'url' => 'admin/write/announcement',
		'type' => 'adminsub',
		'category' => 'write',
		'access' => 'announcement|create|0'),
	array(
		'name' => 'Write New Message',
		'group' => 0,
		'order' => 0,
		'url' => 'admin/messages/write',
		'type' => 'adminsub',
		'category' => 'messages',
		'access' => 'messages|create|0'),
	array(
		'name' => 'Inbox',
		'group' => 1,
		'order' => 0,
		'url' => 'admin/messages/index',
		'type' => 'adminsub',
		'category' => 'messages',
		'access' => 'messages|read|0'),
	array(
		'name' => 'Sent Messages',
		'group' => 1,
		'order' => 1,
		'url' => 'admin/messages/sent',
		'type' => 'adminsub',
		'category' => 'messages',
		'access' => 'messages|read|0'),
	array(
		'name' => 'Site',
		'group' => 0,
		'order' => 0,
		'url' => 'admin/site/index',
		'type' => 'adminsub',
		'category' => 'manage',
		'access' => 'settings|read|0'),
	array(
		'name' => 'Data',
		'group' => 1,
		'order' => 0,
		'url' => 'admin/data/index',
		'type' => 'adminsub',
		'category' => 'manage',
		'access' => 'rank|read|0'),
	array(
		'name' => 'Forms',
		'group' => 2,
		'order' => 0,
		'url' => 'admin/form/index',
		'type' => 'adminsub',
		'category' => 'manage',
		'access' => 'form|read|0'),
	/*	
	array(
		'name' => 'Settings',
		'group' => 0,
		'order' => 0,
		'url' => 'site/settings',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/settings'),
	array(
		'name' => 'Messages &amp; Titles',
		'group' => 0,
		'order' => 1,
		'url' => 'site/messages',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/messages'),
	array(
		'name' => 'Menu Items',
		'group' => 0,
		'order' => 2,
		'url' => 'site/menus',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/menus'),
	array(
		'name' => 'Access Roles',
		'group' => 0,
		'order' => 3,
		'url' => 'site/roles',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/roles'),
	array(
		'name' => 'Bio Form',
		'group' => 1,
		'order' => 0,
		'url' => 'site/bioform',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/bioform'),
	array(
		'name' => 'Specs Form',
		'group' => 1,
		'order' => 1,
		'url' => 'site/specsform',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/specsform'),
	array(
		'name' => 'Tour Form',
		'group' => 1,
		'order' => 2,
		'url' => 'site/tourform',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/tourform'),
	array(
		'name' => 'Sim Types',
		'group' => 2,
		'order' => 0,
		'url' => 'site/simtypes',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/simtypes'),
	array(
		'name' => 'Rank Catalogue',
		'group' => 2,
		'order' => 1,
		'url' => 'site/catalogueranks',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/catalogueranks'),
	array(
		'name' => 'Skin Catalogue',
		'group' => 2,
		'order' => 2,
		'url' => 'site/catalogueskins',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'site',
		'use_access' => 1,
		'access' => 'site/catalogueskins'),
	array(
		'name' => 'Awards',
		'group' => 0,
		'order' => 0,
		'url' => 'manage/awards',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/awards'),
	array(
		'name' => 'Departments',
		'group' => 0,
		'order' => 1,
		'url' => 'manage/depts',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/depts'),
	array(
		'name' => 'Positions',
		'group' => 0,
		'order' => 2,
		'url' => 'manage/positions',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/positions'),
	array(
		'name' => 'Ranks',
		'group' => 0,
		'order' => 3,
		'url' => 'manage/ranks',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/ranks'),
	array(
		'name' => 'Missions',
		'group' => 1,
		'order' => 0,
		'url' => 'manage/missions',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/missions'),
	array(
		'name' => 'Mission Groups',
		'group' => 1,
		'order' => 1,
		'url' => 'manage/missiongroups',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/missions'),
	array(
		'name' => 'Mission Posts',
		'group' => 1,
		'order' => 2,
		'url' => 'manage/posts',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/posts'),
	array(
		'name' => 'Personal Logs',
		'group' => 1,
		'order' => 3,
		'url' => 'manage/logs',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/logs'),
	array(
		'name' => 'News Items',
		'group' => 1,
		'order' => 4,
		'url' => 'manage/news',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/news'),
	array(
		'name' => 'News Categories',
		'group' => 1,
		'order' => 5,
		'url' => 'manage/newscats',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/newscats'),
	array(
		'name' => 'Comments',
		'group' => 1,
		'order' => 6,
		'url' => 'manage/comments',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/comments'),
	array(
		'name' => 'Specs',
		'group' => 2,
		'order' => 0,
		'url' => 'manage/specs',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/specs'),
	array(
		'name' => 'Tour',
		'group' => 2,
		'order' => 1,
		'url' => 'manage/tour',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/tour'),
	array(
		'name' => 'Deck Listing',
		'group' => 2,
		'order' => 2,
		'url' => 'manage/decks',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'manage/decks'),
	array(
		'name' => 'Upload Images',
		'group' => 3,
		'order' => 0,
		'url' => 'upload/index',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 0),
	array(
		'name' => 'Manage Uploads',
		'group' => 3,
		'order' => 1,
		'url' => 'upload/manage',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'manage',
		'use_access' => 1,
		'access' => 'upload/manage'),
	array(
		'name' => 'All Characters',
		'group' => 0,
		'order' => 0,
		'url' => 'characters/index',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'characters',
		'use_access' => 1,
		'access' => 'characters/index'),
	array(
		'name' => 'All NPCs',
		'group' => 0,
		'order' => 1,
		'url' => 'characters/npcs',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'characters',
		'use_access' => 1,
		'access' => 'characters/npcs'),
	array(
		'name' => 'Create Character',
		'group' => 0,
		'order' => 2,
		'url' => 'characters/create',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'characters',
		'use_access' => 1,
		'access' => 'characters/create'),
	array(
		'name' => 'Give/Remove Awards',
		'group' => 1,
		'order' => 1,
		'url' => 'characters/awards',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'characters',
		'use_access' => 1,
		'access' => 'characters/awards'),
	array(
		'name' => 'My Account',
		'group' => 0,
		'order' => 0,
		'url' => 'admin/users/account',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'access' => 'user|update|1'),
	array(
		'name' => 'My Bio',
		'group' => 0,
		'order' => 1,
		'url' => 'characters/bio',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'use_access' => 1,
		'access' => 'characters/bio'),
	array(
		'name' => 'Site Options',
		'group' => 1,
		'order' => 0,
		'url' => 'user/options',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'use_access' => 1,
		'access' => 'user/account'),
	array(
		'name' => 'Request LOA',
		'group' => 0,
		'order' => 1,
		'url' => 'admin/users/status',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'access' => 'user|update|1'),
	array(
		'name' => 'Award Nominations',
		'group' => 0,
		'order' => 2,
		'url' => 'admin/users/nominate',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'access' => 'user|update|1'),
	array(
		'name' => 'All Users',
		'group' => 1,
		'order' => 0,
		'url' => 'admin/users/index',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'access' => 'user|read|0'),
	array(
		'name' => 'Link Characters',
		'group' => 1,
		'order' => 1,
		'url' => 'admin/users/link',
		'sim_type' => 1,
		'type' => 'adminsub',
		'category' => 'user',
		'access' => 'user|update|2'),
	*/
);

$settings = array(
	array(
		'key' => 'sim_name',
		'value' => '',
		'user_created' => (int) false),
	array(
		'key' => 'sim_year',
		'value' => '',
		'user_created' => (int) false),
	array(
		'key' => 'sim_type',
		'value' => 2,
		'user_created' => (int) false),
	array(
		'key' => 'maintenance',
		'value' => 'off',
		'help' => "Maintenance mode allows only admins to log in to the system while updates are being applied or other work is being done",
		'user_created' => (int) false),
	array(
		'key' => 'skin_main',
		'value' => 'default',
		'user_created' => (int) false),
	array(
		'key' => 'skin_admin',
		'value' => 'default',
		'user_created' => (int) false),
	array(
		'key' => 'skin_login',
		'value' => 'default',
		'user_created' => (int) false),
	array(
		'key' => 'display_rank',
		'value' => 'default',
		'user_created' => (int) false),
	array(
		'key' => 'system_email',
		'value' => 'on',
		'user_created' => (int) false),
	array(
		'key' => 'email_subject',
		'value' => '',
		'help' => "You can set the email subject prefix for every email that comes from the system. The default is your sim name inside brackets.",
		'user_created' => (int) false),
	array(
		'key' => 'email_name',
		'value' => '',
		'user_created' => (int) false),
	array(
		'key' => 'email_address',
		'value' => '',
		'help' => "To avoid some email services marking emails from Nova as spam, use this email address to set a specific address. This defaults to an address that should prevent this issue.",
		'user_created' => (int) false),
	array(
		'key' => 'timezone',
		'value' => 'UTC',
		'user_created' => (int) false),
	array(
		'key' => 'daylight_savings',
		'value' => 'false',
		'user_created' => (int) false),
	array(
		'key' => 'date_format',
		'value' => 'D M jS, Y @ g:ia',
		'user_created' => (int) false),
	array(
		'key' => 'updates',
		'value' => '4',
		'user_created' => (int) false),
	array(
		'key' => 'post_count_format',
		'value' => 'multiple',
		'help' => "Posts can be counted in two ways: one post no matter how many authors (single) or a post for each author (multiple)",
		'user_created' => (int) false),
	array(
		'key' => 'use_sample_post',
		'value' => 'y',
		'user_created' => (int) false),
	array(
		'key' => 'use_mission_notes',
		'value' => 'y',
		'user_created' => (int) false),
	array(
		'key' => 'online_timespan',
		'value' => '5',
		'help' => "This is used for the Who's Online feature and should be set in minutes. The higher the number, the less accurate the data, but the lower impact it'll have on the server.",
		'user_created' => (int) false),
	array(
		'key' => 'posting_requirement',
		'value' => 14,
		'help' => "The timespan (in days) that a player must post within. Set this to 0 to remove the requirement.",
		'user_created' => (int) false),
	array(
		'key' => 'login_attempts',
		'value' => 5,
		'help' => "The number of times a user can attempt to log in before being locked out. This feature exists to help protect sites against brute-force attacks.",
		'user_created' => (int) false),
	array(
		'key' => 'login_lockout_time',
		'value' => 15,
		'help' => "When a user is locked out because of too many log in attempts, this is the number of minutes they need to wait before logging in again. This goes hand-in-hand with the lockout system to protect against brute-force atatcks.",
		'user_created' => (int) false),
	array(
		'key' => 'meta_description',
		'value' => "Anodyne Productions' premier online RPG management software",
		'user_created' => (int) false),
	array(
		'key' => 'meta_keywords',
		'value' => "nova, rpg management, anodyne, rpg, sms",
		'user_created' => (int) false),
	array(
		'key' => 'meta_author',
		'value' => "Anodyne Productions",
		'user_created' => (int) false),
);

$sim_types = array(
	array('name' => 'all'),
	array('name' => 'ship'),
	array('name' => 'base'),
	array('name' => 'colony'),
	array('name' => 'unit'),
	array('name' => 'realm'),
	array('name' => 'planet'),
	array('name' => 'organization')
);

$site_contents = array(
	/**
	 * Headers
	 */
	array(
		'key' => 'login_index_header',
		'label' => 'Login Header',
		'content' => "Log In",
		'type' => 'header',
		'section' => 'login',
		'page' => 'index'),
	array(
		'key' => 'login_reset_header',
		'label' => 'Reset Password Header',
		'content' => "Reset Password",
		'type' => 'header',
		'section' => 'login',
		'page' => 'reset'),
	array(
		'key' => 'login_reset_confirm_header',
		'label' => 'Confirm Reset Password Header',
		'content' => "Confirm Password Reset",
		'type' => 'header',
		'section' => 'login',
		'page' => 'reset_confirm'),
	array(
		'key' => 'login_logout_header',
		'label' => 'Logout Header',
		'content' => "Logout",
		'type' => 'header',
		'section' => 'login',
		'page' => 'logout'),
	array(
		'key' => 'main_index_header',
		'label' => 'Main Page Header',
		'content' => "Welcome to Nova!",
		'type' => 'header',
		'section' => 'main',
		'page' => 'index'),
	array(
		'key' => 'main_credits_header',
		'label' => 'Site Credits Header',
		'content' => 'Site Credits',
		'type' => 'header',
		'section' => 'main',
		'page' => 'credits'),
	array(
		'key' => 'sim_index_header',
		'label' => 'Sim Header',
		'content' => "The Sim",
		'type' => 'header',
		'section' => 'sim',
		'page' => 'index'),
	array(
		'key' => 'admin_index_header',
		'label' => 'ACP Header',
		'content' => "Control Panel",
		'type' => 'header',
		'section' => 'admin',
		'page' => 'index'),
	array(
		'key' => 'admin_form_index_header',
		'label' => 'Form Management Header',
		'content' => "Forms",
		'type' => 'header',
		'section' => 'form',
		'page' => 'index'),

	/**
	 * Page Titles
	 */
	array(
		'key' => 'login_index_title',
		'label' => 'Login Page Title',
		'content' => "Log In",
		'type' => 'title',
		'section' => 'login',
		'page' => 'index'),
	array(
		'key' => 'login_reset_title',
		'label' => 'Reset Password Page Title',
		'content' => "Reset Password",
		'type' => 'title',
		'section' => 'login',
		'page' => 'reset'),
	array(
		'key' => 'login_reset_confirm_title',
		'label' => 'Confirm Reset Password Page Title',
		'content' => "Confirm Password Reset",
		'type' => 'title',
		'section' => 'login',
		'page' => 'reset_confirm'),
	array(
		'key' => 'login_logout_title',
		'label' => 'Logout Page Title',
		'content' => "Logout",
		'type' => 'title',
		'section' => 'login',
		'page' => 'logout'),
	array(
		'key' => 'main_index_title',
		'label' => 'Main Page Title',
		'content' => "Welcome to Nova!",
		'type' => 'title',
		'section' => 'main',
		'page' => 'index'),
	array(
		'key' => 'main_credits_title',
		'label' => 'Site Credits Page Title',
		'content' => 'Site Credits',
		'type' => 'title',
		'section' => 'main',
		'page' => 'credits'),
	array(
		'key' => 'sim_index_title',
		'label' => 'Sim Page Title',
		'content' => "The Sim",
		'type' => 'title',
		'section' => 'sim',
		'page' => 'index'),
	array(
		'key' => 'admin_index_title',
		'label' => 'ACP Page Title',
		'content' => "Control Panel",
		'type' => 'title',
		'section' => 'admin',
		'page' => 'index'),
	array(
		'key' => 'admin_form_index_title',
		'label' => 'Form Management Page Title',
		'content' => "Forms",
		'type' => 'title',
		'section' => 'form',
		'page' => 'index'),

	/**
	 * Messages
	 */
	array(
		'key' => 'login_reset_message',
		'label' => 'Reset Password Message',
		'content' => "To reset your password, simply enter your email address and a new password. You'll receive an email shortly with a link to confirm your password reset. If you log in to the site before confirming your password reset, the reset will be cancelled.",
		'type' => 'message',
		'section' => 'login',
		'page' => 'reset',
		'protected' => (int) true),
	array(
		'key' => 'login_reset_confirm_message',
		'label' => 'Confirm Reset Password Message',
		'content' => "The second step of the password reset process is confirmation. In order to complete your password reset, click the button below. Your password will be changed to the one you chose. If you did not request a password reset, you can simply log in to the site to cancel the reset request.",
		'type' => 'message',
		'section' => 'login',
		'page' => 'reset_confirm',
		'protected' => (int) true),
	array(
		'key' => 'main_index_message',
		'label' => 'Main Page Message',
		'content' => "Define your welcome message and welcome page header through the Site Content page.",
		'type' => 'message',
		'section' => 'main',
		'page' => 'index'),
	array(
		'key' => 'main_credits_message',
		'label' => 'Credits',
		'content' => "Define your site credits through the Site Messages page.",
		'type' => 'message',
		'section' => 'main',
		'page' => 'credits'),
	array(
		'key' => 'sim_index_message',
		'label' => 'Sim Message',
		'content' => "Define your sim message through the Site Content page.",
		'type' => 'message',
		'section' => 'sim',
		'page' => 'index'),
	array(
		'key' => 'admin_index_message',
		'label' => 'ACP Message',
		'content' => "Define your admin control panel through the Site Content page.",
		'type' => 'message',
		'section' => 'admin',
		'page' => 'index'),

	/**
	 * Other Messages
	 */
	array(
		'key' => 'credits_perm',
		'label' => 'Permanent Credits',
		'content' => "The Nova 3 experience can be summed up as \"smarter and better\". From the top down, Nova is faster, simpler, more flexible, and smarter than before. This is accomplished in no small part by the simple, flexible, and elegant PHP 5.3 foundation of <a href='http://fuelphp.com/' target='_blank'>FuelPHP</a>. The icons found throughout Nova are the tireless work of <a href='http://p.yusukekamiyamane.com/' target='_blank'>Yusuke Kamiyamane</a> (Fugue), <a href='http://pictos.cc' target='_blank'>Drew Wilson</a> (Pictos), and <a href='http://glyphicons.com/' target='_blank'>Jan Kovařík</a> (Glyphicons).",
		'protected' => (int) true,
		'type' => 'other'),
	array(
		'key' => 'footer',
		'label' => 'Additional Footer Information',
		'content' => "New to Nova 3 is the ability to add additional information to the footer, like banner exchanges, without having to edit any files. Just plug your code/message into the 'Additional Footer Information' site content item!",
		'type' => 'other'),
	array(
		'key' => 'join_disclaimer',
		'label' => 'Join Disclaimer',
		'content' => "Members are expected to follow the rules and regulations of both the sim and fleet at all times, both in character and out of character. By continuing, you affirm that you will sim in a proper and adequate manner. Members who choose to make ultra short posts, post very infrequently, or post posts with explicit content (above PG-13) will be removed immediately, and by continuing, you agree to this. In addition, in compliance with the Children's Online Privacy Protection Act of 1998 (COPPA), we do not accept players under the age of 13.  Any players found to be under the age of 13 will be immediately removed without question.  By agreeing to these terms, you are also saying that you are above the age of 13.",
		'type' => 'other'),
	array(
		'key' => 'join_post',
		'label' => 'Join Sample Post',
		'content' => "Define your join sample post through the Site Content page.",
		'type' => 'other'),
	array(
		'key' => 'accept_message',
		'label' => 'User Acceptance Email',
		'content' => "Define your user acceptance message through the Site Content page.",
		'type' => 'other'),
	array(
		'key' => 'reject_message',
		'label' => 'User Rejection Message',
		'content' => "Define your user rejection message through the Site Content page.",
		'type' => 'other'),
);

$system_info = array(
	array(
		'uid' => \Str::random('alnum', 32),
		'install_date' => time(),
		'version_major' => 3,
		'version_minor' => 0,
		'version_update' => 0)
);

$roles = array(
	array(
		'name' => 'Inactive User',
		'desc' => "Inactive users have no privileges within the system. This role is automatically assigned to any user with who has been retired.",
		'inherits' => ''),
	array(
		'name' => 'User',
		'desc' => "Every user in the system starts with these permissions. This role is automatically assigned to any user who is not retired.",
		'inherits' => ''),
	array(
		'name' => 'Active User',
		'desc' => "Every active user in the system has these permissions.",
		'inherits' => '2'),
	array(
		'name' => 'Power User',
		'desc' => "Power users are given more access to pieces of the system to help them assist the game master as necessary.",
		'inherits' => '2,3'),
	array(
		'name' => 'Administrator',
		'desc' => "Like power users, administrators are given higher permissions to the system to help them assist the game master as necessary.",
		'inherits' => '2,3,4'),
	array(
		'name' => 'System Administrator',
		'desc' => "System administrators have complete control over the system. This role should only be assigned to a select few individuals who are trusted to run the game.",
		'inherits' => '2,3,4,5'),
);

$roles_tasks = array(
	2 => array(1, 2, 3, 6),
	3 => array(14, 11, 18, 23, 33, 9, 20, 25, 88, 90, 37),
	4 => array(91, 12, 15, 28, 38),
	5 => array(21, 26, 31, 92, 94, 16, 17, 13, 7, 35, 36, 39),
	6 => array(4, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 89),
);

$tasks = array(
	/**
	 * Messages Actions
	 */
	array(
		'action' => 'create',
		'component' => 'messages',
		'level' => 0,
		'label' => 'Write Messages',
		'help' => 'Write and send messages to other users.'),
	array(
		'action' => 'read',
		'component' => 'messages',
		'level' => 0,
		'label' => 'Read Messages',
		'help' => 'Read own messages.'),
	array(
		'action' => 'delete',
		'component' => 'messages',
		'level' => 0,
		'label' => 'Delete Messages',
		'help' => 'Delete own messages.'),
	
	/**
	 * User Actions
	 */
	array(
		'action' => 'create',
		'component' => 'user',
		'level' => 0,
		'label' => 'Create User',
		'help' => ''),
	array(
		'action' => 'read',
		'component' => 'user',
		'level' => 0,
		'label' => 'View All Users',
		'help' => ''),
	array(
		'action' => 'edit',
		'component' => 'user',
		'level' => 1,
		'label' => 'Edit User (Level 1)',
		'help' => 'Update own user account.'),
	array(
		'action' => 'edit',
		'component' => 'user',
		'level' => 2,
		'label' => 'Edit User (Level 2)',
		'help' => 'Update any user account.'),
	array(
		'action' => 'delete',
		'component' => 'user',
		'level' => 0,
		'label' => 'Delete User',
		'help' => 'User accounts associated with a character who has content associated with their account (posts, logs, announcements) cannot be deleted.'),

	/**
	 * Character Actions
	 */
	array(
		'action' => 'create',
		'component' => 'character',
		'level' => 1,
		'label' => 'Create Character (Level 1)',
		'help' => 'Create a new non-playing character.'),
	array(
		'action' => 'create',
		'component' => 'character',
		'level' => 2,
		'label' => 'Create Character (Level 2)',
		'help' => 'Create a new character (playing and non-playing) and accept or reject new characters.'),
	array(
		'action' => 'read',
		'component' => 'character',
		'level' => 1,
		'label' => 'View Characters',
		'help' => 'See all characters associated with their account.'),
	array(
		'action' => 'read',
		'component' => 'character',
		'level' => 2,
		'label' => 'View Non-Playing Characters',
		'help' => 'See all non-playing characters.'),
	array(
		'action' => 'read',
		'component' => 'character',
		'level' => 3,
		'label' => 'View All Characters',
		'help' => 'See all characters.'),
	array(
		'action' => 'edit',
		'component' => 'character',
		'level' => 1,
		'label' => 'Edit Character (Level 1)',
		'help' => 'Update own character(s) bio.'),
	array(
		'action' => 'edit',
		'component' => 'character',
		'level' => 2,
		'label' => 'Edit Character (Level 2)',
		'help' => 'Update any non-playing character bio.'),
	array(
		'action' => 'edit',
		'component' => 'character',
		'level' => 3,
		'label' => 'Edit Character (Level 3)',
		'help' => 'Update any character bio.'),
	array(
		'action' => 'delete',
		'component' => 'character',
		'level' => 0,
		'label' => 'Delete Character',
		'help' => 'Characters who have content (posts, logs, announcements, etc.) cannot be deleted.'),

	/**
	 * Mission Post Actions
	 */
	array(
		'action' => 'create',
		'component' => 'post',
		'level' => 0,
		'label' => 'Create Post',
		'help' => ''),
	array(
		'action' => 'read',
		'component' => 'post',
		'level' => 0,
		'label' => 'View Mission Posts',
		'help' => 'See all non-activated mission posts.'),
	array(
		'action' => 'edit',
		'component' => 'post',
		'level' => 1,
		'label' => 'Edit Post (Level 1)',
		'help' => 'Update own mission posts.'),
	array(
		'action' => 'edit',
		'component' => 'post',
		'level' => 2,
		'label' => 'Edit Post (Level 2)',
		'help' => 'Update any mission post.'),
	array(
		'action' => 'delete',
		'component' => 'post',
		'level' => 0,
		'label' => 'Delete Post',
		'help' => ''),

	/**
	 * Personal Log Actions
	 */
	array(
		'action' => 'create',
		'component' => 'log',
		'level' => 0,
		'label' => 'Create Log',
		'help' => ''),
	array(
		'action' => 'read',
		'component' => 'log',
		'level' => 0,
		'label' => 'View Personal Logs',
		'help' => 'See all non-activated personal logs.'),
	array(
		'action' => 'edit',
		'component' => 'log',
		'level' => 1,
		'label' => 'Edit Log (Level 1)',
		'help' => 'Update own personal logs.'),
	array(
		'action' => 'edit',
		'component' => 'log',
		'level' => 2,
		'label' => 'Edit Log (Level 2)',
		'help' => 'Update any personal log.'),
	array(
		'action' => 'delete',
		'component' => 'log',
		'level' => 0,
		'label' => 'Delete Log',
		'help' => ''),

	/**
	 * Announcement Actions
	 */
	array(
		'action' => 'create',
		'component' => 'announcement',
		'level' => 0,
		'label' => 'Create Announcement',
		'help' => ''),
	array(
		'action' => 'read',
		'component' => 'announcement',
		'level' => 0,
		'label' => 'View Announcements',
		'help' => 'See all non-activated announcements.'),
	array(
		'action' => 'edit',
		'component' => 'announcement',
		'level' => 1,
		'label' => 'Edit Announcement (Level 1)',
		'help' => 'Update own announcements.'),
	array(
		'action' => 'edit',
		'component' => 'announcement',
		'level' => 2,
		'label' => 'Edit Announcement (Level 2)',
		'help' => 'Update any announcement.'),
	array(
		'action' => 'delete',
		'component' => 'announcement',
		'level' => 0,
		'label' => 'Delete Announcement',
		'help' => ''),

	/**
	 * Comment Actions
	 */
	array(
		'action' => 'create',
		'component' => 'comment',
		'level' => 0,
		'label' => 'Create Comment',
		'help' => ''),
	array(
		'action' => 'read',
		'component' => 'comment',
		'level' => 0,
		'label' => 'View All Comments',
		'help' => 'See all non-activated comments.'),
	array(
		'action' => 'edit',
		'component' => 'comment',
		'level' => 0,
		'label' => 'Edit Comment',
		'help' => ''),
	array(
		'action' => 'delete',
		'component' => 'comment',
		'level' => 0,
		'label' => 'Delete Comment',
		'help' => ''),

	/**
	 * Report Actions
	 */
	array(
		'action' => 'read',
		'component' => 'report',
		'level' => 1,
		'label' => 'View Reports (Level 1)',
		'help' => 'See the sim stats and milestone reports.'),
	array(
		'action' => 'read',
		'component' => 'report',
		'level' => 2,
		'label' => 'View Reports (Level 2)',
		'help' => 'See the crew activity and posting reports as well as all level 1 reports.'),
	array(
		'action' => 'read',
		'component' => 'report',
		'level' => 3,
		'label' => 'View Reports (Level 3)',
		'help' => 'See the LOA and award nomination reports as well as all level 1 and 2 reports.'),
	array(
		'action' => 'read',
		'component' => 'report',
		'level' => 4,
		'label' => 'View Reports (Level 4)',
		'help' => 'See all system reports.'),

	/**
	 * Ban Actions
	 */
	array(
		'action' => 'create',
		'component' => 'ban',
		'level' => 0,
		'label' => 'Create Ban',
		'help' => ''),
	array(
		'action' => 'read',
		'component' => 'ban',
		'level' => 0,
		'label' => 'View All Bans',
		'help' => ''),
	array(
		'action' => 'edit',
		'component' => 'ban',
		'level' => 0,
		'label' => 'Edit Ban',
		'help' => ''),
	array(
		'action' => 'delete',
		'component' => 'ban',
		'level' => 0,
		'label' => 'Delete Ban',
		'help' => ''),

	/**
	 * Position Actions
	 */
	array(
		'action' => 'create',
		'component' => 'position',
		'level' => 0,
		'label' => 'Create Position',
		'help' => ''),
	array(
		'action' => 'read',
		'component' => 'position',
		'level' => 0,
		'label' => 'View All Positions',
		'help' => ''),
	array(
		'action' => 'edit',
		'component' => 'position',
		'level' => 0,
		'label' => 'Edit Position',
		'help' => ''),
	array(
		'action' => 'delete',
		'component' => 'position',
		'level' => 0,
		'label' => 'Delete Position',
		'help' => ''),

	/**
	 * Rank Actions
	 */
	array(
		'action' => 'create',
		'component' => 'rank',
		'level' => 0,
		'label' => 'Create Rank',
		'help' => ''),
	array(
		'action' => 'read',
		'component' => 'rank',
		'level' => 0,
		'label' => 'View All Ranks',
		'help' => ''),
	array(
		'action' => 'edit',
		'component' => 'rank',
		'level' => 0,
		'label' => 'Edit Rank',
		'help' => ''),
	array(
		'action' => 'delete',
		'component' => 'rank',
		'level' => 0,
		'label' => 'Delete Rank',
		'help' => ''),

	/**
	 * Department Actions
	 */
	array(
		'action' => 'create',
		'component' => 'department',
		'level' => 0,
		'label' => 'Create Department',
		'help' => ''),
	array(
		'action' => 'read',
		'component' => 'department',
		'level' => 0,
		'label' => 'View All Departments',
		'help' => ''),
	array(
		'action' => 'edit',
		'component' => 'department',
		'level' => 0,
		'label' => 'Edit Department',
		'help' => ''),
	array(
		'action' => 'delete',
		'component' => 'department',
		'level' => 0,
		'label' => 'Delete Department',
		'help' => ''),

	/**
	 * Catalog Actions
	 */
	array(
		'action' => 'create',
		'component' => 'catalog',
		'level' => 0,
		'label' => 'Create Catalog',
		'help' => ''),
	array(
		'action' => 'read',
		'component' => 'catalog',
		'level' => 0,
		'label' => 'View All Catalogs',
		'help' => ''),
	array(
		'action' => 'edit',
		'component' => 'catalog',
		'level' => 0,
		'label' => 'Edit Catalog',
		'help' => ''),
	array(
		'action' => 'delete',
		'component' => 'catalog',
		'level' => 0,
		'label' => 'Delete Catalog',
		'help' => ''),

	/**
	 * Form Actions
	 */
	array(
		'action' => 'read',
		'component' => 'form',
		'level' => 0,
		'label' => 'View All Forms',
		'help' => ''),
	array(
		'action' => 'edit',
		'component' => 'form',
		'level' => 0,
		'label' => 'Edit Form',
		'help' => ''),
	array(
		'action' => 'delete',
		'component' => 'form',
		'level' => 0,
		'label' => 'Delete Form',
		'help' => ''),

	/**
	 * Navigation Actions
	 */
	array(
		'action' => 'create',
		'component' => 'nav',
		'level' => 0,
		'label' => 'Create Navigation Item',
		'help' => ''),
	array(
		'action' => 'read',
		'component' => 'nav',
		'level' => 0,
		'label' => 'View All Navigation',
		'help' => ''),
	array(
		'action' => 'edit',
		'component' => 'nav',
		'level' => 0,
		'label' => 'Edit Navigation',
		'help' => ''),
	array(
		'action' => 'delete',
		'component' => 'nav',
		'level' => 0,
		'label' => 'Delete Navigation Item',
		'help' => ''),

	/**
	 * Role Actions
	 */
	array(
		'action' => 'create',
		'component' => 'role',
		'level' => 0,
		'label' => 'Create Role',
		'help' => ''),
	array(
		'action' => 'read',
		'component' => 'role',
		'level' => 0,
		'label' => 'View All Roles',
		'help' => ''),
	array(
		'action' => 'edit',
		'component' => 'role',
		'level' => 0,
		'label' => 'Edit Role',
		'help' => ''),
	array(
		'action' => 'delete',
		'component' => 'role',
		'level' => 0,
		'label' => 'Delete Role',
		'help' => ''),

	/**
	 * Content Actions
	 */
	array(
		'action' => 'create',
		'component' => 'content',
		'level' => 0,
		'label' => 'Create Content',
		'help' => ''),
	array(
		'action' => 'read',
		'component' => 'content',
		'level' => 0,
		'label' => 'View All Content',
		'help' => ''),
	array(
		'action' => 'edit',
		'component' => 'content',
		'level' => 0,
		'label' => 'Edit Content',
		'help' => ''),
	array(
		'action' => 'delete',
		'component' => 'content',
		'level' => 0,
		'label' => 'Delete Content',
		'help' => ''),

	/**
	 * Settings Actions
	 */
	array(
		'action' => 'create',
		'component' => 'settings',
		'level' => 0,
		'label' => 'Create Setting',
		'help' => ''),
	array(
		'action' => 'read',
		'component' => 'settings',
		'level' => 0,
		'label' => 'View All Settings',
		'help' => ''),
	array(
		'action' => 'edit',
		'component' => 'settings',
		'level' => 0,
		'label' => 'Edit Setting',
		'help' => ''),
	array(
		'action' => 'delete',
		'component' => 'settings',
		'level' => 0,
		'label' => 'Delete Setting',
		'help' => ''),

	/**
	 * Specs Actions
	 */
	array(
		'action' => 'create',
		'component' => 'specs',
		'level' => 0,
		'label' => 'Create Specification',
		'help' => ''),
	array(
		'action' => 'read',
		'component' => 'specs',
		'level' => 0,
		'label' => 'View All Specifications',
		'help' => ''),
	array(
		'action' => 'edit',
		'component' => 'specs',
		'level' => 0,
		'label' => 'Edit Specification',
		'help' => ''),
	array(
		'action' => 'delete',
		'component' => 'specs',
		'level' => 0,
		'label' => 'Delete Specification',
		'help' => ''),

	/**
	 * Tour Actions
	 */
	array(
		'action' => 'create',
		'component' => 'tour',
		'level' => 0,
		'label' => 'Create Tour',
		'help' => ''),
	array(
		'action' => 'read',
		'component' => 'tour',
		'level' => 0,
		'label' => 'View All Tour Items',
		'help' => ''),
	array(
		'action' => 'edit',
		'component' => 'tour',
		'level' => 0,
		'label' => 'Edit Tour',
		'help' => ''),
	array(
		'action' => 'delete',
		'component' => 'tour',
		'level' => 0,
		'label' => 'Delete Tour',
		'help' => ''),

	/**
	 * Wiki Actions
	 */
	array(
		'action' => 'create',
		'component' => 'wiki',
		'level' => 1,
		'label' => 'Create Wiki Page',
		'help' => ''),
	array(
		'action' => 'create',
		'component' => 'wiki',
		'level' => 2,
		'label' => 'Create Wiki Categories',
		'help' => ''),
	array(
		'action' => 'edit',
		'component' => 'wiki',
		'level' => 1,
		'label' => 'Edit Wiki (Level 1)',
		'help' => 'Update own wiki pages'),
	array(
		'action' => 'edit',
		'component' => 'wiki',
		'level' => 2,
		'label' => 'Edit Wiki (Level 2)',
		'help' => 'Update and revert all wiki pages'),
	array(
		'action' => 'edit',
		'component' => 'wiki',
		'level' => 3,
		'label' => 'Edit Wiki (Level 3)',
		'help' => 'Update wiki categories'),
	array(
		'action' => 'delete',
		'component' => 'wiki',
		'level' => 1,
		'label' => 'Delete Wiki Page',
		'help' => ''),
	array(
		'action' => 'delete',
		'component' => 'wiki',
		'level' => 2,
		'label' => 'Delete Wiki Categories',
		'help' => ''),

	# TODO: forum actions
);
