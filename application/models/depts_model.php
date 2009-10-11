<?php
/*
|---------------------------------------------------------------
| DEPARTMENTS MODEL
|---------------------------------------------------------------
|
| File: models/depts_model.php
| System Version: 1.0
|
| Model used to access the ranks table
|
| Note: in get_all_depts() random ordering is not currently supported
| in Oracle or MSSQL drivers. These will default to 'asc'.
|
*/

require_once APPPATH . 'models/base/depts_model_base.php';

class Depts_model extends Depts_model_base {

	function Depts_model()
	{
		parent::Depts_model_base();
	}
	
}

/* End of file depts_model.php */
/* Location: ./application/models/depts_model.php */