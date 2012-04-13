<?php
/**
 * Messages Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Message extends \Model {
	
	public static $_table_name = 'messages';
	
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
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'subject' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'content' => array(
			'type' => 'text',
			'null' => true),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
	);
	
	public static $_has_many = array(
		'messages' => array(
			'model_to' => '\\Model_MessageRecipient',
			'key_to' => 'message_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
