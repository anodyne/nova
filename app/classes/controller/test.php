<?php

class Controller_Test extends Nova\Controller_Main
{
	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		/*
		$groups = \Model_Rank_Group::find('all');
		foreach ($groups as $g)
		{
			echo '<div class="container">';
			echo '<h2>'.$g->name.'</h2>';
			echo '<table class="table table-striped">';
			foreach ($g->ranks as $r)
			{
				echo '<tr><td width="300">'.$r->info->name.'</td><td>'.\Location::rank($r->base, $r->pip).'</td></tr>';
			}
			echo '</table></div>';
		}

		//$originalData = array('position' => array(2), 'user' => array(22, 91, 31));
		$originalData = array('position' => array(2));
		$dataAsJson = \Format::forge($originalData)->to_json();
		$dataAsArray = \Format::forge($dataAsJson, 'json')->to_array();
		$dataAsObj = json_decode($dataAsJson);
		\Debug::dump(
			$originalData,
			$dataAsJson,
			$dataAsArray,
			$dataAsObj,
			$dataAsObj->position[0]
		);
		*/
		
		//\Debug::dump(\Model_User::getItems());
		
		$rev1 = \Model_User::find(1)->appReviews;
		$rev2 = \Model_User::query()->related('appReviews')
			->where('appReviews.status', \Status::IN_PROGRESS)
			->get();
			$user = \Model_User::find(1);
			$password = \Str::random();
			
		\Debug::dump(
			\Model_Catalog_Rank::getDefault(true)
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
}
