<?php
/**
 * Message Recipients Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_MessageRecipient extends \Model
{
	public static $_table_name = 'message_recipients';
	
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
			'constraint' => 11),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'unread' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::ACTIVE),
	);
	
	/**
	 * Relationships
	 */
	public static $_belongs_to = array(
		'pm' => array(
			'model_to' => '\\Model_Message',
			'key_to' => 'id',
			'key_from' => 'message_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
