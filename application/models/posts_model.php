<?php
/*
|---------------------------------------------------------------
| POSTS MODEL
|---------------------------------------------------------------
|
| File: models/posts_model.php
| System Version: 1.0
|
| Model used to access the posts and posts comments tables.
|
*/

require_once APPPATH . 'models/base/posts_model_base.php';

class Posts_model extends Posts_model_base {

	function Posts_model()
	{
		parent::Posts_model_base();
	}
}

/* End of file posts_model.php */
/* Location: ./application/models/posts_model.php */