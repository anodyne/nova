<?php
/**
 * Nova's ranks admin controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova;

class Controller_Admin_Ranks extends Controller_Base_Admin
{
	public function before()
	{
		parent::before();
		
		$this->template->layout->navsub->menu = false;
	}
	
	/**
	 * Shows all of the rank management options available in the system.
	 */
	public function action_index()
	{
		\Sentry::allowed('rank.read', true);

		$this->_view = 'admin/ranks/index';
		$this->_js_view = 'admin/ranks/index_js';

		return;
	}

	public function action_info()
	{
		\Sentry::allowed('rank.read', true);

		$this->_view = 'admin/ranks/info';
		$this->_js_view = 'admin/ranks/info_js';
	}

	public function action_manage()
	{
		\Sentry::allowed('rank.read', true);

		$this->_view = 'admin/ranks/manage';
		$this->_js_view = 'admin/ranks/manage_js';
	}

	/**
	 * Shows all of the rank sets as well as options to create, edit,
	 * delete, and duplicate a rank set.
	 */
	public function action_sets()
	{
		\Sentry::allowed('rank.read', true);

		$this->_view = 'admin/ranks/sets';
		$this->_js_view = 'admin/ranks/sets_js';

		if (\Input::method() == 'POST')
		{
			// get the action
			$action = trim(\Security::xss_clean(\Input::post('action')));

			// get the ID from the POST
			$set_id = trim(\Security::xss_clean(\Input::post('id')));

			/**
			 * Create a new rank set with the name provided by the user.
			 */
			if (\Sentry::user()->has_access('rank.create') and $action == 'create')
			{
				$item = \Model_Rank_Set::create_item(array(
					'name' => \Security::xss_clean(\Input::post('name')),
					'order' => (\Model_Rank_Set::count() + 1),
				));

				if ($item)
				{
					$this->_flash[] = array(
						'status' => 'success',
						'message' => lang('[[short.flash.success|rank set|action.created]]', 1),
					);
				}
				else
				{
					$this->_flash[] = array(
						'status' => 'danger',
						'message' => lang('[[short.flash.failure|rank set|action.creation]]', 1),
					);
				}
			}

			/**
			 * Duplicate an existing rank set and dump the rank information
			 * from the old set into the new set with the new base the user
			 * specified in the modal pop-up.
			 */
			if (\Sentry::user()->has_access('rank.create') and $action == 'duplicate')
			{
				// create the new set
				$item = \Model_Rank_Set::create_item(array(
					'name' => trim(\Security::xss_clean(\Input::post('name'))),
					'order' => (\Model_Rank_set::count() + 1),
				), true);

				// grab the new base
				$new_base = trim(\Security::xss_clean(\Input::post('base')));

				// get the set we're duplicating
				$duplicator = \Model_Rank_Set::find($set_id);

				if (count($duplicator->ranks) > 0)
				{
					// loop through all the ranks and build the new ranks
					foreach ($duplicator->ranks as $r)
					{
						$new = \Model_Rank::forge();
						$new->info_id = $r->info_id;
						$new->set_id = $item->id;
						$new->base = $new_base;
						$new->pip = $r->pip;

						$new->save();
					}
				}

				if ($item)
				{
					$this->_flash[] = array(
						'status' => 'success',
						'message' => lang('[[short.flash.success|rank set|action.duplicated]]', 1),
					);
				}
				else
				{
					$this->_flash[] = array(
						'status' => 'danger',
						'message' => lang('[[short.flash.failure|rank set|action.duplication]]', 1),
					);
				}
			}

			/**
			 * Update the specified rank set with the information the user specified
			 * in the modal pop-up.
			 */
			if (\Sentry::user()->has_access('rank.edit') and $action == 'update')
			{
				// update the field
				$item = \Model_Rank_Set::update_item($set_id, \Input::post());

				if ($item)
				{
					$this->_flash[] = array(
						'status' => 'success',
						'message' => lang('[[short.flash.success|rank set|action.updated]]', 1),
					);
				}
				else
				{
					$this->_flash[] = array(
						'status' => 'danger',
						'message' => lang('[[short.flash.failure|rank set|action.update]]', 1),
					);
				}
			}

			/**
			 * Delete the specified rank set and move the ranks from this set to the
			 * set the user specified in the modal pop-up. If the user requested to
			 * have the set's ranks deleted, that will supercede any new set ID selection.
			 */
			if (\Sentry::user()->has_access('rank.delete') and $action == 'delete')
			{
				// get all the ranks for the current set
				$set = \Model_Rank_Set::find($set_id);

				// get the new set ID
				$new_set_id = trim(\Security::xss_clean(\Input::post('new_set')));

				// are we deleting the ranks?
				$delete_ranks = trim(\Security::xss_clean(\Input::post('delete_ranks')));

				if (count($set->ranks) > 0)
				{
					// loop through and change the ranks
					foreach ($set->ranks as $rank)
					{
						if ($delete_ranks == '1')
						{
							// delete the rank
							$rank->delete();
						}
						else
						{
							// update the rank with the new set ID
							$rank->set_id = $new_set_id;
							$rank->save();
						}
					}
				}

				// delete the rank set
				$item = \Model_Rank_Set::delete_item($set_id);

				if ($item)
				{
					$this->_flash[] = array(
						'status' => 'success',
						'message' => lang('[[short.flash.success|rank set|action.deleted]]', 1),
					);
				}
				else
				{
					$this->_flash[] = array(
						'status' => 'danger',
						'message' => lang('[[short.flash.failure|rank set|action.deletion]]', 1),
					);
				}
			}
		}

		// get all the sets
		$this->_data->sets = \Model_Rank_Set::find_items();

		// set up the images
		$this->_data->images = array(
			'info' => \Location::image($this->images['info'], $this->skin, 'admin'),
			'ranks' => \Location::image($this->images['categories'], $this->skin, 'admin'),
		);

		return;
	}
}
