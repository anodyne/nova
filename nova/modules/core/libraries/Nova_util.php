<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Utility library
 *
 * @package		Nova
 * @category	Library
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_util {
	
	/**
	 * Sets up a more valid email sender for Nova's emails to avoid some hosts
	 * marking Nova emails as spam. If there's a value in the default_email_address
	 * field in Site Settings, it'll use that, otherwise it'll use nova@{domain}.
	 *
	 * @access	public
	 * @return 	string	the email address to use
	 */
	public function email_sender()
	{
		// get an instance of the CI object
		$ci =& get_instance();
		
		// load the settings model
		$ci->load->model('settings_model', 'settings');
		
		// grab the default email address
		$default = $ci->settings->get_setting('default_email_address');
		
		// if there's something in the default email address, use that
		if ( ! empty($default))
		{
			return $default;
		}
		
		return 'nova@'.preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
	}
	
	/**
	 * Uses the rank.yml file to quickly install a rank set. If no value is
	 * passed to the method then the method will attempt to find all uninstalled
	 * ranks and install them.
	 *
	 *     Utility::install_rank();
	 *     Utility::install_rank('location');
	 *
	 * @access	public
	 * @param	string	the location of a specific rank set to install
	 * @return	void
	 */
	public static function install_rank($location = null)
	{
		$ci =& get_instance();
		
		$ci->load->helper('yayparser');
		$ci->load->model('ranks_model', 'ranks');
		
		if ($location === null)
		{
			$ci->load->helper('directory');
			
			// get the directory listing for the genre
			$dir = directory_map(APPPATH.'assets/common/'.GENRE.'/ranks/', true);
			
			if (is_array($dir))
			{
				// get all the rank sets locations
				$ranks = $ci->ranks->get_all_rank_sets();
	
				if ($ranks->num_rows() > 0)
				{
					// start by removing anything that's already installed
					foreach ($ranks->result() as $rank)
					{
						// find the location in the directory listing
						$key = array_search($rank->rankcat_location, $dir);
	
						if ($key !== false)
						{
							unset($dir[$key]);
						}
					}
	
					// loop through the directories now
					foreach ($dir as $key => $value)
					{
						// assign our path to a variable
						$file = APPPATH.'assets/common/'.GENRE.'/ranks/'.$value.'/rank.yml';
	
						// make sure the file exists first
						if (file_exists($file))
						{
							$content = file_get_contents($file);
							$data = yayparser($content);
							
							$addValues = array(
								'rankcat_name' 		=> $data['rank'],
								'rankcat_location' 	=> $data['location'],
								'rankcat_credits' 	=> $data['credits'],
								'rankcat_preview' 	=> $data['preview'],
								'rankcat_blank' 	=> $data['blank'],
								'rankcat_extension'	=> $data['extension'],
								'rankcat_genre'		=> $data['genre']
							);
							$ci->ranks->add_rank_set($addValues);
						}
					}
				}
			}
		}
		else
		{
			// assign our path to a variable
			$file = APPPATH.'assets/common/'.GENRE.'/ranks/'.$location.'/rank.yml';

			// make sure the file exists first
			if (file_exists($file))
			{
				// get the contents and decode the YAML
				$content = file_get_contents($file);
				$data = yayparser($content);
				
				$addValues = array(
					'rankcat_name' 		=> $data['rank'],
					'rankcat_location' 	=> $data['location'],
					'rankcat_credits' 	=> $data['credits'],
					'rankcat_preview' 	=> $data['preview'],
					'rankcat_blank' 	=> $data['blank'],
					'rankcat_extension'	=> $data['extension'],
					'rankcat_genre'		=> $data['genre']
				);
				$ci->ranks->add_rank_set($addValues);
			}
		}
	}
	
	/**
	 * Uses the skin.yml file to quickly install a skin. If no value is passed
	 * to the method then the method will attempt to find all uninstalled skins
	 * and install them.
	 *
	 *     Utility::install_skin();
	 *     Utility::install_skin('location');
	 *
	 * @access	public
	 * @param	string	the location of a skin to install
	 * @return	void
	 */
	public static function install_skin($location = null)
	{
		$ci =& get_instance();
		
		$ci->load->helper('yayparser');
		$ci->load->model('system_model', 'sys');
		
		if ($location === null)
		{
			$ci->load->helper('directory');
			
			// get the listing of the directory
			$dir = directory_map(APPPATH.'views/', true);
			
			if (is_array($dir))
			{
				// get all the skin catalogue items
				$skins = $ci->sys->get_all_skins();
	
				if ($skins->num_rows() > 0)
				{
					// start by removing anything that's already installed
					foreach ($skins->result() as $skin)
					{
						// find the location in the directory listing
						$key = array_search($skin->skin_location, $dir);
	
						if ($key !== false)
						{
							unset($dir[$key]);
						}
					}
	
					// create an array of items to remove
					$pop = array('template.php');
	
					// remove the items
					foreach ($pop as $p)
					{
						// find the location in the directory listing
						$key = array_search($p, $dir);
	
						if ($key !== false)
						{
							unset($dir[$key]);
						}
					}
	
					// now loop through the directories and install the skins
					foreach ($dir as $key => $value)
					{
						// assign our path to a variable
						$file = APPPATH.'views/'.$value.'/skin.yml';
	
						// make sure the file exists first
						if (file_exists($file))
						{
							$content = file_get_contents($file);
							$data = yayparser($content);
							
							$mainAdd = array(
								'skin_name' 	=> $data['skin'],
								'skin_location' => $data['location'],
								'skin_credits' 	=> $data['credits'],
								'skin_version' 	=> $data['version']
							);
							$ci->sys->add_skin($mainAdd);
	
							// go through and add the sections
							foreach ($data['sections'] as $v)
							{
								$secAdd = array(
									'skinsec_section' 	=> $v['type'],
									'skinsec_skin' 		=> $data['location'],
									'skinsec_preview' 	=> $v['preview'],
									'status' => 		'active',
									'default' => 		'n'
								);
								$ci->sys->add_skin_section($secAdd);
							}
						}
					}
				}
			}
		}
		else
		{
			// assign our path to a variable
			$file = APPPATH.'views/'.$location.'/skin.yml';

			// make sure the file exists first
			if (file_exists($file))
			{
				// get the contents and decode the JSON
				$content = file_get_contents($file);
				$data = yayparser($content);

				$mainAdd = array(
					'skin_name' 	=> $data['skin'],
					'skin_location' => $data['location'],
					'skin_credits' 	=> $data['credits'],
					'skin_version' 	=> $data['version']
				);
				$ci->sys->add_skin($mainAdd);

				// go through and add the sections
				foreach ($data->sections as $v)
				{
					$secAdd = array(
						'skinsec_section' 	=> $v['type'],
						'skinsec_skin' 		=> $data['location'],
						'skinsec_preview' 	=> $v['preview'],
						'status' => 		'active',
						'default' => 		'n'
					);
					$ci->sys->add_skin_section($secAdd);
				}
			}
		}
	}
}
