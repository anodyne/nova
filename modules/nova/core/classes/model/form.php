<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Form Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Form extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'form_id'
			)),
			'key' => new Field_String(array(
				'column' => 'form_key'
			)),
			'name' => new Field_String(array(
				'column' => 'form_name'
			)),
			'desc' => new Field_Text(array(
				'column' => 'form_desc'
			)),
			'status' => new Field_Enum(array(
				'column' => 'form_status',
				'choices' => array('active','inactive','development'),
				'default' => 'active'
			)),
			'fields' => new Field_HasMany(array(
				'foreign' => 'formfield.form'
			)),
			'sections' => new Field_BelongsTo(array(
				'foreign' => 'formsection'
			)),
			'tabs' => new Field_BelongsTo(array(
				'foreign' => 'formtab'
			)),
		));
	}
}