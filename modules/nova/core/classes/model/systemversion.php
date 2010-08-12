<?php defined('SYSPATH') or die('No direct script access.');
/**
 * System Versions Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Systemversion extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('system_versions');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'version_id'
			)),
			'version' => Jelly::field('string', array(
				'column' => 'version'
			)),
			'major' => Jelly::field('integer', array(
				'column' => 'version_major'
			)),
			'minor' => Jelly::field('integer', array(
				'column' => 'version_minor'
			)),
			'update' => Jelly::field('integer', array(
				'column' => 'version_update'
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'version_date',
				'null' => TRUE,
				'default' => date::now()
			)),
			'launch' => Jelly::field('text', array(
				'column' => 'version_launch',
			)),
			'changes' => Jelly::field('text', array(
				'column' => 'version_changes',
			)),
		));
	}
}