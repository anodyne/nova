<?php
/**
 * Nova's media admin controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova;

class Controller_Admin_Media extends Controller_Base_Admin
{
	public function before()
	{
		parent::before();
		
		$this->template->layout->navsub->menu = false;
	}

	public function action_index()
	{
		$this->_view = 'admin/media/index';
		$this->_js_view = 'admin/media/index_js';

		if (\Input::method() == 'POST')
		{
			// make sure we're putting images in the right places
			\Upload::register('before', function (&$file){
				if ($file['error'] == \Upload::UPLOAD_ERR_OK)
				{
					switch($file['extension'])
					{
						case "jpg":
						case "png":
						case "gif":
							// store these in the images subdirectory
							$file['saved_to'] .= 'images/';
						break;

						case "css":
							// store these in the css subdirectory
							$file['saved_to'] .= 'css/';
						break;

						case "js":
							// store these in the javascript subdirectory
							$file['saved_to'] .= 'js/';
						break;
					}
				}
			});

			// process the uploaded files in $_FILES
			\Upload::process($config);

			// if there are any valid files
			if (\Upload::is_valid())
			{
				// save them according to the config
				\Upload::save();

				// call a model method to update the database
				\Model_Uploads::add(\Upload::get_files());
			}
		}

		return;
	}
}
