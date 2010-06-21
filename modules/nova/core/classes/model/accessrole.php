<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Access Role Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Accessrole extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('access_roles');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'role_id'
			)),
			'name' => new Field_String(array(
				'column' => 'role_name'
			)),
			'pages' => new Field_Text(array(
				'column' => 'role_access',
			)),
			'desc' => new Field_Text(array(
				'column' => 'role_desc',
			)),
		));
	}
}