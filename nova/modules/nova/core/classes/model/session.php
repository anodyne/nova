<?php
/**
 * Sessions Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Session extends Orm\Model {
	
	public static $_table_name = 'sessions';
	
	public static $_properties = array(
		'session_id' => array(
			'type' => 'string',
			'constraint' => 24,
			'default' => '0'),
		'last_active' => array(
			'type' => 'int',
			'unsigned' => true),
		'contents' => array(
			'type' => 'text'),
	);
}
