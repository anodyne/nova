<?php
/**
 * Private Messages To Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_PrivateMessageTo extends Orm\Model {
	
	public static $_table_name = 'private_messages_to';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'auto_increment' => true),
		'message_id' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'unread' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
	);
	
	public static $_belongs_to = array(
		'pm' => array(
			'model_to' => 'Model_PrivateMessage',
			'key_to' => 'id',
			'key_from' => 'message_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
