<?php
/**
 * Private Messages Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_PrivateMessage extends Orm\Model {
	
	public static $_table_name = 'private_messages';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'auto_increment' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'subject' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'content' => array(
			'type' => 'text'),
		'author_display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
	);
	
	public static $_has_many = array(
		'messages' => array(
			'model_to' => 'Model_PrivateMessageTo',
			'key_to' => 'message_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
