<?php
/**
 * Application Model
 *
 * *NOTE:* The user, character and positions fields do not use the _id naming
 * convention because they may not necessarily be tied to the current item at
 * that ID.
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Application extends Orm\Model {
	
	public static $_table_name = 'applications';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 10,
			'auto_increment' => true),
		'email' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'user' => array(
			'type' => 'int',
			'constraint' => 8),
		'user_name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'character' => array(
			'type' => 'int',
			'constraint' => 8),
		'character_name' => array(
			'type' => 'text'),
		'position' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'action' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'message' => array(
			'type' => 'text'),
	);
}
