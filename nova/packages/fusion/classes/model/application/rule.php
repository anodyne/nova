<?php
/**
 * Application Rule Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Application_Rule extends \Model {
	
	public static $_table_name = 'application_rules';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'type' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => 'all'),
		'condition' => array(
			'type' => 'text',
			'null' => true),
		'users' => array(
			'type' => 'text',
			'null' => true),
	);
}
