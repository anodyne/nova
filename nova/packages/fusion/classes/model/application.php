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
	
	const IN_PROGRESS	= 1;
	const APPROVED 		= 2;
	const REJECTED 		= 3;

	public static $_table_name = 'applications';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'position_id' => array(
			'type' => 'string',
			'constraint' => 255),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'experience' => array(
			'type' => 'text',
			'null' => true),
		'hear_about' => array(
			'type' => 'string',
			'constraint' => 50,
			'null' => true),
		'hear_about_detail' => array(
			'type' => 'text',
			'null' => true),
		'sample_post' => array(
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
	protected static $_belongs_to = array(
		'character' => array(
			'model_to' => '\\Model_Character',
			'key_to' => 'id',
			'key_from' => 'character_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'position' => array(
			'model_to' => '\\Model_Position',
			'key_to' => 'id',
			'key_from' => 'position_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'user' => array(
			'model_to' => '\\Model_User',
			'key_to' => 'id',
			'key_from' => 'user_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	protected static $_has_many = array(
		'reviewers' => array(
			'model_to' => '\\Model_Application_Reviewer',
			'key_to' => 'app_id',
			'key_from' => 'id',
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

	public static function find_items($only_active = true)
	{
		$query = static::find();

		if ($only_active)
		{
			$query->where('status', static::IN_PROGRESS);
		}

		return $query->get();
	}
}
