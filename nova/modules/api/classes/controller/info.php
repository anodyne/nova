<?php
/**
 * API controller for game info.
 *
 * @package		Nova
 * @subpackage	API
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 * @version		1.0
 */

namespace Api;

class Controller_Info extends \Controller_Rest
{
	/**
	 * The data return format.
	 */
	protected $format = 'json';

	/**
	 * Get the sim info from the API.
	 *
	 *     api/info/sim.json
	 *
	 * @since	1.0
	 */
	public function get_sim()
	{
		$this->response(array(
			'name'	=> \Model_Settings::getItems('sim_name'),
			'url'	=> \Uri::base(false),
		), 200);
	}
}
