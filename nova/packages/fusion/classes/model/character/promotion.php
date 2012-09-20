<?php
/**
 * Character Promotions Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Character_Promotion extends \Model
{
	public static $_table_name = 'character_promotions';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'auto_increment' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'old_order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'old_rank' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'new_order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'new_rank' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'created_at' => array(
			'type' => 'datetime'),
	);
}
