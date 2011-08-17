<?php
/**
 * Tour Decks Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */
 
class Model_TourDeck extends Model {
	
	public static $_table_name = 'tour_decks';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 10,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'order' => array(
			'type' => 'int',
			'constraint' => 5),
		'content' => array(
			'type' => 'text'),
		'tour_id' => array(
			'type' => 'int',
			'constraint' => 5),
	);
	
	public static $_belongs_to = array(
		'tour' => array(
			'model_to' => 'Model_Tour',
			'key_to' => 'id',
			'key_from' => 'tour_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
