<?php defined('SYSPATH') or die('No direct script access.');
/**
 * System Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_System extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('system_info');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'sys_id'
			)),
			'uid' => Jelly::field('string', array(
				'column' => 'sys_uid'
			)),
			'install_date' => Jelly::field('timestamp', array(
				'column' => 'sys_install_date',
				'null' => TRUE,
				'default' => date::now()
			)),
			'last_update' => Jelly::field('timestamp', array(
				'column' => 'sys_last_update',
				'null' => TRUE,
				'default' => date::now()
			)),
			'version_major' => Jelly::field('integer', array(
				'column' => 'sys_version_major',
			)),
			'version_minor' => Jelly::field('integer', array(
				'column' => 'sys_version_minor',
			)),
			'version_update' => Jelly::field('integer', array(
				'column' => 'sys_version_update',
			)),
			'ignore' => Jelly::field('string', array(
				'column' => 'sys_version_ignore',
			)),
		));
	}
}