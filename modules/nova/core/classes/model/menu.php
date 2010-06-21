<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Menu Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Menu extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('menu_items');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'menu_id'
			)),
			'name' => new Field_String(array(
				'column' => 'menu_name'
			)),
			'group' => new Field_Integer(array(
				'column' => 'menu_group'
			)),
			'order' => new Field_Integer(array(
				'column' => 'menu_order'
			)),
			'link' => new Field_Text(array(
				'column' => 'menu_link'
			)),
			'linktype' => new Field_Enum(array(
				'column' => 'menu_link_type',
				'choices' => array('onsite','offsite'),
				'default' => 'onsite'
			)),
			'login' => new Field_Enum(array(
				'column' => 'menu_need_login',
				'choices' => array('y','n','none'),
				'default' => 'none'
			)),
			'useaccess' => new Field_Enum(array(
				'column' => 'menu_use_access',
				'choices' => array('y','n'),
				'default' => 'n'
			)),
			'access' => new Field_String(array(
				'column' => 'menu_access'
			)),
			'level' => new Field_Integer(array(
				'column' => 'menu_access_level'
			)),
			'type' => new Field_Enum(array(
				'column' => 'menu_type',
				'choices' => array('main','sub','adminsub'),
				'default' => 'main'
			)),
			'cat' => new Field_BelongsTo(array(
				'column' => 'menu_cat',
				'foreign' => 'menu_categories.menucat_menu_cat'
			)),
			'display' => new Field_Enum(array(
				'column' => 'menu_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
			'simtype' => new Field_BelongsTo(array(
				'column' => 'menu_sim_type',
				'foreign' => 'simtype'
			)),
		));
	}
}