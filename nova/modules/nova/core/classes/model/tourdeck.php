<?php
/**
 * Tour Decks Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_TourDeck extends Orm\Model {
	
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
