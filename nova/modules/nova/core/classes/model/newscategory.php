<?php
/**
 * News Categories Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_NewsCategory extends Orm\Model {
	
	public static $_table_name = 'news_categories';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 5,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
	);
	
	public static $_has_many = array(
		'newsitems' => array(
			'model_to' => 'Model_News',
			'key_to' => 'category_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
