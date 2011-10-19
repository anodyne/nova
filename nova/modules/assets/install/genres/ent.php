<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Install Genre - ENT
 *
 * @package		Nova
 * @category	Genre
 * @author		Moss (Anodyne forums)
 * @author		Vorn Krace (Anodyne forums)
 */
 
$g = 'ent';

$data = array(
	'departments_'. $g 	=> 'depts',
	'ranks_'. $g		=> 'ranks',
	'positions_'. $g	=> 'positions',
	'catalogue_ranks'	=> 'catalogue_ranks',
);

$depts = array(
	array(
		'dept_name' => 'Command',
		'dept_desc' => "The Command department is ultimately responsible for the ship and its crew, and those within the department are responsible for commanding the vessel and representing the interests of Starfleet.",
		'dept_order' => 0,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Helm',
		'dept_desc' => "Responsible for the navigation and flight control of a vessel and its auxiliary craft, the Helm division includes pilots trained in both starship and auxiliary craft piloting.",
		'dept_order' => 1,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Armory',
		'dept_desc' => "Merging the responsibilities of ship to ship and personnel combat into a single department, the armory division is responsible for the tactical readiness of the vessel and the security of the ship.",
		'dept_order' => 2,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Engineering',
		'dept_desc' => "The engineering division has the enormous task of keeping the ship working; they are responsible for making repairs, fixing problems, and making sure that the ship is ready for anything.",
		'dept_order' => 3,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Science',
		'dept_desc' => "From sensor readings to figuring out a way to enter the strange spacial anomaly, the science division is responsible for recording data, testing new ideas out, and making discoveries.",
		'dept_order' => 4,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Medical',
		'dept_desc' => "The medical division is responsible for the mental and physical health of the crew, from running annual physicals to combatting a strange plague that is afflicting the crew to helping a crew member deal with the loss of a loved one.",
		'dept_order' => 5,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Communications',
		'dept_desc' => "The Communications department is responsible for the operation of the Starfleet's communications systems. On many ships the Communications department is simply amalgamated with Operations; it is often only on Flagships (where a large amount of communications traffic can be received in a very short space of time) and Starbases (where there is an extremely large amount of communications traffic at almost all times).",
		'dept_order' => 6,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'MACO Detachment',
		'dept_desc' => "When the standard security detail is not enough, MACOs come in and clean up; the MACO detachment is a powerful tactical addition to any ship, responsible for partaking in personal combat from sniping to melee.",
		'dept_order' => 7,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Civilians',
		'dept_desc' => "Civilians play an important role in Starfleet. Many civilian specialists across a number of fields work on occasion with Starfleet personnel as a Mission Specialist. In other cases, extra ship and station duties, such as running the ship's lounge, are outsourced to a civilian contract.",
		'dept_order' => 8,
		'dept_manifest' => 1),
);

$ranks = array(
	array(
		'rank_name' => 'Fleet Admiral',
		'rank_short_name' => 'FADM',
		'rank_image' => 'y-a5',
		'rank_order' => 0,
		'rank_class' => 1),
	array(
		'rank_name' => 'Fleet Admiral',
		'rank_short_name' => 'FADM',
		'rank_image' => 'r-a5',
		'rank_order' => 0,
		'rank_class' => 2),
	array(
		'rank_name' => 'Fleet Admiral',
		'rank_short_name' => 'FADM',
		'rank_image' => 't-a5',
		'rank_order' => 0,
		'rank_class' => 3),
	array(
		'rank_name' => 'Field Marshal',
		'rank_short_name' => 'FMSL',
		'rank_image' => 'maco-a5',
		'rank_order' => 0,
		'rank_class' => 4),
	array(
		'rank_name' => 'Fleet Admiral',
		'rank_short_name' => 'FADM',
		'rank_image' => 'g-a5',
		'rank_order' => 0,
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Admiral',
		'rank_short_name' => 'ADM',
		'rank_image' => 'y-a4',
		'rank_order' => 1,
		'rank_class' => 1),
	array(
		'rank_name' => 'Admiral',
		'rank_short_name' => 'ADM',
		'rank_image' => 'r-a4',
		'rank_order' => 1,
		'rank_class' => 2),
	array(
		'rank_name' => 'Admiral',
		'rank_short_name' => 'ADM',
		'rank_image' => 't-a4',
		'rank_order' => 1,
		'rank_class' => 3),
	array(
		'rank_name' => 'General',
		'rank_short_name' => 'GEN',
		'rank_image' => 'maco-a4',
		'rank_order' => 1,
		'rank_class' => 4),
	array(
		'rank_name' => 'Admiral',
		'rank_short_name' => 'ADM',
		'rank_image' => 'g-a4',
		'rank_order' => 1,
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Vice-Admiral',
		'rank_short_name' => 'VADM',
		'rank_image' => 'y-a3',
		'rank_order' => 2,
		'rank_class' => 1),
	array(
		'rank_name' => 'Vice-Admiral',
		'rank_short_name' => 'VADM',
		'rank_image' => 'r-a3',
		'rank_order' => 2,
		'rank_class' => 2),
	array(
		'rank_name' => 'Vice-Admiral',
		'rank_short_name' => 'VADM',
		'rank_image' => 't-a3',
		'rank_order' => 2,
		'rank_class' => 3),
	array(
		'rank_name' => 'Lieutenant General',
		'rank_short_name' => 'LTGEN',
		'rank_image' => 'maco-a3',
		'rank_order' => 2,
		'rank_class' => 4),
	array(
		'rank_name' => 'Vice-Admiral',
		'rank_short_name' => 'VADM',
		'rank_image' => 'g-a3',
		'rank_order' => 2,
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Rear-Admiral',
		'rank_short_name' => 'RADM',
		'rank_image' => 'y-a2',
		'rank_order' => 3,
		'rank_class' => 1),
	array(
		'rank_name' => 'Rear-Admiral',
		'rank_short_name' => 'RADM',
		'rank_image' => 'r-a2',
		'rank_order' => 3,
		'rank_class' => 2),
	array(
		'rank_name' => 'Rear-Admiral',
		'rank_short_name' => 'RADM',
		'rank_image' => 't-a2',
		'rank_order' => 3,
		'rank_class' => 3),
	array(
		'rank_name' => 'Major General',
		'rank_short_name' => 'MAJGEN',
		'rank_image' => 'maco-a2',
		'rank_order' => 3,
		'rank_class' => 4),
	array(
		'rank_name' => 'Rear-Admiral',
		'rank_short_name' => 'RADM',
		'rank_image' => 'g-a2',
		'rank_order' => 3,
		'rank_class' => 5),
	array(
		'rank_name' => 'Admiral',
		'rank_short_name' => 'ADM',
		'rank_image' => 'v-o8',
		'rank_order' => 0,
		'rank_class' => 6),
		
	array(
		'rank_name' => 'Commodore',
		'rank_short_name' => 'COM',
		'rank_image' => 'y-a1',
		'rank_order' => 4,
		'rank_class' => 1),
	array(
		'rank_name' => 'Commodore',
		'rank_short_name' => 'COM',
		'rank_image' => 'r-a1',
		'rank_order' => 4,
		'rank_class' => 2),
	array(
		'rank_name' => 'Commodore',
		'rank_short_name' => 'COM',
		'rank_image' => 't-a1',
		'rank_order' => 4,
		'rank_class' => 3),
	array(
		'rank_name' => 'Brigadier General',
		'rank_short_name' => 'BGEN',
		'rank_image' => 'maco-a1',
		'rank_order' => 4,
		'rank_class' => 4),
	array(
		'rank_name' => 'Commodore',
		'rank_short_name' => 'COM',
		'rank_image' => 'g-a1',
		'rank_order' => 4,
		'rank_class' => 5),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'v-o7',
		'rank_order' => 1,
		'rank_class' => 6),
		
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'y-o6',
		'rank_order' => 5,
		'rank_class' => 1),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'r-o6',
		'rank_order' => 5,
		'rank_class' => 2),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 't-o6',
		'rank_order' => 5,
		'rank_class' => 3),
	array(
		'rank_name' => 'Colonel',
		'rank_short_name' => 'COL',
		'rank_image' => 'maco-o6',
		'rank_order' => 5,
		'rank_class' => 4),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'g-o6',
		'rank_order' => 5,
		'rank_class' => 5),
	array(
		'rank_name' => 'Commander',
		'rank_short_name' => 'CMDR',
		'rank_image' => 'v-o6',
		'rank_order' => 2,
		'rank_class' => 6),
	
	array(
		'rank_name' => 'Commander',
		'rank_short_name' => 'CMDR',
		'rank_image' => 'y-o5',
		'rank_order' => 6,
		'rank_class' => 1),
	array(
		'rank_name' => 'Commander',
		'rank_short_name' => 'CMDR',
		'rank_image' => 'r-o5',
		'rank_order' => 6,
		'rank_class' => 2),
	array(
		'rank_name' => 'Commander',
		'rank_short_name' => 'CMDR',
		'rank_image' => 't-o5',
		'rank_order' => 6,
		'rank_class' => 3),
	array(
		'rank_name' => 'Lieutenant Colonel',
		'rank_short_name' => 'LTCOL',
		'rank_image' => 'maco-o5',
		'rank_order' => 6,
		'rank_class' => 4),
	array(
		'rank_name' => 'Commander',
		'rank_short_name' => 'CMDR',
		'rank_image' => 'g-o5',
		'rank_order' => 6,
		'rank_class' => 5),
	array(
		'rank_name' => 'Sub-Commander',
		'rank_short_name' => 'SCMDR',
		'rank_image' => 'v-o5',
		'rank_order' => 3,
		'rank_class' => 6),
		
	array(
		'rank_name' => 'Lieutenant Commander',
		'rank_short_name' => 'LTCMDR',
		'rank_image' => 'y-o4',
		'rank_order' => 7,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant Commander',
		'rank_short_name' => 'LTCMDR',
		'rank_image' => 'r-o4',
		'rank_order' => 7,
		'rank_class' => 2),
	array(
		'rank_name' => 'Lieutenant Commander',
		'rank_short_name' => 'LTCMDR',
		'rank_image' => 't-o4',
		'rank_order' => 7,
		'rank_class' => 3),
	array(
		'rank_name' => 'Major',
		'rank_short_name' => 'MAJ',
		'rank_image' => 'maco-o4',
		'rank_order' => 7,
		'rank_class' => 4),
	array(
		'rank_name' => 'Lieutenant Commander',
		'rank_short_name' => 'LTCMDR',
		'rank_image' => 'g-o4',
		'rank_order' => 7,
		'rank_class' => 5),
	array(
		'rank_name' => 'Major',
		'rank_short_name' => 'MAJ',
		'rank_image' => 'v-o4',
		'rank_order' => 4,
		'rank_class' => 6),
		
	array(
		'rank_name' => 'Lieutenant',
		'rank_short_name' => 'LT',
		'rank_image' => 'y-o3',
		'rank_order' => 8,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant',
		'rank_short_name' => 'LT',
		'rank_image' => 'r-o3',
		'rank_order' => 8,
		'rank_class' => 2),
	array(
		'rank_name' => 'Lieutenant',
		'rank_short_name' => 'LT',
		'rank_image' => 't-o3',
		'rank_order' => 8,
		'rank_class' => 3),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'maco-o3',
		'rank_order' => 8,
		'rank_class' => 4),
	array(
		'rank_name' => 'Lieutenant',
		'rank_short_name' => 'LT',
		'rank_image' => 'g-o3',
		'rank_order' => 8,
		'rank_class' => 5),
	array(
		'rank_name' => 'Lieutenant',
		'rank_short_name' => 'LT',
		'rank_image' => 'v-o3',
		'rank_order' => 5,
		'rank_class' => 6),
		
	array(
		'rank_name' => 'Lieutenant JG',
		'rank_short_name' => 'LT(JG)',
		'rank_image' => 'y-o2',
		'rank_order' => 9,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant JG',
		'rank_short_name' => 'LT(JG)',
		'rank_image' => 'r-o2',
		'rank_order' => 9,
		'rank_class' => 2),
	array(
		'rank_name' => 'Lieutenant JG',
		'rank_short_name' => 'LT(JG)',
		'rank_image' => 't-o2',
		'rank_order' => 9,
		'rank_class' => 3),
	array(
		'rank_name' => '1st Lieutenant',
		'rank_short_name' => '1LT',
		'rank_image' => 'maco-o2',
		'rank_order' => 9,
		'rank_class' => 4),
	array(
		'rank_name' => 'Lieutenant JG',
		'rank_short_name' => 'LT(JG)',
		'rank_image' => 'g-o2',
		'rank_order' => 9,
		'rank_class' => 5),
	array(
		'rank_name' => 'Sub-Lieutenant',
		'rank_short_name' => 'SLT',
		'rank_image' => 'v-o2',
		'rank_order' => 6,
		'rank_class' => 6),
		
	array(
		'rank_name' => 'Ensign',
		'rank_short_name' => 'ENS',
		'rank_image' => 'y-o1',
		'rank_order' => 10,
		'rank_class' => 1),
	array(
		'rank_name' => 'Ensign',
		'rank_short_name' => 'ENS',
		'rank_image' => 'r-o1',
		'rank_order' => 10,
		'rank_class' => 2),
	array(
		'rank_name' => 'Ensign',
		'rank_short_name' => 'ENS',
		'rank_image' => 't-o1',
		'rank_order' => 10,
		'rank_class' => 3),
	array(
		'rank_name' => '2nd Lieutenant',
		'rank_short_name' => '2LT',
		'rank_image' => 'maco-o1',
		'rank_order' => 10,
		'rank_class' => 4),
	array(
		'rank_name' => 'Ensign',
		'rank_short_name' => 'ENS',
		'rank_image' => 'g-o1',
		'rank_order' => 10,
		'rank_class' => 5),
	array(
		'rank_name' => 'Uhlan',
		'rank_short_name' => 'UHL',
		'rank_image' => 'v-o1',
		'rank_order' => 7,
		'rank_class' => 6),
		
	array(
		'rank_name' => 'Warrant Officer',
		'rank_short_name' => 'WO',
		'rank_image' => 'y-w1',
		'rank_order' => 11,
		'rank_class' => 1),
	array(
		'rank_name' => 'Warrant Officer',
		'rank_short_name' => 'WO',
		'rank_image' => 'r-w1',
		'rank_order' => 11,
		'rank_class' => 2),
	array(
		'rank_name' => 'Warrant Officer',
		'rank_short_name' => 'WO',
		'rank_image' => 't-w1',
		'rank_order' => 11,
		'rank_class' => 3),
	array(
		'rank_name' => 'Warrant Officer',
		'rank_short_name' => 'WO',
		'rank_image' => 'maco-w1',
		'rank_order' => 11,
		'rank_class' => 4),
	array(
		'rank_name' => 'Warrant Officer',
		'rank_short_name' => 'WO',
		'rank_image' => 'g-w1',
		'rank_order' => 11,
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Master Chief Petty Officer',
		'rank_short_name' => 'MCPO',
		'rank_image' => 'y-e9',
		'rank_order' => 12,
		'rank_class' => 1),
	array(
		'rank_name' => 'Master Chief Petty Officer',
		'rank_short_name' => 'MCPO',
		'rank_image' => 'r-e9',
		'rank_order' => 12,
		'rank_class' => 2),
	array(
		'rank_name' => 'Master Chief Petty Officer',
		'rank_short_name' => 'MCPO',
		'rank_image' => 't-e9',
		'rank_order' => 12,
		'rank_class' => 3),
	array(
		'rank_name' => 'Sergeant Major',
		'rank_short_name' => 'SGTMAJ',
		'rank_image' => 'maco-e9',
		'rank_order' => 12,
		'rank_class' => 4),
	array(
		'rank_name' => 'Master Chief Petty Officer',
		'rank_short_name' => 'MCPO',
		'rank_image' => 'g-e9',
		'rank_order' => 12,
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Senior Chief Petty Officer',
		'rank_short_name' => 'SCPO',
		'rank_image' => 'y-e8',
		'rank_order' => 13,
		'rank_class' => 1),
	array(
		'rank_name' => 'Senior Chief Petty Officer',
		'rank_short_name' => 'SCPO',
		'rank_image' => 'r-e8',
		'rank_order' => 13,
		'rank_class' => 2),
	array(
		'rank_name' => 'Senior Chief Petty Officer',
		'rank_short_name' => 'SCPO',
		'rank_image' => 't-e8',
		'rank_order' => 13,
		'rank_class' => 3),
	array(
		'rank_name' => 'Master Sergeant',
		'rank_short_name' => 'MSGT',
		'rank_image' => 'maco-e8',
		'rank_order' => 13,
		'rank_class' => 4),
	array(
		'rank_name' => 'Senior Chief Petty Officer',
		'rank_short_name' => 'SCPO',
		'rank_image' => 'g-e8',
		'rank_order' => 13,
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Chief Petty Officer',
		'rank_short_name' => 'CPO',
		'rank_image' => 'y-e7',
		'rank_order' => 14,
		'rank_class' => 1),
	array(
		'rank_name' => 'Chief Petty Officer',
		'rank_short_name' => 'CPO',
		'rank_image' => 'r-e7',
		'rank_order' => 14,
		'rank_class' => 2),
	array(
		'rank_name' => 'Chief Petty Officer',
		'rank_short_name' => 'CPO',
		'rank_image' => 't-e7',
		'rank_order' => 14,
		'rank_class' => 3),
	array(
		'rank_name' => 'Gunnery Sergeant',
		'rank_short_name' => 'GYSGT',
		'rank_image' => 'maco-e7',
		'rank_order' => 14,
		'rank_class' => 4),
	array(
		'rank_name' => 'Chief Petty Officer',
		'rank_short_name' => 'CPO',
		'rank_image' => 'g-e7',
		'rank_order' => 14,
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Petty Officer, 1st Class',
		'rank_short_name' => 'PO1',
		'rank_image' => 'y-e6',
		'rank_order' => 15,
		'rank_class' => 1),
	array(
		'rank_name' => 'Petty Officer, 1st Class',
		'rank_short_name' => 'PO1',
		'rank_image' => 'r-e6',
		'rank_order' => 15,
		'rank_class' => 2),
	array(
		'rank_name' => 'Petty Officer, 1st Class',
		'rank_short_name' => 'PO1',
		'rank_image' => 't-e6',
		'rank_order' => 15,
		'rank_class' => 3),
	array(
		'rank_name' => 'Staff Sergeant',
		'rank_short_name' => 'SSGT',
		'rank_image' => 'maco-e6',
		'rank_order' => 15,
		'rank_class' => 4),
	array(
		'rank_name' => 'Petty Officer, 1st Class',
		'rank_short_name' => 'PO1',
		'rank_image' => 'g-e6',
		'rank_order' => 15,
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Petty Officer, 2nd Class',
		'rank_short_name' => 'PO2',
		'rank_image' => 'y-e5',
		'rank_order' => 16,
		'rank_class' => 1),
	array(
		'rank_name' => 'Petty Officer, 2nd Class',
		'rank_short_name' => 'PO2',
		'rank_image' => 'r-e5',
		'rank_order' => 16,
		'rank_class' => 2),
	array(
		'rank_name' => 'Petty Officer, 2nd Class',
		'rank_short_name' => 'PO2',
		'rank_image' => 't-e5',
		'rank_order' => 16,
		'rank_class' => 3),
	array(
		'rank_name' => 'Sergeant',
		'rank_short_name' => 'SGT',
		'rank_image' => 'maco-e5',
		'rank_order' => 16,
		'rank_class' => 4),
	array(
		'rank_name' => 'Petty Officer, 2nd Class',
		'rank_short_name' => 'PO2',
		'rank_image' => 'g-e5',
		'rank_order' => 16,
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Petty Officer, 3rd Class',
		'rank_short_name' => 'PO3',
		'rank_image' => 'y-e4',
		'rank_order' => 17,
		'rank_class' => 1),
	array(
		'rank_name' => 'Petty Officer, 3rd Class',
		'rank_short_name' => 'PO3',
		'rank_image' => 'r-e4',
		'rank_order' => 17,
		'rank_class' => 2),
	array(
		'rank_name' => 'Petty Officer, 3rd Class',
		'rank_short_name' => 'PO3',
		'rank_image' => 't-e4',
		'rank_order' => 17,
		'rank_class' => 3),
	array(
		'rank_name' => 'Corporal',
		'rank_short_name' => 'CPL',
		'rank_image' => 'maco-e4',
		'rank_order' => 17,
		'rank_class' => 4),
	array(
		'rank_name' => 'Petty Officer, 3rd Class',
		'rank_short_name' => 'PO3',
		'rank_image' => 'g-e4',
		'rank_order' => 17,
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Crewman',
		'rank_short_name' => 'CN',
		'rank_image' => 'y-e3',
		'rank_order' => 18,
		'rank_class' => 1),
	array(
		'rank_name' => 'Crewman',
		'rank_short_name' => 'CN',
		'rank_image' => 'r-e3',
		'rank_order' => 18,
		'rank_class' => 2),
	array(
		'rank_name' => 'Crewman',
		'rank_short_name' => 'CN',
		'rank_image' => 't-e3',
		'rank_order' => 18,
		'rank_class' => 3),
	array(
		'rank_name' => 'Lance Corporal',
		'rank_short_name' => 'LCPL',
		'rank_image' => 'maco-e3',
		'rank_order' => 18,
		'rank_class' => 4),
	array(
		'rank_name' => 'Crewman',
		'rank_short_name' => 'CN',
		'rank_image' => 'g-e3',
		'rank_order' => 18,
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Crewman Apprentice',
		'rank_short_name' => 'CA',
		'rank_image' => 'y-e2',
		'rank_order' => 19,
		'rank_class' => 1),
	array(
		'rank_name' => 'Crewman Apprentice',
		'rank_short_name' => 'CA',
		'rank_image' => 'r-e2',
		'rank_order' => 19,
		'rank_class' => 2),
	array(
		'rank_name' => 'Crewman Apprentice',
		'rank_short_name' => 'CA',
		'rank_image' => 't-e2',
		'rank_order' => 19,
		'rank_class' => 3),
	array(
		'rank_name' => 'Private 1st Class',
		'rank_short_name' => 'PFC',
		'rank_image' => 'maco-e2',
		'rank_order' => 19,
		'rank_class' => 4),
	array(
		'rank_name' => 'Crewman Apprentice',
		'rank_short_name' => 'CA',
		'rank_image' => 'g-e2',
		'rank_order' => 19,
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Crewman Recruit',
		'rank_short_name' => 'CR',
		'rank_image' => 'y-e1',
		'rank_order' => 20,
		'rank_class' => 1),
	array(
		'rank_name' => 'Crewman Recruit',
		'rank_short_name' => 'CR',
		'rank_image' => 'r-e1',
		'rank_order' => 20,
		'rank_class' => 2),
	array(
		'rank_name' => 'Crewman Recruit',
		'rank_short_name' => 'CR',
		'rank_image' => 't-e1',
		'rank_order' => 20,
		'rank_class' => 3),
	array(
		'rank_name' => 'Private',
		'rank_short_name' => 'PVT',
		'rank_image' => 'maco-e1',
		'rank_order' => 20,
		'rank_class' => 4),
	array(
		'rank_name' => 'Crewman Recruit',
		'rank_short_name' => 'CR',
		'rank_image' => 'g-e1',
		'rank_order' => 20,
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Cadet Senior Grade',
		'rank_short_name' => 'CDT(SR)',
		'rank_image' => 'c4',
		'rank_order' => 21,
		'rank_display' => 'n',
		'rank_class' => 1),
	array(
		'rank_name' => 'Cadet Senior Grade',
		'rank_short_name' => 'CDT(SR)',
		'rank_image' => 'c4',
		'rank_order' => 21,
		'rank_display' => 'n',
		'rank_class' => 2),
	array(
		'rank_name' => 'Cadet Senior Grade',
		'rank_short_name' => 'CDT(SR)',
		'rank_image' => 'c4',
		'rank_order' => 21,
		'rank_display' => 'n',
		'rank_class' => 3),
	array(
		'rank_name' => 'Cadet Senior Grade',
		'rank_short_name' => 'CDT(SR)',
		'rank_image' => 'c4',
		'rank_order' => 21,
		'rank_display' => 'n',
		'rank_class' => 4),
	array(
		'rank_name' => 'Cadet Senior Grade',
		'rank_short_name' => 'CDT(SR)',
		'rank_image' => 'c4',
		'rank_order' => 21,
		'rank_display' => 'n',
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Cadet Junior Grade',
		'rank_short_name' => 'CDT(JR)',
		'rank_image' => 'c3',
		'rank_order' => 22,
		'rank_display' => 'n',
		'rank_class' => 1),
	array(
		'rank_name' => 'Cadet Junior Grade',
		'rank_short_name' => 'CDT(JR)',
		'rank_image' => 'c3',
		'rank_order' => 22,
		'rank_display' => 'n',
		'rank_class' => 2),
	array(
		'rank_name' => 'Cadet Junior Grade',
		'rank_short_name' => 'CDT(JR)',
		'rank_image' => 'c3',
		'rank_order' => 22,
		'rank_display' => 'n',
		'rank_class' => 3),
	array(
		'rank_name' => 'Cadet Junior Grade',
		'rank_short_name' => 'CDT(JR)',
		'rank_image' => 'c3',
		'rank_order' => 22,
		'rank_display' => 'n',
		'rank_class' => 4),
	array(
		'rank_name' => 'Cadet Junior Grade',
		'rank_short_name' => 'CDT(JR)',
		'rank_image' => 'c3',
		'rank_order' => 22,
		'rank_display' => 'n',
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Cadet Sophomore Grade',
		'rank_short_name' => 'CDT(SO)',
		'rank_image' => 'c2',
		'rank_order' => 23,
		'rank_display' => 'n',
		'rank_class' => 1),
	array(
		'rank_name' => 'Cadet Sophomore Grade',
		'rank_short_name' => 'CDT(SO)',
		'rank_image' => 'c2',
		'rank_order' => 23,
		'rank_display' => 'n',
		'rank_class' => 2),
	array(
		'rank_name' => 'Cadet Sophomore Grade',
		'rank_short_name' => 'CDT(SO)',
		'rank_image' => 'c2',
		'rank_order' => 23,
		'rank_display' => 'n',
		'rank_class' => 3),
	array(
		'rank_name' => 'Cadet Sophomore Grade',
		'rank_short_name' => 'CDT(SO)',
		'rank_image' => 'c2',
		'rank_order' => 23,
		'rank_display' => 'n',
		'rank_class' => 4),
	array(
		'rank_name' => 'Cadet Sophomore Grade',
		'rank_short_name' => 'CDT(SO)',
		'rank_image' => 'c2',
		'rank_order' => 23,
		'rank_display' => 'n',
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Cadet Freshman Grade',
		'rank_short_name' => 'CDT(FR)',
		'rank_image' => 'c1',
		'rank_order' => 24,
		'rank_display' => 'n',
		'rank_class' => 1),
	array(
		'rank_name' => 'Cadet Freshman Grade',
		'rank_short_name' => 'CDT(FR)',
		'rank_image' => 'c1',
		'rank_order' => 24,
		'rank_display' => 'n',
		'rank_class' => 2),
	array(
		'rank_name' => 'Cadet Freshman Grade',
		'rank_short_name' => 'CDT(FR)',
		'rank_image' => 'c1',
		'rank_order' => 24,
		'rank_display' => 'n',
		'rank_class' => 3),
	array(
		'rank_name' => 'Cadet Freshman Grade',
		'rank_short_name' => 'CDT(FR)',
		'rank_image' => 'c1',
		'rank_order' => 24,
		'rank_display' => 'n',
		'rank_class' => 4),
	array(
		'rank_name' => 'Cadet Freshman Grade',
		'rank_short_name' => 'CDT(FR)',
		'rank_image' => 'c1',
		'rank_order' => 24,
		'rank_display' => 'n',
		'rank_class' => 5),
		
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'y-blank',
		'rank_order' => 25,
		'rank_class' => 1),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'r-blank',
		'rank_order' => 25,
		'rank_class' => 2),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 't-blank',
		'rank_order' => 25,
		'rank_class' => 3),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'maco-blank',
		'rank_order' => 25,
		'rank_class' => 4),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'g-blank',
		'rank_order' => 25,
		'rank_class' => 5),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'v-blank',
		'rank_order' => 8,
		'rank_class' => 6)
);

$positions = array(
	array(
		'pos_name' => 'Commanding Officer',
		'pos_desc' => "Ultimately responsible for the ship and crew, the Commanding Officer is the most senior officer aboard a vessel. S/he is responsible for carrying out the orders of Starfleet, and for representing both Starfleet and the Federation.",
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
		'pos_desc' => "The senior-most Chief Petty Officer (including Senior and Master Chiefs), regardless of rating, is designated by the Commanding Officer as the Chief of the Boat (for vessels) or Command Chief (for starbases). In addition to his or her departmental responsibilities, the COB/CC performs the following duties: serves as a liaison between the Commanding Officer (or Executive Officer) and the enlisted crewmen; ensures enlisted crews understand Command policies; advises the Commanding Officer and Executive Officer regarding enlisted morale, and evaluates the quality of noncommissioned officer leadership, management, and supervisory training.\r\n\r\nThe COB/CC works with the other department heads, Chiefs, supervisors, and crewmen to insure discipline is equitably maintained, and the welfare, morale, and health needs of the enlisted personnel are met. The COB/CC is qualified to temporarily act as Commanding or Executive Officer if so ordered.",
		'pos_dept' => 1,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Chief Helm Officer',
		'pos_desc' => "Helm incorporates two job, Navigation and flight control. A Helm Officer must always be present on the bridge of a starship. S/he plots courses, supervises the computers piloting, corrects any flight deviations and pilots the ship manually when needed. The Chief Helm Officer is the senior most Helm Officer aboard, serving as a Senior Officer, and chief of the personnel under him/her.",
		'pos_dept' => 2,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Helm Officer',
		'pos_desc' => "Helm incorporates two job, Navigation and flight control. A Helm Officer must always be present on the bridge of a starship, and every vessel has a number of Helm Officers to allow shift rotations. S/he plots courses, supervises the computers piloting, corrects any flight deviations and pilots the ship manually when needed. Helm Officers report to the Chief Helm Officer.",
		'pos_dept' => 2,
		'pos_order' => 1,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Chief Armory Officer',
		'pos_desc' => "Her/his duty is to ensure the safety of ship and crew. Some take it as their personal duty to protect the Commanding Officer/Executive Officer on away teams. She/he is also responsible for people under arrest and the safety of guests, liked or not. S/he also is a department head and a member of the senior staff, responsible for all the crew members in her/his department and duty rosters.",
		'pos_dept' => 3,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Armory Officer',
		'pos_desc' => "There are several Armory Officers aboard each vessel. They are assigned to their duties by the Armory Chief and mostly guard sensitive areas, protect people, patrol, and handle other threats to the Federation.",
		'pos_dept' => 3,
		'pos_order' => 1,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Security Investigations Officer',
		'pos_desc' => "The Security Investigations Officer is an Enlisted Officer. S/He fulfills the role of a special investigator or detective when dealing with Starfleet matters aboard ship or on a planet. Coordinates with the Chief Armory Officer on all investigations as needed. The Security Investigations Officer reports to the Chief Armory Officer.",
		'pos_dept' => 3,
		'pos_order' => 5,
		'pos_open' => 2,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Brig Officer',
		'pos_desc' => "The Brig Officer is an Armory Officer who has chosen to specialize in a specific role. S/he guards the brig and its cells. But there are other duties associated with this post as well. S/he is responsible for any prisoner transport, and the questioning of prisoners.",
		'pos_dept' => 3,
		'pos_order' => 10,
		'pos_open' => 5,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Master-at-Arms',
		'pos_desc' => "The Master-at-Arms trains and supervises Armory crewmen in departmental operations, repairs, and protocols; maintains duty assignments for all Armory personnel; supervises weapons locker access and firearm deployment; and is qualified to temporarily act as Chief Armory Officer if so ordered. The Master-at-Arms reports to the Chief Armory Officer.",
		'pos_dept' => 3,
		'pos_order' => 15,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Chief Engineer',
		'pos_desc' => "The Chief Engineer is responsible for the condition of all systems and equipment on board a Starfleet ship or facility. S/he oversees maintenance, repairs and upgrades of all equipment. S/he is also responsible for the many repairs teams during crisis situations.\r\n\r\nThe Chief Engineer is not only the department head but also a senior officer, responsible for all the crew members in her/his department and maintenance of the duty rosters.",
		'pos_dept' => 4,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Assistant Chief Engineer',
		'pos_desc' => "The Assistant Chief Engineer assists the Chief Engineer in the daily work; in issues regarding mechanical, administrative matters and co-ordinating repairs with other departments.\r\n\r\nIf so required, the Assistant Chief Engineer must be able to take over as Chief Engineer, and thus must be versed in current information regarding the ship or facility.",
		'pos_dept' => 4,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Engineer',
		'pos_desc' => "There are several non-specialized engineers aboard of each vessel. They are assigned to their duties by the Chief Engineer and his Assistant, performing a number of different tasks as required, i.e. general maintenance and repair. Generally, engineers as assigned to more specialized engineering person to assist in there work is so requested by the specialized engineer.",
		'pos_dept' => 4,
		'pos_order' => 5,
		'pos_open' => 10,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Damage Control Specialist',
		'pos_desc' => "The Damage Control Specialist is a specialized Engineer. The Damage Control Specialist controls all damage control aboard the ship when it gets damaged in battle. S/he oversees all damage repair aboard the ship, and coordinates repair teams on the smaller jobs so the Chief Engineer can worry about other matters.\r\n\r\nA small team is assigned to the Damage Control Specialist which is made up from NCO personnel assigned by the Assistant and Chief Engineer. The Damage Control Specialist reports to the Assistant and Chief Engineer.",
		'pos_dept' => 4,
		'pos_order' => 10,
		'pos_open' => 5,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Chief Science Officer',
		'pos_desc' => "The Chief Science Officer is responsible for all the scientific data the ship/facility collects, and the distribution of such data to specific section within the department for analysis. S/he is also responsible with providing the ship's captain with scientific information needed for command decisions.\r\n\r\nS/he also is a department head and a member of the Senior Staff and responsible for all the crew members in her/his department and duty rosters.",
		'pos_dept' => 5,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Science Officer',
		'pos_desc' => "There are several general Science Officers aboard each vessel. They are assigned to their duties by the Chief Science Officer and his Assistant. Assignments include work for the Specialized Section heads, as well as duties for work being carried out by the Chief.",
		'pos_dept' => 5,
		'pos_order' => 5,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Chief Medical Officer',
		'pos_desc' => "The Chief Medical Officer is responsible for the physical health of the entire crew, but does more than patch up injured crew members. His/her function is to ensure that they do not get sick or injured to begin with, and to this end monitors their health and conditioning with regular check ups. If necessary, the Chief Medical Officer can remove anyone from duty, even a Commanding Officer. Besides this s/he is available to provide medical advice to any individual who requests it.",
		'pos_dept' => 6,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Counselor',
		'pos_desc' => "Because of their training in psychology, technically the ship's/facility's Counselor is considered part of Starfleet Medical. The Counselor is responsible both for advising the Commanding Officer in dealing with other people and races, and in helping crew members with personal, psychological, and emotional problems.\r\n\r\nThe Counselor reports to the Chief Medical Officer.",
		'pos_dept' => 6,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Medical Officer',
		'pos_desc' => "Medical Officer undertake the majority of the work aboard the ship/facility, examining the crew, and administering medical care under the instruction of the Chief Medical Officer.",
		'pos_dept' => 6,
		'pos_order' => 5,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Nurse',
		'pos_desc' => "Nurses are trained in basic medical care, and are capable of dealing with less serious medical cases. In more serious matters the nurse assist the medical officer in the examination and administration of medical care, be this injecting required drugs, or simply assuring the injured party that they will be ok. The Nurses also maintain the medical wards, overseeing the patients and ensuring they are receiving medication and care as instructed by the Medical Officer.",
		'pos_dept' => 6,
		'pos_order' => 10,
		'pos_open' => 10,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Chief Communications Officer',
		'pos_desc' => "Responsible for maintaining and upgrading the universal translator, controls the intercom and responsible for coordinating communications with other ships, stations or colonies/planets.",
		'pos_dept' => 7,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Communications Officer',
		'pos_desc' => "The Communications officer is responsible for managing all incoming and outgoing transmissions. This role involves the study of new and old languages and text in an attempt to better understand and interpret their meaning.",
		'pos_dept' => 7,
		'pos_order' => 5,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'MACO Commanding Officer',
		'pos_desc' => "The MACO Commanding Officer is responsible for all the MACO personnel assigned to the ship/facility. S/he is in required to take command of any special ground operations and lease such actions with security. The MACOs could be called the 23rd century commandos.\r\n\r\nThe CO can range from a Second Lieutenant on a small ship to a Lieutenant Colonel on a large facility or colony. Charged with the training, condition and tactical leadership of the MACO compliment, they are a member of the senior staff.\r\n\r\nAnswers to the Commanding Officer of the ship/facility.",
		'pos_dept' => 8,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'MACO Executive Officer',
		'pos_desc' => "The Executive Officer of the MACOs, works like any Asst. Department head, removing some of the work load from the MACO CO and if the need arises taking on the role of MACO CO. S/he oversees the regular duties of the MACOs, from regular drills to equipment training, assignment and supply request to the ship/facilities Materials Officer.\r\n\r\nAnswers to the MACO Commanding Officer.",
		'pos_dept' => 8,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'First Sergeant',
		'pos_desc' => "The First Sergeant is the highest ranked Enlisted MACO. S/He is in charge of all of the MACO enlisted affairs in the detachment. They assist the Company or Detachment Commander as their Executive Officer would. They act as a bridge, closing the gap between the NCO\'s and the Officers.\r\n\r\nAnswers To MACO Commanding Officer.",
		'pos_dept' => 8,
		'pos_order' => 5,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'MACO',
		'pos_desc' => "Serving within a squad, the MACO is trained in a variety of means of combat, from melee to ranged projectile to sniping.",
		'pos_dept' => 8,
		'pos_order' => 10,
		'pos_open' => 10,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Chef',
		'pos_desc' => "Responsible for preparing all meals served in the Mess Hall and for the food during any diplomatic functions that may be held onboard.",
		'pos_dept' => 9,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'enlisted')
);

$catalogue_ranks = array(
	array(
		'rankcat_name' => 'Duty Uniform',
		'rankcat_location' => 'default',
		'rankcat_credits' => "The rank sets used in Nova were created by Kuro-chan of Kuro-RPG. The ranksets can be found at <a href='http://www.kuro-rpg.net' target='_blank''>Kuro-RPG</a>. Please do not copy or modify the images.",
		'rankcat_default' => 'y',
		'rankcat_genre' => $g)
);
