<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| INSTALL - GENRE DATA (SGA)
|---------------------------------------------------------------
|
| File: assets/install_data_sga.php
| System Version: 1.0
|
| Data asset file for the STARGATE ATLANTIS genre.
|
*/

/*
|---------------------------------------------------------------
| Genre Variables
|---------------------------------------------------------------
*/
$g = 'sga';

/*
|---------------------------------------------------------------
| Genre Table Data (SGA)
|---------------------------------------------------------------
*/
$data = array(
	'departments_'. $g 	=> 'depts',
	'ranks_'. $g		=> 'ranks',
	'positions_'. $g	=> 'positions',
	'catalogue_ranks'	=> 'catalogue_ranks',
	'characters'		=> 'characters'
);

$depts = array(
	array(
		'dept_name' => 'Command Staff',
		'dept_desc' => "The command staff are responsible for organising and directing the Off-World teams, as well as handling any non terrestial diplomatic occurances.",
		'dept_order' => 0),
	array(
		'dept_name' => 'Medical Staff',
		'dept_desc' => "The base medical staff are in charge of keeping everyone in working condition, and they're good at it. It's up to them to make sure that all team members are healthy leaving, and returning through the Stargate.",
		'dept_order' => 1),
	array(
		'dept_name' => 'Engineering Staff',
		'dept_desc' => "The Corp of Engineers lead is responsible for maintaining all base systems, equipment, and of course the plumbing. If something's broken on base, he/she usually knows about it and can assign a person to fix the problem ASAP.",
		'dept_order' => 2),
	array(
		'dept_name' => 'Research &amp; Development',
		'dept_desc' => '',
		'dept_order' => 3),
	array(
		'dept_name' => 'Off-World Team',
		'dept_desc' => "An off world team usually consists of 4-8 members, depending on the mission type that the team is assigned. They could be an Exploration group charting the way for others to follow, or it could be a Marine Combat Unit, sent off world to repel the bad guy assault or to rescue a stranted team in the field.",
		'dept_order' => 4)
);

$ranks= array(
	/*
		this rank needs to stay here as it protects against errors being thrown
		in the event that someone's rank field gets blown away
	*/
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => '',
		'rank_order' => 0,
		'rank_class' => 0),
);

$positions = array();

$catalogue_ranks = array(
	array(
		'rankcat_name' => 'U.S. Military',
		'rankcat_location' => 'default',
		'rankcat_credits' => "The Stargate ranks used in Nova are the US Military sets created by James Arnhem. The rankset can be found at <a href='http://www.kuro-rpg.net' target='_blank'>Kuro-RPG</a>. Please do not copy or modify the images.",
		'rankcat_default' => 'y',
		'rankcat_url' => 'http://www.kuro-rpg.net/')
);

$characters = array(
	array(
		'player' => 1,
		'first_name' => 'Cameron',
		'last_name' => 'Mitchell',
		'position_1' => 1,
		'rank' => 1,
		'date_activate' => now()),
	array(
		'player' => 2,
		'first_name' => 'Samantha',
		'last_name' => 'Carter',
		'position_1' => 2,
		'rank' => 4,
		'date_activate' => now()),
	array(
		'player' => 2,
		'first_name' => 'Daniel',
		'last_name' => 'Jackson',
		'position_1' => 9,
		'rank' => 5,
		'date_activate' => now()),
	array(
		'player' => 1,
		'first_name' => 'Hank',
		'last_name' => 'Landry',
		'position_1' => 10,
		'rank' => 6,
		'date_activate' => now())
);

/* End of file install_data_sga.php */
/* Location: ./application/assets/install/install_data_sga.php */