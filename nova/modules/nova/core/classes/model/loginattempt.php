<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Login Attempts Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Loginattempt extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('login_attempts');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'login_id'
			)),
			'ip' => Jelly::field('string', array(
				'column' => 'login_ip'
			)),
			'email' => Jelly::field('email', array(
				'column' => 'login_email'
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'login_time',
				'auto_now_create' => true,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
		));
	}
}
