<?php

namespace Nova;

class Controller_Docs extends \Controller
{
	public function action_index($page, $dir = '')
	{
		// figure out the path
		$path = ( ! empty($dir)) ? $dir.'/'.$page.'.md' : $page.'.md';

		// get the contents
		$content = file_get_contents(DOCROOT.'docs/'.$path);

		// parse the content
		echo \Markdown::parse($content);
	}

	public function action_test()
	{
		\Lang::load('app', 'nova');
		\Lang::load('nova::base', 'nova');
		\Lang::load('nova::event', 'nova');
		\Lang::load('nova::email', 'nova');

		\Debug::dump(\Lang::get('nova'));

		exit;
	}
}
