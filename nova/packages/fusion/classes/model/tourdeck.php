<?php
/**
 * Tour Decks Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_TourDeck extends \Model {
	
	public static $_table_name = 'tour_decks';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'content' => array(
			'type' => 'text',
			'null' => true),
		'tour_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
	);
	
	public static $_belongs_to = array(
		'tour' => array(
			'model_to' => '\\Model_Tour',
			'key_to' => 'id',
			'key_from' => 'tour_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
