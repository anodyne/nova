<?php
/**
 * Security Questions Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_SecurityQuestion extends Orm\Model {
	
	public static $_table_name = 'security_questions';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 5,
			'auto_increment' => true),
		'value' => array(
			'type' => 'text'),
	);
	
	/**
	 * Get all the security questions.
	 *
	 * @access	public
	 * @return	object	an object of all the questions
	 */
	public static function get_questions()
	{
		return static::find('all');
	}
}
