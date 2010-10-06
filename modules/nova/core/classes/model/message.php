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
	
	/**
	 * Overrides the unique key functionality so that the model will understand
	 * both numeric values for primary keys and string values for the name key.
	 *
	 * @param	mixed	value to use as the unique key
	 * @return	object	the primary key or name key object
	 */
	public function unique_key($value)
	{
		if (is_numeric($value))
		{
			return $this->_meta->primary_key();
		}
		else
		{
			return $this->_meta->name_key();
		}
	}
}