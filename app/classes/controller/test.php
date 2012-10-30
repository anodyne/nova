<?php

class Controller_Test extends Nova\Controller_Main
{
	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		\Debug::dump(
			lang('[[event.admin.position|position|{{Commanding Officer}}|action.updated]]')
		);
		
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
}
