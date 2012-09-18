<?php
/**
 * Nova's catalog admin controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova;

class Controller_Admin_Catalog extends Controller_Base_Admin
{
	public function before()
	{
		parent::before();
		
		$this->template->layout->navsub->menu = false;
	}
	
	/**
	 * Displays a list of the different catalogs available to modify.
	 */
	public function action_index()
	{
		$this->_view = 'admin/catalog/index';

		return;
	}

	public function action_modules()
	{
		$this->_view = 'admin/catalog/modules';
		$this->_js_view = 'admin/catalog/modules_js';

		// get the list of installed modules
		$installed = \Model_Catalog_Module::getItems();

		// get the directory list of the modules
		$pending = \File::read_dir(APPPATH.'modules');

		// build an empty array for updates
		$update = array();

		// drop the override module
		unset($pending['override'.DS]);

		if (count($installed) > 0)
		{
			foreach ($installed as $m)
			{
				if (count($pending) > 0)
				{
					// remove anything that's already installed from the dir listing
					if (array_key_exists($m->location.DS, $pending))
					{
						unset($pending[$m->location.DS]);
					}
				}

				try
				{
					// get the migrations for this module
					$migrations = \File::read_dir(APPPATH.'modules/'.$m->location.'/migrations');

					// if we have more migrations files than versions, then we have an update
					if (count($migrations) > \Model_Migration::getVersion($m->location))
					{
						$update[$m->id] = $m;
					}
				}
				catch (\Fuel\Core\InvalidPathException $e)
				{
					// no updates
				}
			}
		}

		// set the variables for the views
		$this->_data->installed = $installed;
		$this->_data->pending = $pending;
		$this->_data->update = $update;

		return;
	}
}
