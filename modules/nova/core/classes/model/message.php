<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Messages Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Message extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * *This model is automatically initialized by the base controller as <code>$this->mMessages</code>. The only time you
	 * need to initialize this class is in the event you are not working with the base controller.*
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'message_id'
			)),
			'key' => Jelly::field('string', array(
				'column' => 'message_key'
			)),
			'value' => Jelly::field('text', array(
				'column' => 'message_content'
			)),
			'label' => Jelly::field('string', array(
				'column' => 'message_label'
			)),
			'message_type' => Jelly::field('enum', array(
				'choices' => array('title','message','other'),
				'default' => 'message'
			)),
			'message_protected' => Jelly::field('enum', array(
				'choices' => array('y','n'),
				'default' => 'n'
			)),
		));
	}
	
	/**
	 * Pulls back a message from the database based on its message key.
	 *
	 *     echo $this->mMessages->get_message('message_key');
	 *
	 * @param	string	the message key
	 * @return	string	the message
	 */
	public function get_message($key)
	{
		$query = Jelly::select('message')->where('key', '=', $key)->load();
		
		return $query->value;
	}
}