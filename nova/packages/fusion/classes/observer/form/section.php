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

/**
 * TODO
 *
 * - When a section is deleted, check to see if deleting the section will
 *   leave the tab with no enabled sections. If that's the case, we need to
 *   proactively disable the tab.
 *
 * - When a section is created, check to see if the tab is enabled and if
 *   it isn't, re-enable the tab.
 *
 * - When a section is updated, check to see if the section is enabled, and if
 *   it is, check to see if the tab is disabled. In the event the tab
 *   is disabled and the section is enabled, we need to re-enable the tab.
 */

namespace Fusion;

class Observer_Form_Section extends \Orm\Observer
{
	/**
	 * When a new section is added, we need to check to see how many sections
	 * exist already. If there's only 1 (i.e. the one we just created) then we
	 * need to update all of the fields for that form to move them in to the
	 * newly created section otherwise we won't have access to edit the fields
	 * any more.
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
	}
}
