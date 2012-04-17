<?php
/**
 * Nova's ajax controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova;

class Controller_Ajax_Delete extends Controller_Base_Ajax
{
	public function action_field($id)
	{
		if (\Sentry::check() and \Sentry::user()->has_access('form.delete'))
		{
			// get the field
			$field = \Model_Form_Field::find($id);

			if ($field !== null)
			{
				$data = array(
					'name' => $field->label,
					'id' => $field->id,
				);

				echo \View::forge(\Location::file('delete/field', 'default', 'ajax'), $data);
			}
		}
	}

	public function action_field_value()
	{
		if (\Sentry::check() and \Sentry::user()->has_access('form.edit'))
		{
			// get the value
			$id = trim(\Security::xss_clean(\Input::post('id')));

			// grab the value from the database
			$value = \Model_Form_Value::find($id);

			// delete it
			$value->delete();
		}
	}
}
