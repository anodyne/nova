<?php
/**
 * Awards Queue Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_AwardQueue extends Model {
	
	public static $_table_name = 'awards_queue';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 8,
			'auto_increment' => true),
		'receive_character_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'receive_user_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'nominate_character_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'award_id' => array(
			'type' => 'int',
			'constraint' => 5),
		'reason' => array(
			'type' => 'text'),
		'status' => array(
			'type' => 'enum',
			'constraint' => "'pending','accepted','rejected'",
			'default' => 'pending'),
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
}
