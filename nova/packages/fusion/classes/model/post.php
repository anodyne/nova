<?php
/**
 * Mission Posts Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Post extends \Model {
	
	public static $_table_name = 'posts';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'title' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'location' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'timeline' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'mission_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'saved_user_id' => array(
			'type' => 'int',
			'constriant' => 11,
			'null' => true),
		'status' => array(
			'type' => 'enum',
			'constraint' => "'activated','saved','pending'",
			'default' => 'activated'),
		'content' => array(
			'type' => 'text',
			'null' => true),
		'tags' => array(
			'type' => 'text',
			'null' => true),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
		'participants' => array(
			'type' => 'text',
			'null' => true),
		'lock_user_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
		'lock_date' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
	);
	
	public static $_belongs_to = array(
		'mission' => array(
			'model_to' => '\\Model_Mission',
			'key_to' => 'id',
			'key_from' => 'mission_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	public static $_many_many = array(
		'authors_users' => array(
			'model_to' => '\\Model_User',
			'key_to' => 'id',
			'key_from' => 'id',
			'key_through_from' => 'post_id',
			'key_through_to' => 'user_id',
			'table_through' => 'post_authors',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'authors_characters' => array(
			'model_to' => '\\Model_Character',
			'key_to' => 'id',
			'key_from' => 'id',
			'key_through_from' => 'post_id',
			'key_through_to' => 'character_id',
			'table_through' => 'post_authors',
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
	 * @api
	 * @param	string	the status of items to retrieve
	 * @return	object	an object with all the comments
	 */
	public function comments($status = 'activated')
	{
		return \Model_Comment::find('all', array(
			'where' => array(
				array('type', 'post'),
				array('status', $status),
				array('item_id', $this->id)
			),
		));
	}
	
	/**
	 * Display the authors for a mission post.
	 *
	 *     $post = Model_Post::find(1);
	 *     echo $post->display_authors();
	 *
	 * @api
	 * @param	string	the type of authors to display (characters, users)
	 * @return	string	the string of authors
	 */
	public function display_authors($type = 'characters')
	{
		$output = array();
		
		switch ($type)
		{
			case 'characters':
				foreach ($this->authors_characters as $a)
				{
					$output[] = $a->name();
				}
			break;
			
			case 'users':
				foreach ($this->authors_users as $a)
				{
					$output[] = $a->name;
				}
			break;
		}
		
		return implode(' &amp; ', $output);
	}
}
