<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Security Questions Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Securityquestion extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('security_questions');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'question_id'
			)),
			'value' => Jelly::field('text', array(
				'column' => 'question_value'
			)),
		));
	}
}