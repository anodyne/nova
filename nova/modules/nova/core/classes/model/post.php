<?php
/**
 * Mission Posts Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Post extends Orm\Model {
	
	public static $_table_name = 'posts';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 8,
			'auto_increment' => true),
		'title' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'location' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'timeline' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'authors' => array(
			'type' => 'text'),
		'authors_users' => array(
			'type' => 'text'),
		'mission_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'saved_user_id' => array(
			'type' => 'int',
			'constriant' => 8),
		'status' => array(
			'type' => 'enum',
			'constraint' => "'activated','saved','pending'",
			'default' => 'activated'),
		'content' => array(
			'type' => 'text'),
		'tags' => array(
			'type' => 'text'),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
	
	public static $_belongs_to = array(
		'mission' => array(
			'model_to' => 'Model_Mission',
			'key_to' => 'id',
			'key_from' => 'mission_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	/**
	 * Get all the comments for a mission entry.
	 *
	 *     $post = Model_Post::find(1);
	 *     $comments = $post->comments();
	 *
	 * @access	public
	 * @param	string	the status of items to retrieve
	 * @return	object	an object with all the comments
	 */
	public function comments($status = 'activated')
	{
		return static::find('all', array(
			'where' => array(
				array('type', 'post'),
				array('status', $status),
				array('item_id', $this->id)
			),
		));
	}
}
