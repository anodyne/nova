<?php
/**
 * The rank observer acts on the rank model at given times to ensure
 * additional work on on other items happens as it should.
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Observer
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Fusion;

class Observer_Rank extends \Orm\Observer
{
	/**
	 * Pre-delete observer.
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
		\SystemEvent::add('user', '[[event.admin.rank.item|action.deleted]]');
	}

	/**
	 * Post-insert observer.
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
		\SystemEvent::add('user', '[[event.admin.rank.item|action.created]]');
	}

	/**
	 * Post-update observer.
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
		\SystemEvent::add('user', '[[event.admin.rank.item|action.updated]]');
	}

	/**
	 * Pre-save observer.
	 *
	 * Check the base image to see if there's a hyphen in it. If there is, then
	 * we're dealing with a legacy rank and will need to split to make sure everything
	 * works as it should.
	 *
	 * @internal
	 * @param	Model	the model being acted on
	 * @return	void
	 */
	public function before_save(\Model $model)
	{
		// find if there's a hyphen in the base image name
		if (strpos($model->base, '-'))
		{
			// break the base image at the hyphen
			$parts = explode('-', $model->base);

			// set the base and pip separately
			$model->base = $parts[0];
			$model->pip = $parts[1];
		}
	}
}
