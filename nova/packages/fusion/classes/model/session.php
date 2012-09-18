<?php
/**
 * Sessions Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Session extends \Model
{
	public static $_table_name = 'sessions';
	
	public static $_properties = array(
		'session_id' => array(
			'type' => 'string',
			'constraint' => 40),
		'previous_id' => array(
			'type' => 'string',
			'constraint' => 40),
		'user_agent' => array(
			'type' => 'text'),
		'ip_hash' => array(
			'type' => 'char',
			'constraint' => 32),
		'created' => array(
			'type' => 'int',
			'constraint' => 11),
		'updated' => array(
			'type' => 'int',
			'constraint' => 11),
		'payload' => array(
			'type' => 'longtext'),
	);
}
