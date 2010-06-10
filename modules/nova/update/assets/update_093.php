<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| UPDATE - 0.9.3 => 0.9.4
|---------------------------------------------------------------
*/

/*
|---------------------------------------------------------------
| VERSION INFO FOR THE DATABASE
|---------------------------------------------------------------
*/

$system_versions = array(
	'version'			=> '0.9.4',
	'version_major'		=> 0,
	'version_minor'		=> 9,
	'version_update'	=> 4,
	'version_date'		=> 1264903200,
	'version_launch'	=> 'Nova 0.9.4 is an update to the beta release of the next generation RPG management software from Anodyne Productions.',
	'version_changes'	=> "* added the jquery.ui.mouse file
	* added the jquery.ui.widget file
* added the 0.9.4 update file
* updated the mission management page to use the datepicker
* updated the version info in the constants file
* updated the basic install data
    * version information
    * system information
    * jquery component information
    * jquery ui component information
    * removed textboxlist from components list
* updated the database schema
    * added the wiki category description field
* updated the index files in the core directory to use the proper line endings (unix) and encoding (utf8)
* updated the beta skin
    * added the skin.yml file
    * updated the main logo files
    * [admin] removed unused images
    * [admin] updated the skin images
    * [admin] updated the footer of the template
    * [admin] updated the stylesheets
        * added styling for accordion lists
        * updated the skin.css file to match with some of the changes from the login's skin.css
    * [login] removed unused image files
    * [login] updated the image files
    * [login] updated the stylesheets
        * updated the styles to be cleaner and use better practices
        * updated the skin.css file to remove unused styles
        * updated the structure.css file to remove unused styles
    * [main] removed unused images
    * [main] updated the skin images
    * [main] updated the footer of the template
    * [main] updated the stylesheets
        * updated the skin.css file to match with some of the changes from the login's skin.css
    * [wiki] removed the textboxlist images
    * [wiki] removed the textboxlist stylesheets
    * [wiki] removed unused images
    * [wiki] updated the skin images
    * [wiki] updated the footer of the template
    * [wiki] updated the stylesheets
        * updated the skin.css file to match with some of the changes from the login's skin.css
* updated the sunny skin
    * updated the main logo files
    * [admin] updated the stylesheets
        * added styling for accordion lists
    * [main] updated the stylesheets
        * updated the alt row color
        * added the info-full class
    * [login] updated the stylesheets
        * updated the skin.css file to match changes made to main's skin.css
        * updated the skin.css file to remove unused styles
        * updated the structure.css file to remove unused styles
    * [login] removed the ui.theme.css file
    * [login] removed the unused jquery ui theme images
    * [wiki] added the proper images
    * [wiki] removed unused images
    * [wiki] removed the textboxlist images
    * [wiki] removed the textboxlist stylesheets
    * [wiki] updated the stylesheets
        * updated to look like the main section
        * updated the alt row color
        * updated the textboxlist styles to remove the focus shadow
        * added the markitup link fix
* updated the lightness skin
    * [admin] updated the stylesheets
        * added styling for accordion lists
    * [login] updated the stylesheets
        * updated the skin.css file to remove unused styles
        * updated the structure.css file to remove unused styles
	* [wiki] removed the textboxlist images
    * [wiki] removed the textboxlist stylesheets
    * updated the main logo files
* updated the titan skin
	* [wiki] removed the textboxlist images
    * [wiki] removed the textboxlist stylesheets
* updated the redmond skin
    * [login] updated the nova small logo
    * [login] updated the stylesheets
        * updated the skin.css file to remove unused styles
        * updated the structure.css file to remove unused styles
	* [wiki] removed the textboxlist images
    * [wiki] removed the textboxlist stylesheets
* updated jquery to version 1.4.1
* updated jquery ui to version 1.8rc1
* updated the head include files to pull in the jquery.ui.widget file which is now required
* updated the admin's head include file to set some depencies for the ui widgets
* updated the language files
    * [install\_lang] added key _update\_required_
    * [install\_lang] updated key _update\_outofdate\_database_ to change plurality of 'links' to 'link'
    * [base\_lang] added key _actions\_run_
* updated the update template to not have a copyright statement
* updated the install template to not have a copyright statement
* updated the update versions array
* updated the manage wiki categories page to allow creating a description
* updated the wiki head include to pull in the qtip plugin
* updated the wiki head include to not pull the textboxlist plugin
* updated the wiki page creation to use a different manner of selecting categories
* updated the wiki categories to handle a description as well
* updated the jquery ui images to the base theme
* updated the jquery ui theme stylesheet to the base theme
* updated the version history to use the Markdown parser
* updated the version history accordion to be collapsible
* removed old jquery ui files (version 1.8 uses a new naming scheme for the .js files)
* removed test update file
* removed the version.xml file
* fixed bug where the update panel wasn't showing the proper information at the right times (#71)
* fixed bug where viewing a wiki page or draft with fewer than 2 categories wouldn't display the category
* fixed bug with position sliders not updating the proper item (#72)"
);

$system_info = array(
	'sys_last_update'		=> now(),
	'sys_version_major'		=> 0,
	'sys_version_minor'		=> 9,
	'sys_version_update'	=> 4
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

$add_column = array(
	'wiki_categories' => array(
		'wikicat_desc' => array('type' => 'TEXT')
	),
);

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
$this->db->update('system_components', array('comp_version' => '1.4.1'));

/* jquery ui version info */
$this->db->where('comp_name', 'jQuery UI');
$this->db->update('system_components', array('comp_version' => '1.8rc1'));

/* jquery ui version info */
$this->db->delete('system_components', array('comp_name' => 'TextboxList'));

/* add system version info */
$this->load->model('system_model', 'sys');
$this->sys->add_system_version($system_versions);

/* End of file update_093.php */
/* Location: ./application/assets/update/update_093.php */