<?php
/*
|---------------------------------------------------------------
| ACCESS MODEL
|---------------------------------------------------------------
|
| File: models/access_model.php
| System Version: 1.0
|
| Model used to access the access roles and access pages tables.
|
*/

require_once APPPATH . 'models/base/access_model_base.php';

class Access_model extends Access_model_base {

	function Access_model()
	{
		parent::Access_model_base();
	}
	
}

/* End of file access_model.php */
/* Location: ./application/models/access_model.php */