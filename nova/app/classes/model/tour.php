<?php
/**
 * Tour Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Tour extends Model {
	
	public static $_table_name = 'tour';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 5,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'order' => array(
			'type' => 'int',
			'constraint' => 5),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'images' => array(
			'type' => 'text'),
		'summary' => array(
			'type' => 'text'),
		'spec_id' => array(
			'type' => 'int',
			'constraint' => 5),
	);
	
	public static $_belongs_to = array(
		'spec' => array(
			'model_to' => 'Model_Spec',
			'key_to' => 'id',
			'key_from' => 'spec_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
