<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Form Values Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Formvalue extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('forms_values');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'value_id'
			)),
			'field' => new Field_BelongsTo(array(
				'column' => 'value_field',
				'foreign' => 'formfield'
			)),
			'html_name' => new Field_String(array(
				'column' => 'value_html_name'
			)),
			'html_value' => new Field_String(array(
				'column' => 'value_html_value'
			)),
			'html_id' => new Field_String(array(
				'column' => 'value_html_id'
			)),
			'selected' => new Field_String(array(
				'column' => 'value_selected'
			)),
			'content' => new Field_String(array(
				'column' => 'value_content'
			)),
			'order' => new Field_Integer(array(
				'column' => 'value_order'
			)),
		));
	}
}