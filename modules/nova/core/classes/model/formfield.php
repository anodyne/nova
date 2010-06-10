<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Form Fields Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Formfield extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('forms_fields');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'field_id'
			)),
			'form' => new Field_Integer(array(
				'column' => 'field_form'
			)),
			'html_name' => new Field_String(array(
				'column' => 'field_html_name'
			)),
		));
	}
}