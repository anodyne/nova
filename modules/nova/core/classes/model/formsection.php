<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Form Sections Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Formsection extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('forms_sections');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'section_id'
			)),
			'form' => Jelly::field('belongsto', array(
				'column' => 'section_form',
				'foreign' => 'form.key'
			)),
			'tab' => Jelly::field('belongsto', array(
				'column' => 'section_tab',
				'foreign' => 'formtab'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'section_name'
			)),
			'order' => Jelly::field('integer', array(
				'column' => 'section_order'
			)),
		));
	}
}
