<?php
/**
 * Form Field Observer
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
	 * Note: The field ID is not available after the delete has happened, so we
	 * have to do all this work before deletion otherwise we're out of luck.
	 *
	 * @param	Model	the model being acted on
	 * @return	void
	 */
	public function before_delete(\Model $model)
	{
		// do we have values that need to be deleted?
		if ($model->values !== null)
		{
			foreach ($model->values as $val)
			{
				// delete the value
				$val->delete();
			}
		}

		// do we have data that needs to be deleted?
		$data = \Model_Form_Data::get_data($model->id);

		if ($data !== null)
		{
			foreach ($data as $val)
			{
				// delete the data
				$val->delete();
			}
		}
	}

	/**
	 * When a field is created, we need to loop through the various pieces and
	 * make sure that data records are added.
	 *
	 * @param	Model	the model being acted on
	 * @return	void
	 */
	public function after_insert(\Model $model)
	{
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
	}
}
