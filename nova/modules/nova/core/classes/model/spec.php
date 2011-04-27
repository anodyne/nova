<?php
/**
 * Specs Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Spec extends Orm\Model {
	
	public static $_table_name = 'specs';
	
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
	);
	
	public static $_has_many = array(
		'tour' => array(
			'model_to' => 'Model_Tour',
			'key_to' => 'spec_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'decks' => array(
			'model_to' => 'Model_TourDeck',
			'key_to' => 'spec_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
