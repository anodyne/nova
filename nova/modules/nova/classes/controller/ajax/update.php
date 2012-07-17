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
	 * Updates the form field order when the sort function stops.
	 *
	 * @return	void
	 */
	public function action_formfield_order()
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

			\SystemEvent::add('user', '[[event.admin.form.field_update|{{'.$record->label.'}}|{{'.$key.'}}]]');
		}
	}

	/**
	 * Updates the value for a dropdown menu.
	 *
	 * @return	View/string
	 */
	public function action_formfield_value($id)
	{
		if (\Sentry::check() and \Sentry::user()->has_access('form.edit'))
		{
			if (\Input::method() == 'POST')
			{
				// get the value
				$value = \Model_Form_Value::find($id);

				// get the POST
				$post = $_POST;

				// remove the items we don't want
				unset($post['id']);

				// loop through and update the values
				foreach ($post as $k => $v)
				{
					$value->{$k} = \Security::xss_clean($v);
				}

				// save the record
				$value->save();

				\SystemEvent::add('user', '[[event.admin.form.field_update|{{'.$value->field->label.'}}|{{'.$key.'}}]]');

				echo '<h1>'.lang('action.edit value', 2).'</h1>';
				echo '<p class="alert alert-success">'.lang('short.flash.success|value|action.updated', 1).' '.lang('short.refresh').'</p>';
			}
			else
			{
				// get the value
				$value = \Model_Form_Value::find($id);

				if ($value !== false)
				{
					$data = array(
						'id' => $value->id,
						'field' => $value->field_id,
						'content' => $value->content,
						'value' => $value->value,
						'order' => $value->order,
					);

					// get the fields
					$fields = \Model_Form_Field::find_form_items($value->field->form_key);

					if (count($fields) > 0)
					{
						foreach ($fields as $f)
						{
							if ($f->type == 'select')
							{
								$data['fields'][$f->id] = $f->label;
							}
						}
					}

					echo \View::forge(\Location::file('update/form_value', 'default', 'ajax'), $data);
				}
			}
		}
	}

	/**
	 * Updates the form field value order when the sort function stops.
	 *
	 * @return	void
	 */
	public function action_formfieldvalue_order()
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

			\SystemEvent::add('user', '[[event.admin.form.field_update|{{'.$record->field->label.'}}|{{'.$key.'}}]]');
		}
	}

	/**
	 * Updates the form section order when the sort function stops.
	 *
	 * @return	void
	 */
	public function action_formsection_order()
	{
		if (\Sentry::check() and \Sentry::user()->has_access('form.edit'))
		{
			// get and sanitize the input
			$sections = \Security::xss_clean($_POST['section']);

			foreach ($sections as $key => $value)
			{
				// get the field record
				$record = \Model_Form_Section::find($value);

				// update the order
				$record->order = ($key + 1);

				// save the record
				$record->save();
			}

			\SystemEvent::add('user', '[[event.admin.form.section_update|{{'.$record->name.'}}|{{'.$key.'}}]]');
		}
	}

	/**
	 * Updates the form tab order when the sort function stops.
	 *
	 * @return	void
	 */
	public function action_formtab_order()
	{
		if (\Sentry::check() and \Sentry::user()->has_access('form.edit'))
		{
			// get and sanitize the input
			$tabs = \Security::xss_clean($_POST['tab']);

			foreach ($tabs as $key => $value)
			{
				// get the tab record
				$record = \Model_Form_Tab::find($value);

				// update the order
				$record->order = ($key + 1);

				// save the record
				$record->save();
			}

			\SystemEvent::add('user', '[[event.admin.form.tab_update|{{'.$record->name.'}}|{{'.$key.'}}]]');
		}
	}

	/**
	 * Runs the migrations for a module.
	 *
	 * @return	void
	 */
	public function action_module($module)
	{
		if (\Sentry::check() and \Sentry::user()->has_access('catalog.update'))
		{
			// move up to the latest migration
			\Migrate::latest($module, 'module');

			\SystemEvent::add('user', '[[event.admin.catalog.module_update|{{'.$module.'}}]]');

			echo '<p class="alert alert-success">'.lang('[[short.flash.success|module|action.updated]]').'</p>';
			echo '<div class="form-actions"><button class="btn modal-close">'.lang('action.close', 1).'</button></div>';
		}
	}

	/**
	 * Duplicate a rank set.
	 *
	 * @param	int		the ID of the rank set being duplicated
	 * @return	void
	 */
	public function action_rankset($id)
	{
		if (\Sentry::check() and \Sentry::user()->has_access('rank.edit'))
		{
			$id = trim(\Security::xss_clean($id));

			// get the rank set
			$set = \Model_Rank_Set::find($id);

			// set the data
			$data['id'] = $id;

			if ($set !== false)
			{
				$data['name'] = $set->name;
				$data['order'] = $set->order;
				$data['display'] = (int) $set->display;
			}

			echo \View::forge(\Location::file('update/rankset', \Utility::get_skin('admin'), 'ajax'), $data);
		}
	}

	/**
	 * Updates the rank set order when the sort function stops.
	 *
	 * @return	void
	 */
	public function action_rankset_order()
	{
		if (\Sentry::check() and \Sentry::user()->has_access('rank.edit'))
		{
			// get and sanitize the input
			$sets = \Security::xss_clean(\Input::post('set'));

			foreach ($sets as $key => $value)
			{
				// get the set record
				$record = \Model_Rank_Set::find($value);

				// update the order
				$record->order = ($key + 1);

				// save the record
				$record->save();
			}
		}
	}
}
