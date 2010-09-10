<?php
/*
|---------------------------------------------------------------
| CHARACTERS MODEL
|---------------------------------------------------------------
|
| File: models/characters_model.php
| System Version: 1.0
|
| Model used to access the characters table.
|
*/

require_once APPPATH . 'models/base/characters_model_base.php';

class Characters_model extends Characters_model_base {

	function Characters_model()
	{
		parent::Characters_model_base();
	}
}

/* End of file characters_model.php */
/* Location: ./application/models/characters_model.php */