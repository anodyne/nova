<?php
/**
 * The rank set observer acts on the rank set model at given times to ensure
 * additional work on on other ranks happens as it should.
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Observer
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Fusion;

class Observer_Rank_Set extends \Orm\Observer
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
		\SystemEvent::add('user', '[[event.admin.rank.set|{{'.$model->name.'}}|action.deleted]]');
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
		\SystemEvent::add('user', '[[event.admin.rank.set|{{'.$model->name.'}}|action.created]]');
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
		\SystemEvent::add('user', '[[event.admin.rank.set|{{'.$model->name.'}}|action.updated]]');
	}
}
