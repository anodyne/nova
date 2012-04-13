# Form

array(
	'key' => 'docking',
	'name' => 'Docking Form'),

# Form Fields

array(
	'form_key' => 'docking',
	'section_id' => 6,
	'type' => 'text',
	'html_name' => 'duration',
	'html_id' => 'duration',
	'html_rows' => 0,
	'label' => 'Duration',
	'placeholder' => 'Enter the duration of your stay',
	'order' => 1),
array(
	'form_key' => 'docking',
	'section_id' => 6,
	'type' => 'textarea',
	'html_name' => 'reason',
	'html_id' => 'reason',
	'html_rows' => 5,
	'label' => 'Reason for Docking',
	'placeholder' => 'Enter your reason for docking here',
	'order' => 2),

# Form Sections

array(
	'form_key' => 'docking',
	'name' => 'Details',
	'order' => 0),

# Navigation Items

array(
	'name' => 'Docked Items',
	'group' => 2,
	'order' => 0,
	'url' => 'sim/docked',
	'sim_type' => 3,
	'display' => 0,
	'type' => 'sub',
	'category' => 'sim'),
array(
	'name' => 'Docking Request',
	'group' => 2,
	'order' => 1,
	'url' => 'sim/dockingrequest',
	'sim_type' => 3,
	'display' => 0,
	'type' => 'sub',
	'category' => 'sim'),
array(
	'name' => 'Docked Items',
	'group' => 2,
	'order' => 3,
	'url' => 'manage/docked',
	'sim_type' => 3,
	'type' => 'adminsub',
	'category' => 'manage',
	'use_access' => 1,
	'access' => 'manage/docked'),