<?php
/**
 * The form section observer acts on the form section model at given times to
 * ensure additional work on on other sections, data, values, fields, and tabs
 * happens as it should.
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Observer
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Fusion;

class Observer_Form_Section extends \Orm\Observer
{
	/**
	 * When a section is deleted, we need to loop through its tab sections
	 * and see if we should be activating/deactivating any tabs.
	 *
	 * @param	Model	the model being acted on
	 * @return	void
	 */
	public function before_delete(\Model $model)
	{
		/**
		 * Tab cleanup
		 */
		$tab = \Model_Form_Tab::find($model->tab_id);

		if ($tab !== null)
		{
			if ($tab->sections !== null)
			{
				// loop through the sections and get the information about display
				foreach ($tab->sections as $s)
				{
					$active[$s->id] = (int) $s->display;
				}

				// get a count of the different values
				$active_count = array_count_values($active);

				// if there are no active sections OR the number of actives is less than 2 (the current section removal would make it 0)
				if ( ! in_array(1, $active) 
						or (array_key_exists(1, $active_count) and $active_count[1] < 2))
				{
					if ( (bool) $tab->display === true)
					{
						// there won't be any active sections left, so disable the tab
						$tab->display = (int) false;
						
						// save the record
						$tab->save();
					}
				}
			}
			else
			{
				if ( (bool) $tab->display === true)
				{
					// there are no sections in the tab, so disable it
					$tab->display = (int) false;
					
					// save the record
					$tab->save();
				}
			}
		}
	}

	/**
	 * When a new section is added, we need to check to see how many sections
	 * exist already. If there's only 1 (i.e. the one we just created) then we
	 * need to update all of the fields for that form to move them in to the
	 * newly created section otherwise we won't have access to edit the fields
	 * any more.
	 *
	 * When a new section is created, we need to check the containing tab's
	 * status to figure out if we should be activating/deactivating the tab.
	 *
	 * @param	Model	the model being acted on
	 * @return	void
	 */
	public function after_insert(\Model $model)
	{
		// what form are we updating?
		$form = $model->form_key;

		// count how many sections we have in this key
		$sections = \Model_Form_Section::get_sections($form);

		if (count($sections) == 1)
		{
			// get all the fields for this form
			$fields = \Model_Form_Field::find_form_items($form);

			if (count($fields) > 0)
			{
				foreach ($fields as $f)
				{
					// set the field to have the ID of the newly created section
					$f->section_id = $model->id;

					// save the record
					$f->save();
				}
			}
		}

		/**
		 * Tab cleanup
		 */
		$tab = \Model_Form_Tab::find($model->tab_id);

		if ($tab !== null)
		{
			if ($tab->sections !== null)
			{
				// loop through the sections and get the information about display
				foreach ($tab->sections as $s)
				{
					$active[$s->id] = (int) $s->display;
				}

				// get a count of the different values
				$active_count = array_count_values($active);

				// if there are no active sections OR the number of actives is more than 0
				if (in_array(1, $active) 
						or (array_key_exists(1, $active_count) and $active_count[1] > 0))
				{
					if ( (bool) $tab->display === false)
					{
						// there won't be any active sections left, so disable the tab
						$tab->display = (int) true;
						
						// save the record
						$tab->save();
					}
				}
			}
			else
			{
				if ( (bool) $tab->display === true)
				{
					// there are no sections in the tab, so disable it
					$tab->display = (int) false;
					
					// save the record
					$tab->save();
				}
			}
		}
	}

	/**
	 * When a section is updated, we need to check that tab's sections to see
	 * how we should handle activating/deactivating tabs based on the sections.
	 *
	 * @param	Model	the model being acted on
	 * @return	void
	 */
	public function after_update(\Model $model)
	{
		/**
		 * Tab cleanup
		 */
		$tab = \Model_Form_Tab::find($model->tab_id);

		if ($tab !== null)
		{
			if ($tab->sections !== null)
			{
				// loop through the sections and get the information about display
				foreach ($tab->sections as $s)
				{
					$active[$s->id] = (int) $s->display;
				}

				// get a count of the different values
				$active_count = array_count_values($active);

				// if there are no active sections OR the number of actives is only 1
				if ( ! in_array(1, $active) or (array_key_exists(1, $active_count) and $active_count[1] == 0))
				{
					if ( (bool) $tab->display === true)
					{
						// there won't be any active sections left, so disable the tab
						$tab->display = (int) false;
						
						// save the record
						$tab->save();
					}
				}
				else
				{
					if ( (bool) $tab->display === false)
					{
						// make sure the tab is active
						$tab->display = (int) true;
						
						// save the record
						$tab->save();
					}
				}
			}
			else
			{
				if ( (bool) $tab->display === true)
				{
					// there are no sections in the tab, so disable it
					$tab->display = (int) false;
					
					// save the record
					$tab->save();
				}
			}
		}
	}
}
