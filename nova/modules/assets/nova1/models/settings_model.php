<?php
/*
|---------------------------------------------------------------
| SETTINGS MODEL
|---------------------------------------------------------------
|
| File: models/setttings_model.php
| System Version: 1.0
|
| Model used to access the settings table and pull the system
| settings for use by the controllers and views.
|
*/

require_once APPPATH . 'models/base/settings_model_base.php';

class Settings_model extends Settings_model_base {

	function Settings_model()
	{
		parent::Settings_model_base();
	}
	
}

/* End of file settings_model.php */
/* Location: ./application/models/settings_model.php */