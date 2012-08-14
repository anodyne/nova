<?php
/**
 * Nova's ajax setup controller.
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Setup;

class Controller_Ajax extends \Controller
{
	public function action_ignore_version()
	{
		# TODO: need to make sure they have access as well
		if (\Sentry::check())
		{
			// get the version
			$version = \Security::xss_clean(\Input::post('version'));
			
			// update the system information table with the ignore version
			\Model_System::update_info(array('version_ignore' => $version));
		}
		
		return;
	}
}
