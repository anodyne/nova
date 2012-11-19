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

class Controller_Admin_Rank extends Controller_Base_Admin
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

		$this->_view = 'admin/rank/index';

		return;
	}

	/**
	 * Shows all of the rank groups as well as options to create, edit,
	 * delete, and duplicate a rank group.
	 */
	public function action_groups()
	{
		\Sentry::allowed('rank.read', true);

		$this->_view = 'admin/rank/groups';
		$this->_js_view = 'admin/rank/groups_js';

		if (\Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				// get the action
				$action = \Security::xss_clean(\Input::post('action'));

				// get the ID from the POST
				$group_id = \Security::xss_clean(\Input::post('id'));

				/**
				 * Create a new rank group with the name provided by the user.
				 */
				if (\Sentry::user()->hasAccess('rank.create') and $action == 'create')
				{
					$item = \Model_Rank_Group::createItem(array(
						'name' => \Security::xss_clean(\Input::post('name')),
						'order' => (\Model_Rank_Group::count() + 1),
					));

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.create', langConcat('rank group'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.create', langConcat('rank group'))),
						);
					}
				}

				/**
				 * Duplicate an existing rank group and dump the rank information
				 * from the old group into the new group with the new base the user
				 * specified in the modal pop-up.
				 */
				if (\Sentry::user()->hasAccess('rank.create') and $action == 'duplicate')
				{
					// create the new group
					$item = \Model_Rank_Group::createItem(array(
						'name'	=> \Security::xss_clean(\Input::post('name')),
						'order' => (\Model_Rank_Group::count() + 1),
					), true);

					// grab the new base
					$new_base = \Security::xss_clean(\Input::post('base'));

					// get the group we're duplicating
					$duplicator = \Model_Rank_Group::find($group_id);

					if (count($duplicator->ranks) > 0)
					{
						// loop through all the ranks and build the new ranks
						foreach ($duplicator->ranks as $r)
						{
							$new = \Model_Rank::forge();
							$new->info_id = $r->info_id;
							$new->group_id = $item->id;
							$new->base = $new_base;
							$new->pip = $r->pip;

							$new->save();
						}
					}

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.duplicate', langConcat('rank group'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => ucfirst(lang('short.alert.failure.duplicate', langConcat('rank group'))),
						);
					}
				}

				/**
				 * Update the specified rank group with the information the user specified
				 * in the modal pop-up.
				 */
				if (\Sentry::user()->hasAccess('rank.update') and $action == 'update')
				{
					// update the field
					$item = \Model_Rank_Group::updateItem($group_id, \Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.update', langConcat('rank group'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.update', langConcat('rank group'))),
						);
					}
				}

				/**
				 * Delete the specified rank group and move the ranks from this group to the
				 * group the user specified in the modal pop-up. If the user requested to
				 * have the group's ranks deleted, that will supercede any new group ID selection.
				 */
				if (\Sentry::user()->hasAccess('rank.delete') and $action == 'delete')
				{
					// get all the ranks for the current group
					$group = \Model_Rank_Group::find($group_id);

					// get the new group ID
					$new_group_id = \Security::xss_clean(\Input::post('new_group'));

					// are we deleting the ranks?
					$delete_ranks = \Security::xss_clean(\Input::post('delete_ranks'));

					if (count($group->ranks) > 0)
					{
						// loop through and change the ranks
						foreach ($group->ranks as $rank)
						{
							if ($delete_ranks == '1')
							{
								// delete the rank
								$rank->delete();
							}
							else
							{
								// update the rank with the new group ID
								$rank->group_id = $new_group_id;
								$rank->save();
							}
						}
					}

					// delete the rank group
					$item = \Model_Rank_Group::deleteItem($group_id);

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.delete', langConcat('rank group'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.delete', langConcat('rank group'))),
						);
					}
				}
			}
			else
			{
				$this->_flash[] = array(
					'status' 	=> 'danger',
					'message' 	=> lang('error.csrf'),
				);
			}
		}

		// get all the group
		$this->_data->groups = \Model_Rank_Group::getItems();

		// set up the images
		$this->_data->images = array(
			'info' => \Location::image($this->images['info'], $this->skin, 'admin'),
			'ranks' => \Location::image($this->images['categories'], $this->skin, 'admin'),
		);

		return;
	}

	/**
	 * Shows all of the rank info items as well as options to create, edit,
	 * and delete a rank info item.
	 */
	public function action_info()
	{
		\Sentry::allowed('rank.read', true);

		$this->_view = 'admin/rank/info';
		$this->_js_view = 'admin/rank/info_js';

		if (\Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				// get the action
				$action = \Security::xss_clean(\Input::post('action'));

				// get the ID from the POST
				$info_id = \Security::xss_clean(\Input::post('id'));

				/**
				 * Create a new rank info with the data provided by the user.
				 */
				if (\Sentry::user()->hasAccess('rank.create') and $action == 'create')
				{
					$item = \Model_Rank_Info::createItem(\Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.create', langConcat('rank info'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.create', langConcat('rank info'))),
						);
					}
				}

				/**
				 * Update the specified rank info with the information the user specified
				 * in the modal pop-up.
				 */
				if (\Sentry::user()->hasAccess('rank.update') and $action == 'update')
				{
					// update the field
					$item = \Model_Rank_Info::updateItem($info_id, \Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.update', langConcat('rank info'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.update', langConcat('rank info'))),
						);
					}
				}

				/**
				 * Delete the specified rank info and move the ranks from this info to the
				 * info the user specified in the modal pop-up. If the user requested to
				 * have the info's ranks deleted, that will supercede any new info ID selection.
				 */
				if (\Sentry::user()->hasAccess('rank.delete') and $action == 'delete')
				{
					// get the rank info record
					$info = \Model_Rank_Info::find($info_id);

					// get the new info ID
					$new_info_id = \Security::xss_clean(\Input::post('new_info'));

					// are we deleting the ranks?
					$delete_ranks = \Security::xss_clean(\Input::post('delete_ranks'));

					if (count($info->ranks) > 0)
					{
						// loop through and change the ranks
						foreach ($info->ranks as $rank)
						{
							if ($delete_ranks == '1')
							{
								// delete the rank
								$rank->delete();
							}
							else
							{
								// update the rank with the new info ID
								$rank->info_id = $new_info_id;
								$rank->save();
							}
						}
					}

					// delete the rank info
					$item = \Model_Rank_Info::deleteItem($info_id);

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.delete', langConcat('rank info'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.delete', langConcat('rank info'))),
						);
					}
				}
			}
			else
			{
				$this->_flash[] = array(
					'status' 	=> 'danger',
					'message' 	=> lang('error.csrf'),
				);
			}
		}

		// get all the info records
		$info = \Model_Rank_Info::getItems();

		// create an empty holding array
		$this->_data->info = array();

		if (count($info) > 0)
		{
			foreach ($info as $i)
			{
				$this->_data->info[$i->group][] = $i;
			}
		}

		// set up the images
		$this->_data->images = array(
			'groups' => \Location::image($this->images['groups'], $this->skin, 'admin'),
			'ranks' => \Location::image($this->images['categories'], $this->skin, 'admin'),
		);
	}

	/**
	 * Shows all of the ranks as well as options to create, edit,
	 * and delete a rank item.
	 */
	public function action_manage($id = false)
	{
		\Sentry::allowed('rank.read', true);

		$this->_view = 'admin/rank/manage';
		$this->_js_view = 'admin/rank/manage_js';

		// get the default rank
		$default = $this->settings->rank;

		if (\Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				// get the action
				$action = \Security::xss_clean(\Input::post('action'));

				// get the ID from the POST
				$rank_id = \Security::xss_clean(\Input::post('id'));

				/**
				 * Create a new rank.
				 */
				if (\Sentry::user()->hasAccess('rank.create') and $action == 'create')
				{
					$item = \Model_Rank::createItem(\Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.create', lang('rank'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.create', lang('rank'))),
						);
					}
				}

				/**
				 * Update a rank.
				 */
				if (\Sentry::user()->hasAccess('rank.update') and $action == 'update')
				{
					$item = \Model_Rank::updateItem($rank_id, \Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.update', lang('rank'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.update', lang('rank'))),
						);
					}
				}

				/**
				 * Delete a rank.
				 *
				 * @todo	what do we need to do with characters when a rank is deleted?
				 */
				if (\Sentry::user()->hasAccess('rank.delete') and $action == 'delete')
				{
					$item = \Model_Rank::deleteItem($rank_id);

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.delete', lang('rank'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.delete', lang('rank'))),
						);
					}
				}

				/**
				 * Change the rank set.
				 */
				if ($action == 'changeSet')
				{
					$default = \Security::xss_clean(\Input::post('changeSet'));
				}
			}
			else
			{
				$this->_flash[] = array(
					'status' 	=> 'danger',
					'message' 	=> lang('error.csrf'),
				);
			}
		}

		// set the path to the rank images
		$rankPath = $this->_js_data->rankPath = "app/assets/common/$this->genre/ranks/$default/";

		// get the rank extension
		$rankExt = $this->_js_data->rankExt = \Model_Catalog_Rank::getItem($default, 'location')->extension;

		if (is_numeric($id))
		{
			// change the view
			$this->_view = 'admin/rank/manage_action';

			// set the action
			$this->_data->action = ($id == 0) ? 'create' : 'update';

			// get the rank record
			$rank = $this->_data->rank = \Model_Rank::find($id);

			// get the rank info records
			$infos = \Model_Rank_Info::getItems();

			// start the infos listing
			$this->_data->infos[0] = '';

			if (count($infos) > 0)
			{
				foreach ($infos as $i)
				{
					// set the group name
					$group = lang('group', 1).' '.$i->group;

					// put the info into the array
					$this->_data->infos[$group][$i->id] = $i->name;
				}
			}

			// get the rank group records
			$groups = \Model_Rank_Group::getItems();

			// start the groups listing
			$this->_data->groups = array();

			if (count($groups) > 0)
			{
				foreach ($groups as $g)
				{
					// put the info into the array
					$this->_data->groups[$g->id] = $g->name;
				}
			}

			if (is_dir(APPPATH."assets/common/$this->genre/ranks/$default/base")
					and is_dir(APPPATH."assets/common/$this->genre/ranks/$default/pips"))
			{
				// read the directory for the base images
				$bases = \File::read_dir(APPPATH."assets/common/$this->genre/ranks/$default/base");

				if (is_array($bases) and count($bases) > 0)
				{
					// loop through the images
					foreach ($bases as $key => $location)
					{
						if (is_array($location))
						{
							// make sure the directory separators are right
							$key = str_replace('\\', '/', $key);

							// loop through the sub directory
							foreach ($location as $l)
							{
								// strip the image extension
								$image = substr_replace($l, '', strpos($l, '.'));

								// the image without extension is the value, with extension is displayed
								$this->_data->bases[$key.$image] = \Html::img($rankPath.'base/'.$key.$l);
							}
						}
						else
						{
							// strip the image extension
							$image = substr_replace($location, '', strpos($location, '.'));

							// the image without extension is the value, with extension is displayed
							$this->_data->bases[$image] = \Html::img($rankPath.'base/'.$location);
						}
					}
				}

				// read the directory for the pip images
				$pips = \File::read_dir(APPPATH."assets/common/$this->genre/ranks/$default/pips");

				if (is_array($pips) and count($pips) > 0)
				{
					// set an empty pip option
					$this->_data->pips[''] = lang('no pip', 2);

					// loop through the images
					foreach ($pips as $key => $location)
					{
						if (is_array($location))
						{
							// make sure the directory separators are right
							$key = str_replace('\\', '/', $key);

							// loop through the sub directory
							foreach ($location as $l)
							{
								// strip the image extension
								$image = substr_replace($l, '', strpos($l, '.'));

								// the image without extension is the value, with extension is displayed
								$this->_data->pips[$key.$image] = \Html::img($rankPath.'pips/'.$key.$l);
							}
						}
						else
						{
							// strip the image extension
							$image = substr_replace($location, '', strpos($location, '.'));

							// the image without extension is the value, with extension is displayed
							$this->_data->pips[$image] = \Html::img($rankPath.'pips/'.$location);
						}
					}
				}
			}
			else
			{
				// read the directory for the pip images
				$imgs = \File::read_dir(APPPATH."assets/common/$this->genre/ranks/$default");

				if (is_array($imgs) and count($imgs) > 0)
				{
					// loop through the images
					foreach ($imgs as $key => $location)
					{
						// strip the image extension
						$image = substr_replace($location, '', strpos($location, '.'));

						if ($image != 'preview' and $image != 'blank' and $image != 'rank')
						{
							// the image without extension is the value, with extension is displayed
							$this->_data->imgs[$image] = \Html::img($rankPath.'/'.$location);
						}
					}

					// sort the images
					ksort($this->_data->imgs);
				}
			}

			// set the rank preview
			$this->_data->rankPreview = ($rank) ? \Location::rank($rank->base, $rank->pip, $default) : false;
		}
		else
		{
			// get all the rank sets
			$sets = \Model_Catalog_Rank::find('all');

			if (count($sets) > 0)
			{
				foreach ($sets as $s)
				{
					if ($s->status == \Status::ACTIVE)
					{
						$this->_data->sets[$s->location] = $s->name;
					}
				}
			}

			// pass the default along
			$this->_data->default = $default;

			// get all the rank groups
			$this->_data->groups = \Model_Rank_Group::getItems();

			// set up the images
			$this->_data->images = array(
				'groups' => \Location::image($this->images['groups'], $this->skin, 'admin'),
				'info' => \Location::image($this->images['info'], $this->skin, 'admin'),
			);
		}
	}
}
