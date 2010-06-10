<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Login Attempts Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Loginattempt extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('login_attempts');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'login_id'
			)),
			'ip' => new Field_String(array(
				'column' => 'login_ip'
			)),
			'email' => new Field_Email(array(
				'column' => 'login_email'
			)),
			'date' => new Field_Timestamp(array(
				'column' => 'login_time',
				'auto_now_create' => TRUE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
		));
	}
}