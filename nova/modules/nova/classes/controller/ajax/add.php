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

class Controller_Ajax_Add extends Controller_Base_Ajax
{
	/**
	 * Add a field value to the database.
	 *
	 * @return	string
	 */
	public function action_field_value()
	{
		if (\Sentry::check() and \Sentry::user()->has_access('form.edit'))
		{
			// get the values
			$content = trim(\Security::xss_clean(\Input::post('content')));
			$field = trim(\Security::xss_clean(\Input::post('field')));
			$order = trim(\Security::xss_clean(\Input::post('order')));

			// create a new object and populate it with data
			$item = \Model_Form_Value::forge();
			$item->content = $content;
			$item->value = $content;
			$item->order = $order;
			$item->field_id = $field;

			// save the record
			$record = $item->save();

			\SystemEvent::add('user', '[[event.admin.form.field_update|{{'.$record->field->label.'}}|{{'.$record->field->form_key.'}}]]');

			if ($record)
			{
				echo '<tr id="value_'.$item->id.'"><td>'.$item->content.'</td><td class="span2"><div class="btn-group"><a href="#" class="btn btn-mini value-action tooltip-top" title="'.lang('action.edit', 1).'" data-action="update" data-id="'.$item->id.'"><i class="icon-pencil icon-75"></i></a><a href="#" class="btn btn-mini value-action tooltip-top" title="'.lang('action.delete', 1).'" data-action="delete" data-id="'.$item->id.'"><i class="icon-remove icon-75"></i></a></div></td><td class="span1 reorder"></td></tr>';
			}
		}
	}

	/**
	 * Runs the QuickInstall for a module.
	 *
	 * @return	void
	 */
	public function action_module($module)
	{
		if (\Sentry::check() and \Sentry::user()->has_access('catalog.create'))
		{
			// do the quick install
			\QuickInstall::module($module);

			\SystemEvent::add('user', '[[event.admin.catalog.module_create|{{'.$module.'}}]]');

			echo '<p class="alert alert-success">'.lang('[[short.flash.success|module|action.installed]]').'</p>';
			echo '<div class="form-actions"><button class="btn modal-close">'.lang('action.close', 1).'</button></div>';
		}
	}
}
