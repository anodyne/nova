<?php
/**
 * Form Tabs Model
 *
 * *NOTE:* The link_id field does not reference another field in the database,
 * it is used by jQuery UI to build the clickable tab.
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_FormTab extends Model {
	
	public static $_table_name = 'form_tabs';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 10,
			'auto_increment' => true),
		'form_key' => array(
			'type' => 'string',
			'constraint' => 20,
			'default' => ''),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'link_id' => array(
			'type' => 'string',
			'constraint' => 20,
			'default' => ''),
		'order' => array(
			'type' => 'int',
			'constraint' => 5),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
	);
}
