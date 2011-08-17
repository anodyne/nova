<?php
/**
 * Wiki Restriction Model
 *
 * @package		Thresher
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */
 
class Model_WikiRestriction extends Model {
	
	public static $_table_name = 'wiki_restrictions';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'page_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'created_at' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'created_by' => array(
			'type' => 'int',
			'constraint' => 8),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'updated_by' => array(
			'type' => 'int',
			'constraint' => 8),
		'restrictions' => array(
			'type' => 'text'),
	);
}
