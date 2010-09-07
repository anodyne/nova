<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Form Tabs Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Formtab extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('forms_tabs');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'tab_id'
			)),
			'form' => Jelly::field('belongsto', array(
				'column' => 'tab_form',
				'foreign' => 'form.key'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'tab_name'
			)),
			'linkid' => Jelly::field('string', array(
				'column' => 'tab_link_id'
			)),
			'order' => Jelly::field('integer', array(
				'column' => 'tab_order'
			)),
			'display' => Jelly::field('enum', array(
				'column' => 'tab_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
		));
	}
}