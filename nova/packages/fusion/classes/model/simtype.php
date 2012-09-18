<?php
/**
 * Sim Type Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_SimType extends \Model
{
	public static $_table_name = 'sim_types';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 2,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 50),
	);
}
