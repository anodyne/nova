<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| INSTALL - GENRE DATA (ST:KLI)
|---------------------------------------------------------------
|
| File: assets/install_data_kli.php
| System Version: 1.0
|
| Genre data compiled by David VanScott
|
*/

# TODO: position descriptions
# TODO: department descriptions

/*
|---------------------------------------------------------------
| Genre Variables
|---------------------------------------------------------------
*/
$g = 'kli';

/*
|---------------------------------------------------------------
| Genre Table Data (ST:KLI)
|---------------------------------------------------------------
*/
$data = array(
	'departments_'. $g 	=> 'depts',
	'ranks_'. $g		=> 'ranks',
	'positions_'. $g	=> 'positions',
	'catalogue_ranks'	=> 'catalogue_ranks',
);

$depts = array(
	array(
		'dept_name' => 'Command',
		'dept_desc' => "",
		'dept_order' => 0),
	array(
		'dept_name' => 'Tactical',
		'dept_desc' => "",
		'dept_order' => 1),
	array(
		'dept_name' => 'Navigation',
		'dept_desc' => "",
		'dept_order' => 2),
	array(
		'dept_name' => 'Engineering',
		'dept_desc' => "",
		'dept_order' => 3),
	array(
		'dept_name' => 'Medical &amp; Science',
		'dept_desc' => "",
		'dept_order' => 4),
	array(
		'dept_name' => 'Marines',
		'dept_desc' => "",
		'dept_order' => 5)
);

$ranks= array(
	array(
		'rank_name' => 'Fleet Admiral',
		'rank_short_name' => 'FADM',
		'rank_image' => 'n-a3',
		'rank_order' => 0,
		'rank_class' => 1),
	array(
		'rank_name' => 'General',
		'rank_short_name' => 'GEN',
		'rank_image' => 'm-a3',
		'rank_order' => 0,
		'rank_class' => 2),
		
	array(
		'rank_name' => 'Admiral',
		'rank_short_name' => 'ADM',
		'rank_image' => 'n-a2',
		'rank_order' => 1,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant General',
		'rank_short_name' => 'LT GEN',
		'rank_image' => 'm-a2',
		'rank_order' => 1,
		'rank_class' => 2),
		
	array(
		'rank_name' => 'Vice Admiral',
		'rank_short_name' => 'VADM',
		'rank_image' => 'n-a1',
		'rank_order' => 2,
		'rank_class' => 1),
	array(
		'rank_name' => 'Major General',
		'rank_short_name' => 'MAJ GEN',
		'rank_image' => 'm-a1',
		'rank_order' => 2,
		'rank_class' => 2),
		
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'n-o6',
		'rank_order' => 3,
		'rank_class' => 1),
	array(
		'rank_name' => 'Colonel',
		'rank_short_name' => 'COL',
		'rank_image' => 'm-o6',
		'rank_order' => 3,
		'rank_class' => 2),
		
	array(
		'rank_name' => 'Commander',
		'rank_short_name' => 'CMDR',
		'rank_image' => 'n-o5',
		'rank_order' => 4,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant Colonel',
		'rank_short_name' => 'LT COL',
		'rank_image' => 'm-o5',
		'rank_order' => 4,
		'rank_class' => 2),
		
	array(
		'rank_name' => 'Lieutenant Commander',
		'rank_short_name' => 'LT CMDR',
		'rank_image' => 'n-o4',
		'rank_order' => 5,
		'rank_class' => 1),
	array(
		'rank_name' => 'Major',
		'rank_short_name' => 'MAJ',
		'rank_image' => 'm-o4',
		'rank_order' => 5,
		'rank_class' => 2),
		
	array(
		'rank_name' => 'Lieutenant',
		'rank_short_name' => 'LT',
		'rank_image' => 'n-o3',
		'rank_order' => 6,
		'rank_class' => 1),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'm-o3',
		'rank_order' => 6,
		'rank_class' => 2),
		
	array(
		'rank_name' => 'Lieutenant JG',
		'rank_short_name' => 'LT(JG)',
		'rank_image' => 'n-o2',
		'rank_order' => 7,
		'rank_class' => 1),
	array(
		'rank_name' => '1st Lieutenant',
		'rank_short_name' => '1LT',
		'rank_image' => 'm-o2',
		'rank_order' => 7,
		'rank_class' => 2),
		
	array(
		'rank_name' => 'Ensign',
		'rank_short_name' => 'EN',
		'rank_image' => 'n-o1',
		'rank_order' => 8,
		'rank_class' => 1),
	array(
		'rank_name' => '2nd Lieutenant',
		'rank_short_name' => '2LT',
		'rank_image' => 'm-o1',
		'rank_order' => 8,
		'rank_class' => 2),
		
	array(
		'rank_name' => 'Master Specialist',
		'rank_short_name' => 'MSPEC',
		'rank_image' => 'n-w2',
		'rank_order' => 9,
		'rank_class' => 1),
	array(
		'rank_name' => 'Master Specialist',
		'rank_short_name' => 'MSPEC',
		'rank_image' => 'm-w2',
		'rank_order' => 9,
		'rank_class' => 2),
		
	array(
		'rank_name' => 'Specialist',
		'rank_short_name' => 'SPEC',
		'rank_image' => 'n-w1',
		'rank_order' => 10,
		'rank_class' => 1),
	array(
		'rank_name' => 'Specialist',
		'rank_short_name' => 'SPEC',
		'rank_image' => 'm-w1',
		'rank_order' => 10,
		'rank_class' => 2),
		
	array(
		'rank_name' => 'Sergeant Major',
		'rank_short_name' => 'SGT MAJ',
		'rank_image' => 'n-e6',
		'rank_order' => 11,
		'rank_class' => 1),
	array(
		'rank_name' => 'Sergeant Major',
		'rank_short_name' => 'SGT MAJ',
		'rank_image' => 'm-e6',
		'rank_order' => 11,
		'rank_class' => 2),
		
	array(
		'rank_name' => 'Master Sergeant',
		'rank_short_name' => 'MSGT',
		'rank_image' => 'n-e5',
		'rank_order' => 12,
		'rank_class' => 1),
	array(
		'rank_name' => 'Master Sergeant',
		'rank_short_name' => 'MSGT',
		'rank_image' => 'm-e5',
		'rank_order' => 12,
		'rank_class' => 2),
		
	array(
		'rank_name' => 'Sergeant',
		'rank_short_name' => 'SGT',
		'rank_image' => 'n-e4',
		'rank_order' => 13,
		'rank_class' => 1),
	array(
		'rank_name' => 'Sergeant',
		'rank_short_name' => 'SGT',
		'rank_image' => 'm-e4',
		'rank_order' => 13,
		'rank_class' => 2),
		
	array(
		'rank_name' => 'Corporal',
		'rank_short_name' => 'COR',
		'rank_image' => 'n-e3',
		'rank_order' => 14,
		'rank_class' => 1),
	array(
		'rank_name' => 'Corporal',
		'rank_short_name' => 'COR',
		'rank_image' => 'm-e3',
		'rank_order' => 14,
		'rank_class' => 2),
		
	array(
		'rank_name' => 'Warrior, 1st Class',
		'rank_short_name' => 'WAR1',
		'rank_image' => 'n-e2',
		'rank_order' => 15,
		'rank_class' => 1),
	array(
		'rank_name' => 'Warrior, 1st Class',
		'rank_short_name' => 'WAR1',
		'rank_image' => 'm-e2',
		'rank_order' => 15,
		'rank_class' => 2),
		
	array(
		'rank_name' => 'Warrior, 2nd Class',
		'rank_short_name' => 'WAR2',
		'rank_image' => 'n-e1',
		'rank_order' => 16,
		'rank_class' => 1),
	array(
		'rank_name' => 'Warrior, 2nd Class',
		'rank_short_name' => 'WAR2',
		'rank_image' => 'm-e1',
		'rank_order' => 16,
		'rank_class' => 2),
		
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'n-blank',
		'rank_order' => 17,
		'rank_class' => 1),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'm-blank',
		'rank_order' => 17,
		'rank_class' => 2)
);

$positions = array(
	array(
		'pos_name' => 'Commanding Officer',
		'pos_desc' => "",
		'pos_dept' => 1,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'First Officer',
		'pos_desc' => "",
		'pos_dept' => 1,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	
	array(
		'pos_name' => 'Chief Tactical Officer',
		'pos_desc' => "",
		'pos_dept' => 2,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Second Tactical Officer',
		'pos_desc' => "",
		'pos_dept' => 2,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Tactical Officer',
		'pos_desc' => "",
		'pos_dept' => 2,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Gunner',
		'pos_desc' => "",
		'pos_dept' => 2,
		'pos_order' => 3,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => "Gunner's Mate",
		'pos_desc' => "",
		'pos_dept' => 2,
		'pos_order' => 4,
		'pos_open' => 4,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Chief Navigator',
		'pos_desc' => "",
		'pos_dept' => 3,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Second Navigation Officer',
		'pos_desc' => "",
		'pos_dept' => 3,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Navigator',
		'pos_desc' => "",
		'pos_dept' => 3,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Chief Engineer',
		'pos_desc' => "",
		'pos_dept' => 4,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Second Engineer',
		'pos_desc' => "",
		'pos_dept' => 4,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Engineer',
		'pos_desc' => "",
		'pos_dept' => 4,
		'pos_order' => 2,
		'pos_open' => 6,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Damage Control Specialist',
		'pos_desc' => "",
		'pos_dept' => 4,
		'pos_order' => 3,
		'pos_open' => 4,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Cloaking Technician',
		'pos_desc' => "",
		'pos_dept' => 4,
		'pos_order' => 4,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Energy Systems Specialist',
		'pos_desc' => "",
		'pos_dept' => 4,
		'pos_order' => 5,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Weapons Systems Specialist',
		'pos_desc' => "",
		'pos_dept' => 4,
		'pos_order' => 6,
		'pos_open' => 4,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Chief Doctor',
		'pos_desc' => "",
		'pos_dept' => 5,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Doctor',
		'pos_desc' => "",
		'pos_dept' => 5,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Head Nurse',
		'pos_desc' => "",
		'pos_dept' => 5,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Nurse',
		'pos_desc' => "",
		'pos_dept' => 5,
		'pos_order' => 3,
		'pos_open' => 4,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Science Officer',
		'pos_desc' => "",
		'pos_dept' => 5,
		'pos_order' => 4,
		'pos_open' => 4,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Chief Marine Officer',
		'pos_desc' => "",
		'pos_dept' => 6,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Squad Leader',
		'pos_desc' => "",
		'pos_dept' => 6,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Master-at-Arms',
		'pos_desc' => "",
		'pos_dept' => 6,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Marine',
		'pos_desc' => "",
		'pos_dept' => 6,
		'pos_order' => 3,
		'pos_open' => 20,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Marine Engineer Specialist',
		'pos_desc' => "",
		'pos_dept' => 6,
		'pos_order' => 4,
		'pos_open' => 2,
		'pos_type' => 'officer')
);

$catalogue_ranks = array(
	array(
		'rankcat_name' => 'Duty Uniform',
		'rankcat_location' => 'default',
		'rankcat_credits' => "The Klingon Duty Uniform rank set was created by Kuro-chan of Kuro-RPG. The rankset (and others) can be found at <a href='http://www.kuro-rpg.net' target='_blank'>Kuro-RPG</a>. Please do not copy or modify the images.",
		'rankcat_default' => 'y',
		'rankcat_url' => 'http://www.kuro-rpg.net/')
);

/* End of file install_data_baj.php */
/* Location: ./application/assets/install/install_data_baj.php */