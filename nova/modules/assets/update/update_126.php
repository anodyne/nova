<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Update Nova from 1.2.6 to 2.0
 */
$system_info	= null;
$add_tables		= null;
$drop_tables	= null;
$rename_tables	= null;
$add_column		= null;
$modify_column	= null;
$drop_column	= null;

/**
 * Version info for the database
 */
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

// update the upload images menu item
$this->db->where('menu_link', 'upload/index');
$this->db->update('menu_items', array('menu_use_access' => 'y', 'menu_access' => 'upload/index'));

// update the sent messages menu item
$this->db->where('menu_name', 'Sent Messages');
$this->db->update('menu_items', array('menu_link' => 'messages/sent'));

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
