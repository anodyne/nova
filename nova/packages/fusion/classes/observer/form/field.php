<?php
/**
 * Form Field Observer
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Observer
 * @author		Anodyne Productions
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
}
