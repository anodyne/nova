<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Menu Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Menu extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('menu_items');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'menu_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'menu_name'
			)),
			'group' => Jelly::field('integer', array(
				'column' => 'menu_group'
			)),
			'order' => Jelly::field('integer', array(
				'column' => 'menu_order'
			)),
			'link' => Jelly::field('text', array(
				'column' => 'menu_link'
			)),
			'linktype' => Jelly::field('enum', array(
				'column' => 'menu_link_type',
				'choices' => array('onsite','offsite'),
				'default' => 'onsite'
			)),
			'login' => Jelly::field('enum', array(
				'column' => 'menu_need_login',
				'choices' => array('y','n','none'),
				'default' => 'none'
			)),
			'useaccess' => Jelly::field('enum', array(
				'column' => 'menu_use_access',
				'choices' => array('y','n'),
				'default' => 'n'
			)),
			'access' => Jelly::field('string', array(
				'column' => 'menu_access'
			)),
			'level' => Jelly::field('integer', array(
				'column' => 'menu_access_level'
			)),
			'type' => Jelly::field('enum', array(
				'column' => 'menu_type',
				'choices' => array('main','sub','adminsub'),
				'default' => 'main'
			)),
			'cat' => Jelly::field('belongsto', array(
				'column' => 'menu_cat',
				'foreign' => 'menu_categories.menucat_menu_cat'
			)),
			'display' => Jelly::field('enum', array(
				'column' => 'menu_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
			'simtype' => Jelly::field('belongsto', array(
				'column' => 'menu_sim_type',
				'foreign' => 'simtype'
			)),
		));
	}
}