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

class Observer_Application extends \Orm\Observer
{
	/**
	 * When an application is created, we need to kick off the
	 * the review process.
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

		
	}
}
