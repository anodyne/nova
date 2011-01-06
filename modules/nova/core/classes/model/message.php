<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Messages Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Message extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->name_key('key');
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
}
