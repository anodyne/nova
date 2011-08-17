<?php
/**
 * Personal Logs Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_PersonalLog extends Model {
	
	public static $_table_name = 'personal_logs';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 5,
			'auto_increment' => true),
		'title' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'content' => array(
			'type' => 'text'),
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'status' => array(
			'type' => 'enum',
			'constraint' => "'activated','saved','pending'",
			'default' => 'activated'),
		'tags' => array(
			'type' => 'text'),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
	
	public static $_belongs_to = array(
		'character' => array(
			'model_to' => 'Model_Character',
			'key_to' => 'id',
			'key_from' => 'character_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'user' => array(
			'model_to' => 'Model_User',
			'key_to' => 'id',
			'key_from' => 'user_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	/**
	 * Get all the comments for a personal log.
	 *
	 *     $log = Model_PersonalLog::find(1);
	 *     $comments = $log->comments();
	 *
	 * @access	public
	 * @param	string	the status of items to retrieve
	 * @return	object	an object with all the comments
	 */
	public function comments($status = 'activated')
	{
		return Model_Comment::find('all', array(
			'where' => array(
				array('type', 'log'),
				array('status', $status),
				array('item_id', $this->id)
			),
		));
	}
}
