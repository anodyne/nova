<?php

class Controller_Test extends Nova\Controller_Main
{
	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		\Debug::dump(\Model_Catalog_Module::uninstall('foo'));
		
		return;
	}

	public function action_date()
	{
		$c = \Carbon::now();
		$c->timestamp = 1348153423;
		$c->tz = 'America/New_York';

		\Debug::dump(
			\Carbon::createFromTimestamp(1348153423, 'UTC')->toDateTimeString(),
			\Carbon::createFromTimestampUTC(1348153423)->toDateTimeString()
		);

		return;
	}

	public function action_nav()
	{
		//$nav = new \Nav;
		//echo $nav->getUserOutput();
		//echo $nav->build();

		//\Debug::dump($nav->build());
		
		//echo $nav->build();

		//$output = $nav->setType('sub')->build();
		//echo $output;
	}

	public function action_location()
	{
		$l = new \Location('main', $this->skin, $this->_module_fallback);

		\Debug::dump(
			$l->setType('structure')->findFile(),
			\Location::file('main', $this->skin, 'structure', $this->_module_fallback)
		);
		\Debug::dump(
			$l->setFile('image.jpg')->setType('asset')->findImage('urlpath'),
			\Location::asset('image.jpg', 'urlpath', array(), $this->_module_fallback)
		);
		\Debug::dump(
			$l->setFile('clock.png')->setType('image')->findImage('urlpath'),
			\Location::image('clock.png', $this->skin, 'urlpath', array(), $this->_module_fallback)
		);
		\Debug::dump(
			$l->setFile(false)->setType('rank')->findRank('red', 'o6', 'default'),
			\Location::rank('red', 'o6', 'default')
		);
	}

	public function action_lang()
	{
		\Debug::dump(langC('action.save action.create'));
	}
}
