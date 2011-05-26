<?php
/**
 * Wiki Category Model
 *
 * @package		Thresher
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_WikiCategory extends Model {
	
	public static $_table_name = 'wiki_categories';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 8,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'desc' => array(
			'type' => 'text'),
	);
}
