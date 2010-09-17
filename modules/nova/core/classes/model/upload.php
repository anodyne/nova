<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Uploads Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Upload extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'upload_id'
			)),
			'filename' => Jelly::field('text', array(
				'column' => 'upload_filename'
			)),
			'mime' => Jelly::field('string', array(
				'column' => 'upload_mime_type'
			)),
			'resource' => Jelly::field('string', array(
				'column' => 'upload_resource_type'
			)),
			'user' => Jelly::field('belongsto', array(
				'column' => 'upload_user',
				'foreign' => 'user'
			)),
			'ip' => Jelly::field('string', array(
				'column' => 'upload_ip'
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'upload_date',
				'auto_now_create' => TRUE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
		));
	}
}