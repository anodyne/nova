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

class Observer_Form_Field extends \Orm\Observer
{
	/**
	 * When a field is deleted, we need to loop through and remove all data
	 * associated with that field.
	 *
	 * When a field is deleted, we need to loop through and remove any values
	 * associated with that field.
	 *
	 * Check what deleting the field will do to the active count of fields
	 * in a section and activate/deactivate the section accordingly.
	 *
	 * @internal
	 * @param	Model	the model being acted on
	 * @return	void
	 */
	public function before_delete(\Model $model)
	{
		/**
		 * System Event
		 */
		\SystemEvent::add('user', '[[event.admin.form.field_delete|{{'.$model->label.'}}|{{'.$model->form_key.'}}]]');

		/**
		 * Value cleanup
		 */
		if ($model->values !== null)
		{
			foreach ($model->values as $val)
			{
				// delete the value
				$val->delete();
			}
		}

		/**
		 * Data cleanup
		 */
		$data = \Model_Form_Data::get_data($model->id);

		if ($data !== null)
		{
			foreach ($data as $val)
			{
				// delete the data
				$val->delete();
			}
		}

		/**
		 * Section cleanup
		 */
		$section = \Model_Form_Section::find($model->section_id);

		if ($model->section_id > 0 and $section !== null)
		{
			if ($section->fields !== null)
			{
				// loop through the fields and get the information about display
				foreach ($section->fields as $f)
				{
					$active[$f->id] = (int) $f->display;
				}

				// get a count of the different values
				$active_count = array_count_values($active);

				// if there are no active fields OR the number of actives is less than 2 (the current field removal would make it 0)
				if ( ! in_array(1, $active) 
						or (array_key_exists(1, $active_count) and $active_count[1] < 2))
				{
					if ( (bool) $section->display === true)
					{
						// there won't be any active fields left, so disable the section
						$section->display = (int) false;
						
						// save the record
						$section->save();
					}
				}
			}
			else
			{
				if ( (bool) $section->display === true)
				{
					// there are no fields in the section, so disable it
					$section->display = (int) false;
					
					// save the record
					$section->save();
				}
			}
		}
	}

	/**
	 * When a field is created, we need to loop through the various pieces and
	 * make sure that data records are added.
	 *
	 * When a field is created, we need to check the containing section to see
	 * how we should handle activating/deactivating the section.
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
		\SystemEvent::add('user', '[[event.admin.form.field_create|{{'.$model->label.'}}|{{'.$model->form_key.'}}]]');

		// what should be in the data?
		$data = array(
			'form_key' => $model->form_key,
			'field_id' => $model->id,
			'value' => '',
			'updated_at' => time(),
		);

		switch ($model->form_key)
		{
			case 'bio':
				// get all the active characters
				$characters = \Model_Character::get_characters();

				if (count($characters) > 0)
				{
					foreach ($characters as $c)
					{
						// add the IDs
						$data['character_id'] = $c->id;
						$data['user_id'] = 0;
						$data['item_id'] = 0;

						// create the data
						\Model_Form_Data::create_data($data);
					}
				}
			break;

			case 'user':
				// get all the active users
				$users = \Model_User::get_users();

				if (count($users) > 0)
				{
					foreach ($users as $u)
					{
						// add the IDs
						$data['user_id'] = $u->id;
						$data['character_id'] = 0;
						$data['item_id'] = 0;

						// create the data
						\Model_Form_Data::create_data($data);
					}
				}
			break;

			case 'tour':
				// get all the tour items
				$tour = \Model_Tour::get_items();

				if (count($tour) > 0)
				{
					foreach ($tour as $t)
					{
						// add the IDs
						$data['item_id'] = $t->id;
						$data['user_id'] = 0;
						$data['character_id'] = 0;

						// create the data
						\Model_Form_Data::create_data($data);
					}
				}
			break;

			case 'specs':
				// get all the specification items
				$specs = \Model_Spec::get_items();

				if (count($specs) > 0)
				{
					foreach ($specs as $s)
					{
						// add the IDs
						$data['item_id'] = $s->id;
						$data['user_id'] = 0;
						$data['character_id'] = 0;

						// create the data
						\Model_Form_Data::create_data($data);
					}
				}
			break;
		}

		/**
		 * Section cleanup
		 */
		$section = \Model_Form_Section::find($model->section_id);

		if ($section !== null)
		{
			if ($section->fields !== null)
			{
				// loop through the fields and get the information about display
				foreach ($section->fields as $f)
				{
					$active[$f->id] = (int) $f->display;
				}

				// get a count of the different values
				$active_count = array_count_values($active);

				// if there are no active fields OR the number of actives is more than 0
				if (in_array(1, $active) 
						or (array_key_exists(1, $active_count) and $active_count[1] > 0))
				{
					if ( (bool) $section->display === false)
					{
						// there won't be any active fields left, so disable the section
						$section->display = (int) true;
						
						// save the record
						$section->save();
					}
				}
			}
			else
			{
				if ( (bool) $section->display === true)
				{
					// there are no fields in the section, so disable it
					$section->display = (int) false;
					
					// save the record
					$section->save();
				}
			}
		}
	}

	/**
	 * When a field is updated, we need to grab the section and do some checks
	 * to see if we should be activating or deactivating the section because of
	 * the number of fields or the number of active fields.
	 *
	 * @internal
	 * @param	Model	the model being acted on
	 * @return	void
	 */
	public function after_update(\Model $model)
	{
		/**
		 * System Event
		 */
		\SystemEvent::add('user', '[[event.admin.form.field_update|{{'.$model->label.'}}|{{'.$model->form_key.'}}]]');

		/**
		 * Section cleanup
		 */
		$section = \Model_Form_Section::find($model->section_id);

		if ($section !== null)
		{
			if ($section->fields !== null)
			{
				// loop through the fields and get the information about display
				foreach ($section->fields as $f)
				{
					$active[$f->id] = (int) $f->display;
				}

				// get a count of the different values
				$active_count = array_count_values($active);

				// if there are no active fields OR the number of actives is 0
				if ( ! in_array(1, $active) 
						or (array_key_exists(1, $active_count) and $active_count[1] == 0))
				{
					// only do the update if the section is active
					if ( (bool) $section->display === true)
					{
						// there won't be any active fields left, so disable the section
						$section->display = (int) false;
						
						// save the record
						$section->save();
					}
				}
				else
				{
					// only do the update if the section is inactive
					if ( (bool) $section->display === false)
					{
						// set the section to display
						$section->display = (int) true;
						
						// save the record
						$section->save();
					}
				}
			}
			else
			{
				// only do the update if the section is active
				if ( (bool) $section->display === true)
				{
					// there are no fields in the section, so disable it
					$section->display = (int) false;
					
					// save the record
					$section->save();
				}
			}
		}
	}
}
