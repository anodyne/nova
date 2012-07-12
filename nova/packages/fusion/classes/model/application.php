<?php
/**
 * Application Model
 *
 * *NOTE:* The user, character and positions fields do not use the _id naming
 * convention because they may not necessarily be tied to the current item at
 * that ID.
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Application extends \Model {
	
	public static $_table_name = 'applications';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'email' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'ip_address' => array(
			'type' => 'string',
			'constraint' => 16,
			'null' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'user_name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'character_name' => array(
			'type' => 'text',
			'null' => true),
		'position' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'action' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'message' => array(
			'type' => 'text',
			'null' => true),
		'created_at' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
	);

	/**
	 * Relationships
	 */
	public static $_belongs_to = array(
		'character' => array(
			'model_to' => '\\Model_Character',
			'key_to' => 'id',
			'key_from' => 'character_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'\\Application' => array(
			'events' => array('after_insert')
		),
		'\\Orm\\Observer_CreatedAt' => array(
			'events' => array('before_insert')
		),
		'\\Orm\\Observer_UpdatedAt' => array(
			'events' => array('before_save')
		),
	);
}
