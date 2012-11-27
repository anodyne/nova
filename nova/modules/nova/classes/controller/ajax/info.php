<?php
/**
 * Nova's ajax controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova;

class Controller_Ajax_Info extends Controller_Base_Ajax
{
	/**
	 * Get a position's description.
	 */
	public function action_position_desc()
	{
		// Set the variable
		$position = \Security::xss_clean(\Input::post('position', false));
		$position = (is_numeric($position)) ? $position : false;

		// Get the position
		$item = \Model_Position::find($position);

		// Set the output
		$output = (count($item) > 0) ? $item->desc : '';
		
		echo nl2br($output);
	}

	/**
	 * Get the rank image.
	 */
	public function action_rank_image()
	{
		// Set the variables
		$rank = \Security::xss_clean(\Input::post('rank', false));
		$location = \Security::xss_clean(\Input::post('location', false));
		
		// Do a little sanity checking
		$rank = (is_numeric($rank)) ? $rank : false;
		
		// Get the rank
		$rank = \Model_Rank::find($rank);
		
		// Set the output
		$output = (count($rank) > 0) 
			? \Location::rank($rank->base, $rank->pip, \Model_Catalog_Rank::getDefault()->location) 
			: '';
		
		echo $output;
	}

	/**
	 * Get the preview for a specific rank set.
	 */
	public function action_rank_preview($location = false)
	{
		// Clean the variable
		$location = \Security::xss_clean($location);
		
		// Get the catalog item
		$rank = \Model_Catalog_Rank::getItem($location, 'location');
		
		// Set the output
		$output = (count($rank) > 0) 
			? \Html::img(\Uri::base(false).'app/assets/common/'.$rank->genre.'/ranks/'.$location.'/'.$rank->preview) 
			: '';
		
		echo $output;
	}

	/**
	 * Get a role's description.
	 */
	public function action_role_desc()
	{
		// Set the variable
		$role = \Security::xss_clean(\Input::post('role', false));
		$role = (is_numeric($role)) ? $role : false;

		// Get the role
		$item = \Model_Access_Role::find($role);

		// Set the output
		$output = (count($item) > 0) ? $item->desc : '';
		
		echo nl2br($output);
	}

	/**
	 * Get the users who are assigned a given role.
	 */
	public function action_role_users($id)
	{
		if (\Sentry::check() and \Sentry::user()->hasAccess('role.read'))
		{
			// Clean the variable
			$id = \Security::xss_clean($id);

			// Get the role
			$role = \Model_Access_Role::find($id);

			// Get the users
			$data['users'] = $role->users;

			echo \View::forge(\Location::file('info/role_users', \Utility::getSkin('admin'), 'ajax'), $data);
		}
	}

	/**
	 * Get the preview for a specific skin.
	 */
	public function action_skin_preview($section = false, $location = false)
	{
		// Clean the variables
		$section = \Security::xss_clean($section);
		$location = \Security::xss_clean($location);
		
		// Pull the skin catalog record
		$skin = \Model_Catalog_SkinSec::getItems(array('skin' => $location, 'section' => $section), true);

		// Set the output
		$output = (count($skin) > 0) 
			? \Html::img(\Uri::base(false).'app/views/'.$location.'/'.$skin->preview) 
			: '';
		
		echo $output;
	}
}
