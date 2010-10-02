<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| INSTALL - GENRE DATA (SQ)
|---------------------------------------------------------------
|
| File: assets/install/genres/sq_data.php
| System Version: 1.2
|
| Genre data compiled by David VanScott
|
*/

# electronics technician
# fire control technician
# machinist's mate
# mess management specialist
# missile technician

/*
|---------------------------------------------------------------
| Genre Variables
|---------------------------------------------------------------
*/
$g = 'sq';

/*
|---------------------------------------------------------------
| Genre Table Data (BSG)
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
		'dept_desc' => "The Command Department consists of the Commanding Officer and the Executive Officer. The CO is ultimately responsible for the safety and welfare of the entire crew. S/he has final authority on all decisions regarding the ship and her mission. The XO is the CO's immediate subordinate, and is also his/her successor should the need arise. The Command Department is responsible for carrying out the orders of the UEO.",
		'dept_order' => 0),
	array(
		'dept_name' => 'Helm',
		'dept_desc' => "The Helm Department is responsible for the navigation and driving of the ship. In addition, the Helm Department can be called upon to drive the various mini-subs assigned to the ship as needed.",
		'dept_order' => 1),
	array(
		'dept_name' => 'Sonar',
		'dept_desc' => "The Sonar Department is responsible for all sonar equipment used aboard the ship, including the operation and maintenance of the ship's Wireless Sea Knowledge Retrieval Satellites (WSKRS).",
		'dept_order' => 2),
	array(
		'dept_name' => 'Communications',
		'dept_desc' => "The Communications Department is responsible for all communications in and out of the ship, including orders from UEO. In addition to standard communication channels, the Communications Department is responsible for the monitoring and use of military communication channels as well. In most cases, Communications Officers are multi-lingual in order to communicate with the various federations and factions throughout the world.",
		'dept_order' => 3),
	array(
		'dept_name' => 'EVA',
		'dept_desc' => "The EVA Department is responsible for all extra vehicular activities launched from the ship. This includes the control of all mini-subs assigned to the ship as well as any additional equipment for use outside of the ship. The EVA Department interfaces regularly with the Helm Department and works closely to train other members of the crew on safe EVA procedures as well as operation of the EVA equipment.",
		'dept_order' => 4),
	array(
		'dept_name' => 'Weapons',
		'dept_desc' => "The Weapons Department is responsible for all ordinance stored aboard the ship as well as the targeting and executing of ordiance release at the order of the Commanding Officer.",
		'dept_order' => 5),
	array(
		'dept_name' => 'Security',
		'dept_desc' => "The Security Department is responsible for the security aboard the ship as well as escorts for missions off the ship. Members of the Security Department are responsible for securing sensitive areas of the ship such as Engineering, Weapons Control, the Bridge and any other areas the Commanding Officer sees fit.",
		'dept_order' => 6),
	array(
		'dept_name' => 'Engineering',
		'dept_desc' => "The Engineering Department is responsible for the general upkeep and maintaince of the ship as well as any repairs that need to be done while the ship is at sea.",
		'dept_order' => 7),
	array(
		'dept_name' => 'Science/Medical',
		'dept_desc' => "While the UEO is a peacekeeping organization, one of its primary focuses is on exploration of the oceans. Nearly every UEO vessel has some sort of Science Department that is responsible for scientific experiments while the ship is at sea. The Science Department is also called on for their expertise with undersea topography and general scientific knowledge for the successful completion of many of the UEO's missions.",
		'dept_order' => 8),
	array(
		'dept_name' => 'Marine Detachment',
		'dept_desc' => "Despite being a peaceful organization, the UEO Marine Corps is responsible for both defensive and offensive missions at the orders of the UEO President. Because of hightening tensions between confederations, many UEO ships carry a Marine detachment for any type of missions that may require the additional muscle the Marine Corps brings with it.",
		'dept_order' => 9),
);

$ranks = array(
	array(
		'rank_name' => 'Admiral',
		'rank_short_name' => 'ADM',
		'rank_image' => 'b-a3',
		'rank_order' => 0,
		'rank_class' => 1),
	array(
		'rank_name' => 'Vice-Admiral',
		'rank_short_name' => 'VADM',
		'rank_image' => 'b-a2',
		'rank_order' => 1,
		'rank_class' => 1),
	array(
		'rank_name' => 'Rear-Admiral',
		'rank_short_name' => 'RADM',
		'rank_image' => 'b-a1',
		'rank_order' => 2,
		'rank_class' => 1),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'b-o6',
		'rank_order' => 3,
		'rank_class' => 1),
	array(
		'rank_name' => 'Commander',
		'rank_short_name' => 'CMDR',
		'rank_image' => 'b-o5',
		'rank_order' => 4,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant Commander',
		'rank_short_name' => 'LTCMDR',
		'rank_image' => 'b-o4',
		'rank_order' => 5,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant',
		'rank_short_name' => 'LT',
		'rank_image' => 'b-o3',
		'rank_order' => 6,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant JG',
		'rank_short_name' => 'LT(JG)',
		'rank_image' => 'b-o2',
		'rank_order' => 7,
		'rank_class' => 1),
	array(
		'rank_name' => 'Ensign',
		'rank_short_name' => 'ENS',
		'rank_image' => 'b-o1',
		'rank_order' => 8,
		'rank_class' => 1),
	array(
		'rank_name' => 'Chief Warrant Officer 3',
		'rank_short_name' => 'CWO3',
		'rank_image' => 'b-w3',
		'rank_order' => 9,
		'rank_class' => 1),
	array(
		'rank_name' => 'Chief Warrant Officer 2',
		'rank_short_name' => 'CWO2',
		'rank_image' => 'b-w2',
		'rank_order' => 10,
		'rank_class' => 1),
	array(
		'rank_name' => 'Warrant Officer',
		'rank_short_name' => 'WO',
		'rank_image' => 'b-w1',
		'rank_order' => 11,
		'rank_class' => 1),
	array(
		'rank_name' => 'Master Chief Petty Officer',
		'rank_short_name' => 'MCPO',
		'rank_image' => 'b-e9',
		'rank_order' => 12,
		'rank_class' => 1),
	array(
		'rank_name' => 'Senior Chief Petty Officer',
		'rank_short_name' => 'SCPO',
		'rank_image' => 'b-e8',
		'rank_order' => 13,
		'rank_class' => 1),
	array(
		'rank_name' => 'Chief Petty Officer',
		'rank_short_name' => 'CPO',
		'rank_image' => 'b-e7',
		'rank_order' => 14,
		'rank_class' => 1),
	array(
		'rank_name' => 'Petty Officer, 1st Class',
		'rank_short_name' => 'PO1',
		'rank_image' => 'b-e6',
		'rank_order' => 15,
		'rank_class' => 1),
	array(
		'rank_name' => 'Petty Officer, 2nd Class',
		'rank_short_name' => 'PO2',
		'rank_image' => 'b-e5',
		'rank_order' => 16,
		'rank_class' => 1),
	array(
		'rank_name' => 'Petty Officer, 3rd Class',
		'rank_short_name' => 'PO3',
		'rank_image' => 'b-e4',
		'rank_order' => 17,
		'rank_class' => 1),
	array(
		'rank_name' => 'Seaman',
		'rank_short_name' => 'SEA',
		'rank_image' => 'b-e3',
		'rank_order' => 18,
		'rank_class' => 1),
	array(
		'rank_name' => 'Seaman Apprentice',
		'rank_short_name' => 'SAPP',
		'rank_image' => 'b-e2',
		'rank_order' => 19,
		'rank_class' => 1),
	array(
		'rank_name' => 'Seaman Recruit',
		'rank_short_name' => 'SREC',
		'rank_image' => 'b-e1',
		'rank_order' => 20,
		'rank_class' => 1),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'b-blank',
		'rank_order' => 21,
		'rank_class' => 1),
		
	array(
		'rank_name' => 'Admiral',
		'rank_short_name' => 'ADM',
		'rank_image' => 'r-a3',
		'rank_order' => 0,
		'rank_class' => 2),
	array(
		'rank_name' => 'Vice-Admiral',
		'rank_short_name' => 'VADM',
		'rank_image' => 'r-a2',
		'rank_order' => 1,
		'rank_class' => 2),
	array(
		'rank_name' => 'Rear-Admiral',
		'rank_short_name' => 'RADM',
		'rank_image' => 'r-a1',
		'rank_order' => 2,
		'rank_class' => 2),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'r-o6',
		'rank_order' => 3,
		'rank_class' => 2),
	array(
		'rank_name' => 'Commander',
		'rank_short_name' => 'CMDR',
		'rank_image' => 'r-o5',
		'rank_order' => 4,
		'rank_class' => 2),
	array(
		'rank_name' => 'Lieutenant Commander',
		'rank_short_name' => 'LTCMDR',
		'rank_image' => 'r-o4',
		'rank_order' => 5,
		'rank_class' => 2),
	array(
		'rank_name' => 'Lieutenant',
		'rank_short_name' => 'LT',
		'rank_image' => 'r-o3',
		'rank_order' => 6,
		'rank_class' => 2),
	array(
		'rank_name' => 'Lieutenant JG',
		'rank_short_name' => 'LT(JG)',
		'rank_image' => 'r-o2',
		'rank_order' => 7,
		'rank_class' => 2),
	array(
		'rank_name' => 'Ensign',
		'rank_short_name' => 'ENS',
		'rank_image' => 'r-o1',
		'rank_order' => 8,
		'rank_class' => 2),
	array(
		'rank_name' => 'Chief Warrant Officer 3',
		'rank_short_name' => 'CWO3',
		'rank_image' => 'r-w3',
		'rank_order' => 9,
		'rank_class' => 2),
	array(
		'rank_name' => 'Chief Warrant Officer 2',
		'rank_short_name' => 'CWO2',
		'rank_image' => 'r-w2',
		'rank_order' => 10,
		'rank_class' => 2),
	array(
		'rank_name' => 'Warrant Officer',
		'rank_short_name' => 'WO',
		'rank_image' => 'r-w1',
		'rank_order' => 11,
		'rank_class' => 2),
	array(
		'rank_name' => 'Master Chief Petty Officer',
		'rank_short_name' => 'MCPO',
		'rank_image' => 'r-e9',
		'rank_order' => 12,
		'rank_class' => 2),
	array(
		'rank_name' => 'Senior Chief Petty Officer',
		'rank_short_name' => 'SCPO',
		'rank_image' => 'r-e8',
		'rank_order' => 13,
		'rank_class' => 2),
	array(
		'rank_name' => 'Chief Petty Officer',
		'rank_short_name' => 'CPO',
		'rank_image' => 'r-e7',
		'rank_order' => 14,
		'rank_class' => 2),
	array(
		'rank_name' => 'Petty Officer, 1st Class',
		'rank_short_name' => 'PO1',
		'rank_image' => 'r-e6',
		'rank_order' => 15,
		'rank_class' => 2),
	array(
		'rank_name' => 'Petty Officer, 2nd Class',
		'rank_short_name' => 'PO2',
		'rank_image' => 'r-e5',
		'rank_order' => 16,
		'rank_class' => 2),
	array(
		'rank_name' => 'Petty Officer, 3rd Class',
		'rank_short_name' => 'PO3',
		'rank_image' => 'r-e4',
		'rank_order' => 17,
		'rank_class' => 2),
	array(
		'rank_name' => 'Seaman',
		'rank_short_name' => 'SEA',
		'rank_image' => 'r-e3',
		'rank_order' => 18,
		'rank_class' => 2),
	array(
		'rank_name' => 'Seaman Apprentice',
		'rank_short_name' => 'SAPP',
		'rank_image' => 'r-e2',
		'rank_order' => 19,
		'rank_class' => 2),
	array(
		'rank_name' => 'Seaman Recruit',
		'rank_short_name' => 'SREC',
		'rank_image' => 'r-e1',
		'rank_order' => 20,
		'rank_class' => 2),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'r-blank',
		'rank_order' => 21,
		'rank_class' => 2),
		
	array(
		'rank_name' => 'Admiral',
		'rank_short_name' => 'ADM',
		'rank_image' => 'y-a3',
		'rank_order' => 0,
		'rank_class' => 3),
	array(
		'rank_name' => 'Vice-Admiral',
		'rank_short_name' => 'VADM',
		'rank_image' => 'y-a2',
		'rank_order' => 1,
		'rank_class' => 3),
	array(
		'rank_name' => 'Rear-Admiral',
		'rank_short_name' => 'RADM',
		'rank_image' => 'y-a1',
		'rank_order' => 2,
		'rank_class' => 3),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'y-o6',
		'rank_order' => 3,
		'rank_class' => 3),
	array(
		'rank_name' => 'Commander',
		'rank_short_name' => 'CMDR',
		'rank_image' => 'y-o5',
		'rank_order' => 4,
		'rank_class' => 3),
	array(
		'rank_name' => 'Lieutenant Commander',
		'rank_short_name' => 'LTCMDR',
		'rank_image' => 'y-o4',
		'rank_order' => 5,
		'rank_class' => 3),
	array(
		'rank_name' => 'Lieutenant',
		'rank_short_name' => 'LT',
		'rank_image' => 'y-o3',
		'rank_order' => 6,
		'rank_class' => 3),
	array(
		'rank_name' => 'Lieutenant JG',
		'rank_short_name' => 'LT(JG)',
		'rank_image' => 'y-o2',
		'rank_order' => 7,
		'rank_class' => 3),
	array(
		'rank_name' => 'Ensign',
		'rank_short_name' => 'ENS',
		'rank_image' => 'y-o1',
		'rank_order' => 8,
		'rank_class' => 3),
	array(
		'rank_name' => 'Chief Warrant Officer 3',
		'rank_short_name' => 'CWO3',
		'rank_image' => 'y-w3',
		'rank_order' => 9,
		'rank_class' => 3),
	array(
		'rank_name' => 'Chief Warrant Officer 2',
		'rank_short_name' => 'CWO2',
		'rank_image' => 'y-w2',
		'rank_order' => 10,
		'rank_class' => 3),
	array(
		'rank_name' => 'Warrant Officer',
		'rank_short_name' => 'WO',
		'rank_image' => 'y-w1',
		'rank_order' => 11,
		'rank_class' => 3),
	array(
		'rank_name' => 'Master Chief Petty Officer',
		'rank_short_name' => 'MCPO',
		'rank_image' => 'y-e9',
		'rank_order' => 12,
		'rank_class' => 3),
	array(
		'rank_name' => 'Senior Chief Petty Officer',
		'rank_short_name' => 'SCPO',
		'rank_image' => 'y-e8',
		'rank_order' => 13,
		'rank_class' => 3),
	array(
		'rank_name' => 'Chief Petty Officer',
		'rank_short_name' => 'CPO',
		'rank_image' => 'y-e7',
		'rank_order' => 14,
		'rank_class' => 3),
	array(
		'rank_name' => 'Petty Officer, 1st Class',
		'rank_short_name' => 'PO1',
		'rank_image' => 'y-e6',
		'rank_order' => 15,
		'rank_class' => 3),
	array(
		'rank_name' => 'Petty Officer, 2nd Class',
		'rank_short_name' => 'PO2',
		'rank_image' => 'y-e5',
		'rank_order' => 16,
		'rank_class' => 3),
	array(
		'rank_name' => 'Petty Officer, 3rd Class',
		'rank_short_name' => 'PO3',
		'rank_image' => 'y-e4',
		'rank_order' => 17,
		'rank_class' => 3),
	array(
		'rank_name' => 'Seaman',
		'rank_short_name' => 'SEA',
		'rank_image' => 'y-e3',
		'rank_order' => 18,
		'rank_class' => 3),
	array(
		'rank_name' => 'Seaman Apprentice',
		'rank_short_name' => 'SAPP',
		'rank_image' => 'y-e2',
		'rank_order' => 19,
		'rank_class' => 3),
	array(
		'rank_name' => 'Seaman Recruit',
		'rank_short_name' => 'SREC',
		'rank_image' => 'y-e1',
		'rank_order' => 20,
		'rank_class' => 3),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'y-blank',
		'rank_order' => 21,
		'rank_class' => 3),
		
	array(
		'rank_name' => 'Admiral',
		'rank_short_name' => 'ADM',
		'rank_image' => 'w-a3',
		'rank_order' => 0,
		'rank_class' => 4),
	array(
		'rank_name' => 'Vice-Admiral',
		'rank_short_name' => 'VADM',
		'rank_image' => 'w-a2',
		'rank_order' => 1,
		'rank_class' => 4),
	array(
		'rank_name' => 'Rear-Admiral',
		'rank_short_name' => 'RADM',
		'rank_image' => 'w-a1',
		'rank_order' => 2,
		'rank_class' => 4),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'w-o6',
		'rank_order' => 3,
		'rank_class' => 4),
	array(
		'rank_name' => 'Commander',
		'rank_short_name' => 'CMDR',
		'rank_image' => 'w-o5',
		'rank_order' => 4,
		'rank_class' => 4),
	array(
		'rank_name' => 'Lieutenant Commander',
		'rank_short_name' => 'LTCMDR',
		'rank_image' => 'w-o4',
		'rank_order' => 5,
		'rank_class' => 4),
	array(
		'rank_name' => 'Lieutenant',
		'rank_short_name' => 'LT',
		'rank_image' => 'w-o3',
		'rank_order' => 6,
		'rank_class' => 4),
	array(
		'rank_name' => 'Lieutenant JG',
		'rank_short_name' => 'LT(JG)',
		'rank_image' => 'w-o2',
		'rank_order' => 7,
		'rank_class' => 4),
	array(
		'rank_name' => 'Ensign',
		'rank_short_name' => 'ENS',
		'rank_image' => 'w-o1',
		'rank_order' => 8,
		'rank_class' => 4),
	array(
		'rank_name' => 'Chief Warrant Officer 3',
		'rank_short_name' => 'CWO3',
		'rank_image' => 'w-w3',
		'rank_order' => 9,
		'rank_class' => 4),
	array(
		'rank_name' => 'Chief Warrant Officer 2',
		'rank_short_name' => 'CWO2',
		'rank_image' => 'w-w2',
		'rank_order' => 10,
		'rank_class' => 4),
	array(
		'rank_name' => 'Warrant Officer',
		'rank_short_name' => 'WO',
		'rank_image' => 'w-w1',
		'rank_order' => 11,
		'rank_class' => 4),
	array(
		'rank_name' => 'Master Chief Petty Officer',
		'rank_short_name' => 'MCPO',
		'rank_image' => 'w-e9',
		'rank_order' => 12,
		'rank_class' => 4),
	array(
		'rank_name' => 'Senior Chief Petty Officer',
		'rank_short_name' => 'SCPO',
		'rank_image' => 'w-e8',
		'rank_order' => 13,
		'rank_class' => 4),
	array(
		'rank_name' => 'Chief Petty Officer',
		'rank_short_name' => 'CPO',
		'rank_image' => 'w-e7',
		'rank_order' => 14,
		'rank_class' => 4),
	array(
		'rank_name' => 'Petty Officer, 1st Class',
		'rank_short_name' => 'PO1',
		'rank_image' => 'w-e6',
		'rank_order' => 15,
		'rank_class' => 4),
	array(
		'rank_name' => 'Petty Officer, 2nd Class',
		'rank_short_name' => 'PO2',
		'rank_image' => 'w-e5',
		'rank_order' => 16,
		'rank_class' => 4),
	array(
		'rank_name' => 'Petty Officer, 3rd Class',
		'rank_short_name' => 'PO3',
		'rank_image' => 'w-e4',
		'rank_order' => 17,
		'rank_class' => 4),
	array(
		'rank_name' => 'Seaman',
		'rank_short_name' => 'SEA',
		'rank_image' => 'w-e3',
		'rank_order' => 18,
		'rank_class' => 4),
	array(
		'rank_name' => 'Seaman Apprentice',
		'rank_short_name' => 'SAPP',
		'rank_image' => 'w-e2',
		'rank_order' => 19,
		'rank_class' => 4),
	array(
		'rank_name' => 'Seaman Recruit',
		'rank_short_name' => 'SREC',
		'rank_image' => 'w-e1',
		'rank_order' => 20,
		'rank_class' => 4),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'w-blank',
		'rank_order' => 21,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'General',
		'rank_short_name' => 'GEN',
		'rank_image' => 's-a3',
		'rank_order' => 0,
		'rank_class' => 5),
	array(
		'rank_name' => 'Major General',
		'rank_short_name' => 'MAJGEN',
		'rank_image' => 's-a2',
		'rank_order' => 1,
		'rank_class' => 5),
	array(
		'rank_name' => 'Brigadier General',
		'rank_short_name' => 'BRGEN',
		'rank_image' => 's-a1',
		'rank_order' => 2,
		'rank_class' => 5),
	array(
		'rank_name' => 'Colonel',
		'rank_short_name' => 'COL',
		'rank_image' => 's-o6',
		'rank_order' => 3,
		'rank_class' => 5),
	array(
		'rank_name' => 'Lieutenant Colonel',
		'rank_short_name' => 'LTCOL',
		'rank_image' => 's-o5',
		'rank_order' => 4,
		'rank_class' => 5),
	array(
		'rank_name' => 'Major',
		'rank_short_name' => 'MAJ',
		'rank_image' => 's-o4',
		'rank_order' => 5,
		'rank_class' => 5),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 's-o3',
		'rank_order' => 6,
		'rank_class' => 5),
	array(
		'rank_name' => '1st Lieutenant',
		'rank_short_name' => '1LT',
		'rank_image' => 's-o2',
		'rank_order' => 7,
		'rank_class' => 5),
	array(
		'rank_name' => '2nd Lieutenant',
		'rank_short_name' => '2LT',
		'rank_image' => 's-o1',
		'rank_order' => 8,
		'rank_class' => 5),
	array(
		'rank_name' => 'Chief Warrant Officer 3',
		'rank_short_name' => 'CWO3',
		'rank_image' => 's-w3',
		'rank_order' => 9,
		'rank_class' => 5),
	array(
		'rank_name' => 'Chief Warrant Officer 2',
		'rank_short_name' => 'CWO2',
		'rank_image' => 's-w2',
		'rank_order' => 10,
		'rank_class' => 5),
	array(
		'rank_name' => 'Warrant Officer',
		'rank_short_name' => 'WO',
		'rank_image' => 's-w1',
		'rank_order' => 11,
		'rank_class' => 5),
	array(
		'rank_name' => 'Sergeant Major',
		'rank_short_name' => 'SGTMAJ',
		'rank_image' => 's-e9',
		'rank_order' => 12,
		'rank_class' => 5),
	array(
		'rank_name' => 'Master Sergeant',
		'rank_short_name' => 'MSGT',
		'rank_image' => 's-e8',
		'rank_order' => 13,
		'rank_class' => 5),
	array(
		'rank_name' => 'Gunnery Sergeant',
		'rank_short_name' => 'GNYSGT',
		'rank_image' => 's-e7',
		'rank_order' => 14,
		'rank_class' => 5),
	array(
		'rank_name' => 'Staff Sergeant',
		'rank_short_name' => 'SSGT',
		'rank_image' => 's-e6',
		'rank_order' => 15,
		'rank_class' => 5),
	array(
		'rank_name' => 'Sergeant',
		'rank_short_name' => 'SGT',
		'rank_image' => 's-e5',
		'rank_order' => 16,
		'rank_class' => 5),
	array(
		'rank_name' => 'Corporal',
		'rank_short_name' => 'CPL',
		'rank_image' => 's-e4',
		'rank_order' => 17,
		'rank_class' => 5),
	array(
		'rank_name' => 'Lance Corporal',
		'rank_short_name' => 'LCPL',
		'rank_image' => 's-e3',
		'rank_order' => 18,
		'rank_class' => 5),
	array(
		'rank_name' => 'Private 1st Class',
		'rank_short_name' => 'PVT1',
		'rank_image' => 's-e2',
		'rank_order' => 19,
		'rank_class' => 5),
	array(
		'rank_name' => 'Private',
		'rank_short_name' => 'PVT',
		'rank_image' => 's-e1',
		'rank_order' => 20,
		'rank_class' => 5),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 's-blank',
		'rank_order' => 21,
		'rank_class' => 5),
);

$positions = array(
	array(
		'pos_name' => 'Commanding Officer',
		'pos_desc' => "Ultimately responsible for the ship and crew, the Commanding Officer is the most senior officer aboard a vessel. S/he is responsible for carrying out the orders of the President and for representing the UEO. While their official title of the commander of a ship, they are usually referred to as \"the Captain\" regardless of their actual rank, or informally referred to as \"Skipper\".",
		'pos_dept' => 1,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Executive Officer',
		'pos_desc' => "The liaison between captain and crew, the Executive Officer acts as the disciplinarian, personnel manager, advisor to the captain, and much more. S/he is also one of only two officers, along with the Chief Medical Officer, that can remove a Commanding Officer from duty.",
		'pos_dept' => 1,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Chief of the Boat',
		'pos_desc' => "Usually the senior enlisted sailor aboard a submarine, the Chief of the Boat is an enlisted sailor who serves as the senior enlisted advisor to the Commanding Officer and Executive Officer, and assists with matters regarding the good order and discipline of the crew. The Chief of the Boat is generally responsible for the day-to-day operations of the non-engineering portion of the ship, the morale and the training of the boat's enlisted personnel.",
		'pos_dept' => 1,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Yeoman',
		'pos_desc' => "The yeoman is a secretarial, clerical or payroll position responsible for administrative duties and reports to the Commanding Officer to aid him/her in their day-to-day duties.",
		'pos_dept' => 1,
		'pos_order' => 3,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Chief Helmsman',
		'pos_desc' => "The Chief Helmsman is the seniormost officer in the Helm Department and is responsible for all navigation aboard the ship. Standing watch on the Bridge at least one shift a day, the Helmsman coordinates with navigators and drivers to move the vessel at the orders of the Commanding and Executive Officers.",
		'pos_dept' => 2,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Helmsman',
		'pos_desc' => "Helmsmen aboard UEO vessels are responsible for coordination between the navigators and drivers for moving the vessel at the orders of the Commanding and Executive Officers. Expert drivers or navigators themselves, helmsmen will often take the reins of the ship in difficult situations that require more expertise.",
		'pos_dept' => 2,
		'pos_order' => 1,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Navigator',
		'pos_desc' => "Navigators aboard UEO vessels are responsible for understanding undersea topography and safely navigating around underwater mountain ranges and other potentially hazardous areas of the oceans. Navigators must be oceanographic experts and thorough understand the use (and dangers) of thermal layers in the ocean as well as any other potential dangers in order to safely navigate the ship to where the Commanding and Executive Officers order."
		'pos_dept' => 2,
		'pos_order' => 2,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Driver',
		'pos_desc' => "Responsible for executing the orders of the helmsmen, sub drivers are the 'feet on the pedals' of the ship. Sub drivers are traditionally enlisted officers working their way toward a navigator or helmsman position. Because of the advanced nature of sub driving, these enlisted sailors are required to constantly undergo re-certification for their job.",
		'pos_dept' => 2,
		'pos_order' => 2,
		'pos_open' => 15,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Mini-Sub Driver',
		'pos_desc' => "Often fresh out of training school, mini-sub drivers are sub drivers in training and gain further training through driver the various mini-subs assigned to the ship. It is not uncommon for mini-sub drivers to be given opportunities to drive the ship at the discretion of the Chief Helmsman as they continue their training and certification.",
		'pos_dept' => 2,
		'pos_order' => 2,
		'pos_open' => 5,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Chief Sonar Officer',
		'pos_desc' => "The Chief Sonar Officer, also known as the Sensor Chief, is the seniormost Sonar officer aboard the ship and is responsible for the operation of all sonar equipment aboard the ship, including expert knowledge of the UEO's Wireless Sea Knowledge Retrieval Satellites (WSKRS) that are deployed on a wide variety of UEO vessels to date.",
		'pos_dept' => 3,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Sonar Technician',
		'pos_desc' => "Sonar Technicians are responsible for the operation and maintenance of sonar systems aboard the ship under the direction of the Chief Sonar Officer.",
		'pos_dept' => 3,
		'pos_order' => 1,
		'pos_open' => 10,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Chief Communications Officer',
		'pos_desc' => "The Chief Communications Officer is the head of the Communications Department and is responsible for all communication systems on the ship. In addition to standard communication channels and protocol, the Chief Communications Officer must also monitor and use military communication channels. Out of everyone in the Communications Department, the Chief needs to be multi-lingual to help in communicating with other confederations.",
		'pos_dept' => 4,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Communications Officer',
		'pos_desc' => "Like the head of the department, a Communication Officer works with the Chief to keep all the communication systems on the ship running in top form. While usually multi-lingual, a Communication Officer rarely has the profiency with languages the Chief does. Like other positions in the UEO, a Communication Officer must constantly undergo certification training as well as additional language training.",
		'pos_dept' => 4,
		'pos_order' => 1,
		'pos_open' => 5,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Chief of the Deck',
		'pos_desc' => "The Deck Chief is responsible the overall repair and readiness of all combat spacecraft on a battlestar.",
		'pos_dept' => 5,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Landing Signal Officer',
		'pos_desc' => "The Landing Signal Officer (LSO) is the officer who is responsible for all flight operations on the flight pods of battlestars and other military vessels. This includes the landing of all vessels, from Vipers and Raptors to small liners, as well as the operation of the launch tubes.",
		'pos_dept' => 5,
		'pos_order' => 5,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Deckhand',
		'pos_desc' => "Deckhands are multi-faceted crewmembers on battlestars who prepare and maintain Colonial fighters and reconnaissance vehicles for flight and turnaround.",
		'pos_dept' => 5,
		'pos_order' => 10,
		'pos_open' => 5,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Chief Medical Officer',
		'pos_desc' => "The Chief Medical Officer is responsible for the physical health of the entire crew, but does more than patch up injured crew members. His/her function is to ensure that they do not get sick or injured to begin with, and to this end monitors their health and conditioning with regular check ups. If necessary, the Chief Medical Officer can remove anyone from duty, even a Commanding Officer. Besides this s/he is available to provide medical advice to any individual who requests it.\r\n\r\nS/he also is a department head and a member of the Senior Staff and responsible for all the crew members in her/his department and duty rosters.",
		'pos_dept' => 6,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Medical Officer',
		'pos_desc' => "Medical Officer undertake the majority of the work aboard the ship/facility, examining the crew, and administering medical care under the instruction of the Chief Medical Officer. Medical Officers also run the other Medical areas not directly overseen by the Chief Medical Officer.",
		'pos_dept' => 6,
		'pos_order' => 5,
		'pos_open' => 3,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Medic',
		'pos_desc' => "S/he is responsible for providing first aid and trauma care on the battlefield.",
		'pos_dept' => 6,
		'pos_order' => 10,
		'pos_open' => 3,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Chief Engineering Officer',
		'pos_desc' => "The Chief Engineer is responsible for the condition of all systems and equipment on board a battlestar or facility. S/he oversees maintenance, repairs and upgrades of all equipment. S/he is also responsible for the many repairs teams during crisis situations. The Chief Engineer is not only the department head but also a senior officer, responsible for all the crew members in her/his department and maintenance of the duty rosters.",
		'pos_dept' => 7,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Engineering Officer',
		'pos_desc' => "There are several non-specialized engineers aboard of each vessel. They are assigned to their duties by the Chief Engineer and his Assistant, performing a number of different tasks as required, i.e. general maintenance and repair. Generally, engineers as assigned to more specialized engineering person to assist in there work is so requested by the specialized engineer.",
		'pos_dept' => 7,
		'pos_order' => 2,
		'pos_open' => 3,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Communications Specialist',
		'pos_desc' => "This engineer maintains all the communication systems throughout the battlestar.",
		'pos_dept' => 7,
		'pos_order' => 5,
		'pos_open' => 3,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Master-At-Arms',
		'pos_desc' => "The Master-at-Arms is a non-commissioned officer responsible for internal security aboard Colonial warships, including battlestars. ",
		'pos_dept' => 8,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Marine',
		'pos_desc' => "The Colonial Marine Corps is a branch of the Colonial Forces tasked with ground combat operations and ship-board security.",
		'pos_dept' => 8,
		'pos_order' => 1,
		'pos_open' => 5,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Priest',
		'pos_desc' => "Priests also preside over military funerals, without regard for the beliefs of the deceased. Priests in the Twelve Colonies are apparently not required to practice celibacy, and can be male or female.",
		'pos_dept' => 9,
		'pos_order' => 0,
		'pos_open' => 2,
		'pos_type' => 'enlisted')
);

$catalogue_ranks = array(
	array(
		'rankcat_name' => 'Duty Uniform',
		'rankcat_location' => 'default',
		'rankcat_credits' => "The seaQuest DSV rank set used in Nova were created by Anodyne Productions from the Beneath the Sea font. Please do not copy or modify the images.",
		'rankcat_default' => 'y',
		'rankcat_url' => 'http://xtras.anodyne-productions.com/',
		'rankcat_genre' => $g),
);

/* End of file install_data_sq.php */
/* Location: ./application/assets/install/install_data_sq.php */