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

class Controller_Ajax_Update extends Controller_Base_Ajax
{
	/**
	 * Updates the site content table when an admin uses jEditable to edit
	 * some site content outside of the control panel.
	 *
	 * @return	string
	 */
	public function action_content_save()
	{
		if (\Sentry::check() and \Sentry::user()->has_access('content.update'))
		{
			// get the POST information
			$key = trim(\Security::xss_clean(\Input::post('key')));
			$value = trim(\Security::xss_clean(\Input::post('value')));

			// break the key up into an array
			$pieces = explode('_', $key);

			// flip the array around
			$pieces = array_reverse($pieces);

			// make sure we don't have any tags in the headers
			$content = ($pieces[0] == 'header') ? strip_tags(\Markdown::parse($value)) : $value;

			// save the content
			\Model_SiteContent::update_site_content(array($key => $content));

			// if it's a header, show the content, otherwise we need to parse the Markdown
			if ($pieces[0] == 'header')
			{
				echo $content;
			}
			else
			{
				echo \Markdown::parse($content);
			}
		}
	}

	/**
	 * Updates the form field order when the sort function stops.
	 *
	 * @return	void
	 */
	public function action_field_order()
	{
		if (\Sentry::check() and \Sentry::user()->has_access('form.edit'))
		{
			// get and sanitize the input
			$fields = \Security::xss_clean($_POST['field']);

			foreach ($fields as $key => $value)
			{
				// get the field record
				$record = \Model_Form_Field::find($value);

				// update the order
				$record->order = ($key + 1);

				// save the record
				$record->save();
			}
		}
	}

	/**
	 * Updates the form field order when the sort function stops.
	 *
	 * @return	void
	 */
	public function action_field_value()
	{
		if (\Sentry::check() and \Sentry::user()->has_access('form.edit'))
		{
			// get the values
			$id = \Security::xss_clean(\Input::post('id'));
			$content = \Security::xss_clean(\Input::post('content'));
			$value = \Security::xss_clean(\Input::post('value'));

			// get the value record
			$record = \Model_Form_Value::find($id);

			// update the record
			$record->content = $content;
			$record->value = $value;

			// save the record
			$record->save();
		}
	}

	/**
	 * Shows the modal dialog for updating a form.
	 *
	 * @param	string	the form key used to figure out which form to edit
	 * @return	View
	 */
	public function action_form($key = '')
	{
		if (\Sentry::check() and \Sentry::user()->has_access('form.edit'))
		{
			// get the form
			$form = \Model_Form::get_form($key);

			if ($form !== false)
			{
				$data = array(
					'name' => $form->name,
					'orientation' => $form->orientation,
					'id' => $form->id,

					'values' => array(
						'vertical' => lang('vertical', 1),
						'horizontal' => lang('horizontal', 1)
					),
				);

				echo \View::forge(\Location::file('update/form', 'default', 'ajax'), $data);
			}
		}
	}

	/**
	 * Updates the form field value order when the sort function stops.
	 *
	 * @return	void
	 */
	public function action_value_order()
	{
		if (\Sentry::check() and \Sentry::user()->has_access('form.edit'))
		{
			// get and sanitize the input
			$values = \Security::xss_clean($_POST['value']);

			foreach ($values as $key => $value)
			{
				// get the field record
				$record = \Model_Form_Value::find($value);

				// update the order
				$record->order = ($key + 1);

				// save the record
				$record->save();
			}
		}
	}
}
