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
	public function action_accessrole_desc()
	{
		// set the POST variable
		$role = \Security::xss_clean(\Input::post('role', false));
		$role = (is_numeric($role)) ? $role : false;

		// grab the role details
		$item = \Model_Access_Role::find($role);

		// set the output
		$output = (count($item) > 0) ? $item->desc : '';
		
		echo nl2br($output);
	}

	public function action_position_desc()
	{
		// set the POST variable
		$position = \Security::xss_clean(\Input::post('position', false));
		$position = (is_numeric($position)) ? $position : false;

		// grab the position details
		$item = \Model_Position::find($position);

		// set the output
		$output = (count($item) > 0) ? $item->desc : '';
		
		echo nl2br($output);
	}

	public function action_rank_image()
	{
		// set the POST variables
		$rank = \Security::xss_clean(\Input::post('rank', false));
		$location = \Security::xss_clean(\Input::post('location', false));
		
		// a little sanity check
		$rank = (is_numeric($rank)) ? $rank : false;
		
		// pull the rank record
		$rank = \Model_Rank::find($rank);
		
		// set the output
		$output = (count($rank) > 0) 
			? \Location::rank($rank->base, $rank->pip, \Model_Catalog_Rank::getDefault()->location) 
			: '';
		
		echo $output;
	}

	public function action_rank_preview($location = false)
	{
		// get the URI variable
		$location = \Security::xss_clean($location);
		
		// pull the rank catalog record
		$rank = \Model_Catalog_Rank::getItem($location, 'location');
		
		// set the output
		$output = (count($rank) > 0) 
			? \Html::img(\Uri::base(false).'app/assets/common/'.$rank->genre.'/ranks/'.$location.'/'.$rank->preview) 
			: '';
		
		echo $output;
	}

	public function action_skin_preview($location = false)
	{
		// get the URI variable
		$location = \Security::xss_clean($location);
		
		// pull the skin catalog record
		$skin = \Model_Catalog_Skin::getItem($location, 'location');
		
		// set the output
		$output = (count($rank) > 0) 
			? \Html::img(\Uri::base(false).'app/assets/common/'.$rank->genre.'/ranks/'.$location.'/'.$rank->preview) 
			: '';
		
		echo $output;
	}
}
