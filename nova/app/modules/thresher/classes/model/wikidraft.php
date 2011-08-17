<?php
/**
 * Wiki Draft Model
 *
 * @package		Thresher
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_WikiDraft extends Model {
	
	public static $_table_name = 'wiki_drafts';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'id_old' => array(
			'type' => 'int',
			'constraint' => 11),
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
		'summary' => array(
			'type' => 'text'),
		'content' => array(
			'type' => 'text'),
		'page_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'created_at' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'categories' => array(
			'type' => 'text'),
		'change_comments' => array(
			'type' => 'text'),
	);
}
