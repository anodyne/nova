<?php
/*
|---------------------------------------------------------------
| NEWS MODEL
|---------------------------------------------------------------
|
| File: models/news_model.php
| System Version: 1.0
|
| Model used to access the news, news categories, and news comments tables.
|
*/

require_once APPPATH . 'models/base/news_model_base.php';

class News_model extends News_model_base {

	function News_model()
	{
		parent::News_model_base();
	}
	
}

/* End of file news_model.php */
/* Location: ./application/models/news_model.php */