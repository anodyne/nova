<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| USER PANEL LIBRARY
|---------------------------------------------------------------
|
| File: libraries/User_panel.php
| System Version: 1.0
|
| Library that handles generating the user panel.
|
*/

require_once APPPATH . 'libraries/User_panel_base.php';

class User_panel extends User_panel_base {
    
	function User_panel()
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* log the debug message */
		log_message('debug', 'User Panel Library Initialized');
	}
}

/* End of file User_panel.php */
/* Location: ./application/libraries/User_panel.php */