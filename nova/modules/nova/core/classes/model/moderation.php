<?php
/**
 * User Moderation Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Moderation extends Orm\Model {
	
	public static $_table_name = 'moderation';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 8,
			'auto_increment' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'type' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
}
