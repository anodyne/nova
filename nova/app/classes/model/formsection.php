<?php
/**
 * Form Sections Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_FormSection extends Model {
	
	public static $_table_name = 'form_sections';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 10,
			'auto_increment' => true),
		'form_key' => array(
			'type' => 'string',
			'constraint' => 20,
			'default' => ''),
		'tab_id' => array(
			'type' => 'int',
			'constraint' => 10),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'order' => array(
			'type' => 'int',
			'constraint' => 5),
	);
}
