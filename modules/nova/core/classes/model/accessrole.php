<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Access Role Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Accessrole extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('access_roles');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'role_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'role_name'
			)),
			'pages' => Jelly::field('text', array(
				'column' => 'role_access',
			)),
			'desc' => Jelly::field('text', array(
				'column' => 'role_desc',
			)),
		));
	}
}
