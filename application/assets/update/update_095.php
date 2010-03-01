<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| UPDATE - 0.9.5 => 0.9.6
|---------------------------------------------------------------
*/

/*
|---------------------------------------------------------------
| VERSION INFO FOR THE DATABASE
|---------------------------------------------------------------
*/

$system_versions = array(
	'version'			=> '0.9.6',
	'version_major'		=> 0,
	'version_minor'		=> 9,
	'version_update'	=> 6,
	'version_date'		=> 1264903200,
	'version_launch'	=> 'Nova 0.9.6 is an update to the beta release of the next generation RPG management software from Anodyne Productions. This version is the final public beta build and is considered a release candidate for Nova 1.0.',
	'version_changes'	=> "* added the 0.9.6 update file
* added the new jquery ui css files
* added the uniform jquery plugin
* added a javascript view for the upload index
* removed the old jquery ui css files
* removed the changes doc
* updated the install data
    * system info
    * system versions info
    * component info
* updated the database schema
    * users::daylight\_savings from enum to varchar
* updated the genre files
    * MOV
    * BAJ
    * ENT
    * TOS
    * KLI
    * ROM
    * BL5
    * AND
    * DS9
* updated the language files
    * [text\_lang] added _text\_dynamic\_emails_
    * [install\_lang] updated _upd\_error\_2_
* updated the sunny skin
    * removed the notes document
    * updated the skin.yml file
    * updated the wiki template file
    * updated the admin template file
    * [admin] updated the images
    * [admin] updated the stylesheets
         * updated the skin stylesheet to match the main section
         * udpated the structure stylesheet to match the main section
    * [wiki] updated the images
    * [wiki] updated the stylesheets
         * updated the skin stylesheet to match the main section
         * udpated the structure stylesheet to match the main section
* updated the titan skin
    * updated the skin.yml file
    * updated the wiki template file
    * [admin] updated the images
    * [admin] updated the stylesheets
         * updated the skin stylesheet to match the main section
         * udpated the structure stylesheet to match the main section
    * [main] updated the stylesheets
    * [wiki] updated the images
    * [wiki] updated the stylesheets
         * updated the skin stylesheet to match the main section
         * udpated the structure stylesheet to match the main section
* updated the dynamic emails to use both sim and ship (ship is left to maintain SMS upgrade compatability)
* updated the way updates are checked to use PHP's version\_compare function
* updated the constants config file
* updated the docking model methods to be listed alphabetically
* updated the jquery ui to version 1.8rc2
* updated the head include files with the new jquery ui css naming scheme
* updated all the skins with the new naming scheme
* updated the user section view files to use the new form layout
* updated the characters section view files to use the new form layout
* updated the skin stylesheets to tweak the new form layout
* updated the manage section view files to use the new form layout on some pages
* updated the site section view files to use the new form layout on some pages
* updated the admin section to clean up some UI inconsistencies
* updated thresher to clean up some UI inconsistencies
* updated markItUp! to version 1.1.6.1
* updated the site settings page to use the form layout
* updated the site settings page to handle rank selection better
* updated the update controller with the registration code
* updated the upgrade controller with the registration code
* updated jquery to version 1.4.2
* updated the controller constructors to cast the daylight savings value as a boolean instead of doing logic against it
* updated files to remove some of the remaining TODOs
* updated the install and upgrade process to try and automatically set the welcome page title
* fixed bug where the site messages always showed the type as page title (#74)
* fixed bug where the system versions accordion broke when there were multiple versions
* fixed bug where the system versions threw an error when only one version was in the database
* fixed bug where thresher threw errors when submitting a page without categories
* fixed bug where thresher still wasn't printing categories properly (should be completely fixed now)
* fixed bug where thresher was missing some language elements
* fixed bug where the rank ajax menus always showed the default rank set (#75)
* fixed bug with the install rank ajax menu where it wasn't passing the right information to the ajax method
* fixed bug with the registration process in the install controller"
);

$system_info = array(
	'sys_last_update'		=> now(),
	'sys_version_major'		=> 0,
	'sys_version_minor'		=> 9,
	'sys_version_update'	=> 6
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

if (isset($add_tables))
{
	foreach ($add_table as $key => $value)
	{
		$this->dbforge->add_field($$value['fields']);
		$this->dbforge->add_key($value['id'], TRUE);
		$this->dbforge->create_table($key, TRUE);
	}
}

/*
|---------------------------------------------------------------
| TABLES TO DROP
|
| $drop_tables = array('table_name');
|---------------------------------------------------------------
*/

if (isset($drop_tables))
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

if (isset($rename_tables))
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

if (isset($add_column))
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
	'users' => array(
		'daylight_savings' => array(
			'name' => 'daylight_savings',
			'type' => 'VARCHAR',
			'constraint' => 1,
			'default' => '0')
	)
);

if (isset($modify_column))
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

if (isset($drop_column))
{
	foreach ($drop_column as $key => $value)
	{
		$this->dbforge->drop_column($key, $value[0]);
	}
}

/*
|---------------------------------------------------------------
| DATA TO INSERT/UPDATE/DELETE
|---------------------------------------------------------------
*/

/* jquery version info */
$this->db->where('comp_name', 'jQuery');
$this->db->update('system_components', array('comp_version' => '1.4.2'));

/* jquery ui version info */
$this->db->where('comp_name', 'jQuery UI');
$this->db->update('system_components', array('comp_version' => '1.8rc2'));

/* markitup version info */
$this->db->where('comp_name', 'markItUp!');
$this->db->update('system_components', array('comp_version' => '1.1.6.1'));

/* textile info */
$this->db->where('comp_name', 'Textile');
$this->db->update('system_components', array('comp_desc' => "Textile is a lightweight markup language that converts its marked-up text input to valid, well-formed XHTML and also inserts character entity references for apostrophes, opening and closing single and double quotation marks, ellipses and em dashes."));

/* new jquery plugin component */
$array = array(
	'comp_name' => 'Uniform',
	'comp_version' => '1.5',
	'comp_desc' => "Uniform masks your standard form controls with custom themed controls. It works in sync with your real form elements to ensure accessibility and compatibility.",
	'comp_url' => 'http://pixelmatrixdesign.com/uniform/'
);
$this->db->insert('system_components', $array);

/* add system version info */
$this->load->model('system_model', 'sys');
$this->sys->add_system_version($system_versions);

/* End of file update_095.php */
/* Location: ./application/assets/update/update_095.php */