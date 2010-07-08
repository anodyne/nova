<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Form Tabs Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Formtab extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('forms_tabs');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'tab_id'
			)),
			'form' => new Field_BelongsTo(array(
				'column' => 'tab_form',
				'foreign' => 'form.key'
			)),
			'name' => new Field_String(array(
				'column' => 'tab_name'
			)),
			'linkid' => new Field_String(array(
				'column' => 'tab_link_id'
			)),
			'order' => new Field_Integer(array(
				'column' => 'tab_order'
			)),
			'display' => new Field_Enum(array(
				'column' => 'tab_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
		));
	}
}