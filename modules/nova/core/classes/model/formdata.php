<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Form Data Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Formdata extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('forms_data');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'data_id'
			)),
			'form' => new Field_String(array(
				'column' => 'data_form'
			)),
			'field' => new Field_BelongsTo(array(
				'column' => 'data_field',
				'foreign' => 'formfield'
			)),
			'user' => new Field_BelongsTo(array(
				'column' => 'data_user',
				'foreign' => 'user'
			)),
			'character' => new Field_BelongsTo(array(
				'column' => 'data_character',
				'foreign' => 'character'
			)),
			'item' => new Field_Integer(array(
				'column' => 'data_item'
			)),
			'value' => new Field_Text(array(
				'column' => 'data_value'
			)),
			'last_update' => new Field_Timestamp(array(
				'column' => 'data_last_update',
				'auto_now_create' => FALSE,
				'auto_now_update' => TRUE,
				'null' => TRUE,
				'default' => date::now()
			)),
		));
	}
}