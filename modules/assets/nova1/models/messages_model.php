<?php
/*
|---------------------------------------------------------------
| MESSAGES MODEL
|---------------------------------------------------------------
|
| File: models/messages_model.php
| System Version: 1.0
|
| Model used to access the messages table to retrieve and update
| messages used by the system.
|
*/

require_once APPPATH . 'models/base/messages_model_base.php';

class Messages_model extends Messages_model_base {

	function Messages_model()
	{
		parent::Messages_model_base();
	}
}

/* End of file messages_model.php */
/* Location: ./application/models/messages_model.php */