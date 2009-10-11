<?php
/*
|---------------------------------------------------------------
| PLAYERS MODEL
|---------------------------------------------------------------
|
| File: models/players_model.php
| System Version: 1.0
|
| Model used to access the players table.
|
*/

require_once APPPATH . 'models/base/players_model_base.php';

class Players_model extends Players_model_base {

	function Players()
	{
		parent::Players_model_base();
	}
}

/* End of file players_model.php */
/* Location: ./application/models/players_model.php */