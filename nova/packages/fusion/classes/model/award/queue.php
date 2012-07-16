<?php
/**
 * Awards Queue Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Award_Queue extends \Model {
	
	public static $_table_name = 'awards_queue';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'receive_character_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'receive_user_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'nominate_character_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'award_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'reason' => array(
			'type' => 'text',
			'null' => true),
		'status' => array(
			'type' => 'enum',
			'constraint' => "'pending','accepted','rejected'",
			'default' => 'pending'),
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
}
