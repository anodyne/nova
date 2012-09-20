<?php
/**
 * Awards Received Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Award_Receive extends \Model
{
	public static $_table_name = 'award_received';
	
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
		'created_at' => array(
			'type' => 'datetime'),
	);
}
