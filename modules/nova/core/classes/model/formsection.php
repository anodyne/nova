<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Form Sections Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Formsection extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('forms_sections');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'section_id'
			)),
			'form' => new Field_BelongsTo(array(
				'column' => 'section_form',
				'foreign' => 'form.key'
			)),
			'tab' => new Field_BelongsTo(array(
				'column' => 'section_tab',
				'foreign' => 'formtab'
			)),
			'name' => new Field_String(array(
				'column' => 'section_name'
			)),
			'order' => new Field_Integer(array(
				'column' => 'section_order'
			)),
		));
	}
}