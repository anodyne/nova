<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Messages Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @since		3.0
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
	 * Find a single message in the database.
	 *
	 * @access	public
	 * @param	int		the key of the message to pull
	 * @param	bool	whether to return just the value or the entire object
	 * @return	mixed	a Jelly_Collection if there are results or FALSE if there are no results
	 */
	public static function find($key, $only_value = true)
	{
		$result = Jelly::query('message', $key)->limit(1)->select();
		
		if (count($result) > 0)
		{
			if ($only_value)
			{
				return $result->value;
			}
			
			return $result;
		}
		
		return false;
	}
}
