<?php
/**
 * The form field observer acts on the form field model at given times to ensure
 * additional work on on other fields, data, values, sections, and tabs happens
 * as it should.
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Observer
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Fusion;

class Observer_Character extends \Orm\Observer
{
	/**
	 * When a user is created, we need to create blank data records
	 * to prevent errors being thrown when the user is updated and
	 * we need to create the user preferences as well.
	 *
	 * @internal
	 * @param	Model	the model being acted on
	 * @return	void
	 */
	public function after_insert(\Model $model)
	{
		/**
		 * System Event
		 */
		//\SystemEvent::add('user', '[[event.admin.form.field_create|{{'.$model->label.'}}|{{'.$model->form_key.'}}]]');

		/**
		 * Create the user settings.
		 */
		$settings = \Model_User_Preferences::create_user_preferences($model->id);
		
		/**
		 * Fill the user rows for the dynamic form with blank data for editing later.
		 */
		$fields = \Model_Form_Field::find_form_items('user');
		
		if (count($fields) > 0)
		{
			foreach ($fields as $f)
			{
				\Model_Form_Data::create_data(array(
					'form_key' => 'user',
					'field_id' => $f->id,
					'user_id' => $model->id,
					'character_id' => 0,
					'item_id' => 0,
					'value' => '',
					'updated_at' => time(),
				));
			}
		}
	}
}
