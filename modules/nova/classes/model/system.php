<?php defined('SYSPATH') or die('No direct script access.');
/**
 * System Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_System extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('system_info');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'sys_id'
			)),
			'uid' => new Field_String(array(
				'column' => 'sys_uid'
			)),
			'install_date' => new Field_Timestamp(array(
				'column' => 'sys_install_date',
				'null' => TRUE
			)),
			'last_update' => new Field_Timestamp(array(
				'column' => 'sys_last_update',
				'null' => TRUE
			)),
			'version_major' => new Field_Integer(array(
				'column' => 'sys_version_major',
			)),
			'version_minor' => new Field_Integer(array(
				'column' => 'sys_version_minor',
			)),
			'version_update' => new Field_Integer(array(
				'column' => 'sys_version_update',
			)),
			'ignore' => new Field_String(array(
				'column' => 'sys_version_ignore',
			)),
		));
	}
}