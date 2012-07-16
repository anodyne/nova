<?php
/**
 * Chain of Command Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Coc;

class Model_Coc extends \Model {
	
	public static $_table_name = 'coc';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 5,
			'auto_increment' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
	);
	
	public static $_belongs_to = array(
		'user' => array(
			'model_to' => '\\Model_User',
			'key_to' => 'id',
			'key_from' => 'user_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'character' => array(
			'model_to' => '\\Model_Character',
			'key_to' => 'id',
			'key_from' => 'character_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
