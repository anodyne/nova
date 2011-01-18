<?php
/*
|---------------------------------------------------------------
| RSS FEED MODEL
|---------------------------------------------------------------
|
| File: models/rss_model.php
| System Version: 1.0
|
| Model used to access the database for retrieving information that
| should be fed into the RSS feeds.
|
*/

require_once APPPATH . 'models/base/rss_model_base.php';

class Rss_model extends Rss_model_base {

	function Rss_model()
	{
		parent::Rss_model_base();
	}
}

/* End of file rss_model.php */
/* Location: ./application/models/rss_model.php */