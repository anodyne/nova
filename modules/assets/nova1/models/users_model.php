<?php
/*
|---------------------------------------------------------------
| USERS MODEL
|---------------------------------------------------------------
|
| File: models/users_model.php
| System Version: 1.0
|
| Model used to access the users table.
|
*/

require_once APPPATH . 'models/base/users_model_base.php';

class Users_model extends Users_model_base {

	function Users_model()
	{
		parent::Users_model_base();
	}
}

/* End of file users_model.php */
/* Location: ./application/models/users_model.php */