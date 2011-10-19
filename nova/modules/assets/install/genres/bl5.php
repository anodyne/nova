<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Install Genre - BL5
 *
 * @package		Nova
 * @category	Genre
 * @author		Rycon (Anodyne forums)
 */
 
$g = 'bl5';

$data = array(
	'departments_'. $g 	=> 'depts',
	'ranks_'. $g		=> 'ranks',
	'positions_'. $g	=> 'positions',
	'catalogue_ranks'	=> 'catalogue_ranks',
);

$depts = array(
	array(
		'dept_name' => 'Command',
		'dept_desc' => "The Command department is ultimately responsible for the ship and its crew, and those within the department are responsible for commanding the vessel.",
		'dept_order' => 0,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Pilots',
		'dept_desc' => "The best pilots anywhere, they are responsible for piloting the StarFury fighters in ship-to-ship battles, as well as providing escort.",
		'dept_order' => 1,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Security',
		'dept_desc' => "The security department is ultimately responsible for the security of the ship and being prepared for anything to happen.",
		'dept_order' => 2,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Engineering',
		'dept_desc' => "The engineering department has the enormous task of keeping the ship working; they are responsible for making repairs, fixing problems, and making sure that the ship is ready for anything.",
		'dept_order' => 3,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Medical',
		'dept_desc' => "The medical department is responsible for the mental and physical health of the crew, from running annual physicals to combatting a strange plague that is afflicting the crew to helping a crew member deal with the loss of a loved one.",
		'dept_order' => 4,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Communications',
		'dept_desc' => "The Communications department is responsible for the operation of the communications systems to ensure timely and accurate communications both within and outside the vessel.",
		'dept_order' => 5,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Marines',
		'dept_desc' => "When the standard security detail is not enough, marines come in and clean up; the marine detachment is a powerful tactical addition to any ship, responsible for partaking in personal combat, from sniping to melee.",
		'dept_order' => 6,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Weapons Control',
		'dept_desc' => "The Weapons Control department is responsible for controlling both small and large arms aboard the vessel, be that personal sidearms, the armaments of the StarFury fighters and even the vessel itself.",
		'dept_order' => 7,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Tactical',
		'dept_desc' => "The Tactiacl department is responsible for the tactical readiness of the vessel and manning the weapon system during combat as well as coordinating StarFury craft as they engage in ship-to-ship combat.",
		'dept_order' => 8,
		'dept_manifest' => 1)
);

$ranks= array(
	array(
		'rank_name' => 'Commander-in-Chief',
		'rank_short_name' => 'CIC',
		'rank_image' => 'b-a5',
		'rank_order' => 0,
		'rank_class' => 1),
	array(
		'rank_name' => 'Commander-in-Chief',
		'rank_short_name' => 'CIC',
		'rank_image' => 's-a5',
		'rank_order' => 0,
		'rank_class' => 2),
	array(
		'rank_name' => 'Commander-in-Chief',
		'rank_short_name' => 'CIC',
		'rank_image' => 'm-a5',
		'rank_order' => 0,
		'rank_class' => 3),
	array(
		'rank_name' => 'Commander-in-Chief',
		'rank_short_name' => 'CIC',
		'rank_image' => 'd-a5',
		'rank_order' => 0,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'General',
		'rank_short_name' => 'GEN',
		'rank_image' => 'b-a4',
		'rank_order' => 1,
		'rank_class' => 1),
	array(
		'rank_name' => 'General',
		'rank_short_name' => 'GEN',
		'rank_image' => 's-a4',
		'rank_order' => 1,
		'rank_class' => 2),
	array(
		'rank_name' => 'General',
		'rank_short_name' => 'GEN',
		'rank_image' => 'm-a4',
		'rank_order' => 1,
		'rank_class' => 3),
	array(
		'rank_name' => 'General',
		'rank_short_name' => 'GEN',
		'rank_image' => 'd-a4',
		'rank_order' => 1,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Lieutenant General',
		'rank_short_name' => 'LT GEN',
		'rank_image' => 'b-a3',
		'rank_order' => 2,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant General',
		'rank_short_name' => 'LT GEN',
		'rank_image' => 's-a3',
		'rank_order' => 2,
		'rank_class' => 2),
	array(
		'rank_name' => 'Lieutenant General',
		'rank_short_name' => 'LT GEN',
		'rank_image' => 'm-a3',
		'rank_order' => 2,
		'rank_class' => 3),
	array(
		'rank_name' => 'Lieutenant General',
		'rank_short_name' => 'LT GEN',
		'rank_image' => 'd-a3',
		'rank_order' => 2,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Major General',
		'rank_short_name' => 'MAJ GEN',
		'rank_image' => 'b-a2',
		'rank_order' => 3,
		'rank_class' => 1),
	array(
		'rank_name' => 'Major General',
		'rank_short_name' => 'MAJ GEN',
		'rank_image' => 's-a2',
		'rank_order' => 3,
		'rank_class' => 2),
	array(
		'rank_name' => 'Major General',
		'rank_short_name' => 'MAJ GEN',
		'rank_image' => 'm-a2',
		'rank_order' => 3,
		'rank_class' => 3),
	array(
		'rank_name' => 'Major General',
		'rank_short_name' => 'MAJ GEN',
		'rank_image' => 'd-a2',
		'rank_order' => 3,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Brigadier General',
		'rank_short_name' => 'BRG GEN',
		'rank_image' => 'b-a1',
		'rank_order' => 4,
		'rank_class' => 1),
	array(
		'rank_name' => 'Brigadier General',
		'rank_short_name' => 'BRG GEN',
		'rank_image' => 's-a1',
		'rank_order' => 4,
		'rank_class' => 2),
	array(
		'rank_name' => 'Brigadier General',
		'rank_short_name' => 'BRG GEN',
		'rank_image' => 'm-a1',
		'rank_order' => 4,
		'rank_class' => 3),
	array(
		'rank_name' => 'Brigadier General',
		'rank_short_name' => 'BRG GEN',
		'rank_image' => 'd-a1',
		'rank_order' => 4,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'b-o6',
		'rank_order' => 5,
		'rank_class' => 1),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 's-o6',
		'rank_order' => 5,
		'rank_class' => 2),
	array(
		'rank_name' => 'Colonel',
		'rank_short_name' => 'COL',
		'rank_image' => 'm-o6',
		'rank_order' => 5,
		'rank_class' => 3),
	array(
		'rank_name' => 'Colonel',
		'rank_short_name' => 'COL',
		'rank_image' => 'd-o6',
		'rank_order' => 5,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Commander',
		'rank_short_name' => 'CMDR',
		'rank_image' => 'b-o5',
		'rank_order' => 6,
		'rank_class' => 1),
	array(
		'rank_name' => 'Commander',
		'rank_short_name' => 'CMDR',
		'rank_image' => 's-o5',
		'rank_order' => 6,
		'rank_class' => 2),
	array(
		'rank_name' => 'Lieutenant Colonel',
		'rank_short_name' => 'LT COL',
		'rank_image' => 'm-o5',
		'rank_order' => 6,
		'rank_class' => 3),
	array(
		'rank_name' => 'Lieutenant Colonel',
		'rank_short_name' => 'LT COL',
		'rank_image' => 'd-o5',
		'rank_order' => 6,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Lieutenant Commander',
		'rank_short_name' => 'LT CMDR',
		'rank_image' => 'b-o4',
		'rank_order' => 7,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant Commander',
		'rank_short_name' => 'LT CMDR',
		'rank_image' => 's-o4',
		'rank_order' => 7,
		'rank_class' => 2),
	array(
		'rank_name' => 'Major',
		'rank_short_name' => 'MAJ',
		'rank_image' => 'm-o4',
		'rank_order' => 7,
		'rank_class' => 3),
	array(
		'rank_name' => 'Major',
		'rank_short_name' => 'MAJ',
		'rank_image' => 'd-o4',
		'rank_order' => 7,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Lieutenant',
		'rank_short_name' => 'LT',
		'rank_image' => 'b-o3',
		'rank_order' => 8,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant',
		'rank_short_name' => 'LT',
		'rank_image' => 's-o3',
		'rank_order' => 8,
		'rank_class' => 2),
	array(
		'rank_name' => 'Marine Captain',
		'rank_short_name' => 'MCAPT',
		'rank_image' => 'm-o3',
		'rank_order' => 8,
		'rank_class' => 3),
	array(
		'rank_name' => 'Marine Captain',
		'rank_short_name' => 'MCAPT',
		'rank_image' => 'd-o3',
		'rank_order' => 8,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Lieutenant JG',
		'rank_short_name' => 'LT(JG)',
		'rank_image' => 'b-o2',
		'rank_order' => 9,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant JG',
		'rank_short_name' => 'LT(JG)',
		'rank_image' => 's-o2',
		'rank_order' => 9,
		'rank_class' => 2),
	array(
		'rank_name' => '1st Lieutenant',
		'rank_short_name' => '1LT',
		'rank_image' => 'm-o2',
		'rank_order' => 9,
		'rank_class' => 3),
	array(
		'rank_name' => '1st Lieutenant',
		'rank_short_name' => '1LT',
		'rank_image' => 'd-o2',
		'rank_order' => 9,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Ensign',
		'rank_short_name' => 'ENS',
		'rank_image' => 'b-o1',
		'rank_order' => 10,
		'rank_class' => 1),
	array(
		'rank_name' => 'Ensign',
		'rank_short_name' => 'ENS',
		'rank_image' => 's-o1',
		'rank_order' => 10,
		'rank_class' => 2),
	array(
		'rank_name' => '2nd Lieutenant',
		'rank_short_name' => '2LT',
		'rank_image' => 'm-o1',
		'rank_order' => 10,
		'rank_class' => 3),
	array(
		'rank_name' => '2nd Lieutenant',
		'rank_short_name' => '2LT',
		'rank_image' => 'd-o1',
		'rank_order' => 10,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Chief Warrant Officer 1st Class',
		'rank_short_name' => 'CWO1',
		'rank_image' => 'b-w4',
		'rank_order' => 11,
		'rank_class' => 1),
	array(
		'rank_name' => 'Chief Warrant Officer 1st Class',
		'rank_short_name' => 'CWO1',
		'rank_image' => 's-w4',
		'rank_order' => 11,
		'rank_class' => 2),
	array(
		'rank_name' => 'Chief Warrant Officer 1st Class',
		'rank_short_name' => 'CWO1',
		'rank_image' => 'm-w4',
		'rank_order' => 11,
		'rank_class' => 3),
	array(
		'rank_name' => 'Chief Warrant Officer 1st Class',
		'rank_short_name' => 'CWO1',
		'rank_image' => 'd-w4',
		'rank_order' => 11,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Chief Warrant Officer 2nd Class',
		'rank_short_name' => 'CWO2',
		'rank_image' => 'b-w3',
		'rank_order' => 12,
		'rank_class' => 1),
	array(
		'rank_name' => 'Chief Warrant Officer 2nd Class',
		'rank_short_name' => 'CWO2',
		'rank_image' => 's-w3',
		'rank_order' => 12,
		'rank_class' => 2),
	array(
		'rank_name' => 'Chief Warrant Officer 2nd Class',
		'rank_short_name' => 'CWO2',
		'rank_image' => 'm-w3',
		'rank_order' => 12,
		'rank_class' => 3),
	array(
		'rank_name' => 'Chief Warrant Officer 2nd Class',
		'rank_short_name' => 'CWO2',
		'rank_image' => 'd-w3',
		'rank_order' => 12,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Chief Warrant Officer 3rd Class',
		'rank_short_name' => 'CWO3',
		'rank_image' => 'b-w2',
		'rank_order' => 13,
		'rank_class' => 1),
	array(
		'rank_name' => 'Chief Warrant Officer 3rd Class',
		'rank_short_name' => 'CWO3',
		'rank_image' => 's-w2',
		'rank_order' => 13,
		'rank_class' => 2),
	array(
		'rank_name' => 'Chief Warrant Officer 3rd Class',
		'rank_short_name' => 'CWO3',
		'rank_image' => 'm-w2',
		'rank_order' => 13,
		'rank_class' => 3),
	array(
		'rank_name' => 'Chief Warrant Officer 3rd Class',
		'rank_short_name' => 'CWO3',
		'rank_image' => 'd-w2',
		'rank_order' => 13,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Master Chief Petty Officer',
		'rank_short_name' => 'MCPO',
		'rank_image' => 'b-e9',
		'rank_order' => 14,
		'rank_class' => 1),
	array(
		'rank_name' => 'Master Chief Petty Officer',
		'rank_short_name' => 'MCPO',
		'rank_image' => 's-e9',
		'rank_order' => 14,
		'rank_class' => 2),
	array(
		'rank_name' => 'Sergeant Major',
		'rank_short_name' => 'SGTM',
		'rank_image' => 'm-e9',
		'rank_order' => 14,
		'rank_class' => 3),
	array(
		'rank_name' => 'Sergeant Major',
		'rank_short_name' => 'SGTM',
		'rank_image' => 'd-e9',
		'rank_order' => 14,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Senior Chief Petty Officer',
		'rank_short_name' => 'SCPO',
		'rank_image' => 'b-e8',
		'rank_order' => 15,
		'rank_class' => 1),
	array(
		'rank_name' => 'Senior Chief Petty Officer',
		'rank_short_name' => 'SCPO',
		'rank_image' => 's-e8',
		'rank_order' => 15,
		'rank_class' => 2),
	array(
		'rank_name' => 'Master Sergeant',
		'rank_short_name' => 'MSGT',
		'rank_image' => 'm-e8',
		'rank_order' => 15,
		'rank_class' => 3),
	array(
		'rank_name' => 'Master Sergeant',
		'rank_short_name' => 'MSGT',
		'rank_image' => 'd-e8',
		'rank_order' => 15,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Chief Petty Officer',
		'rank_short_name' => 'CPO',
		'rank_image' => 'b-e7',
		'rank_order' => 16,
		'rank_class' => 1),
	array(
		'rank_name' => 'Chief Petty Officer',
		'rank_short_name' => 'CPO',
		'rank_image' => 's-e7',
		'rank_order' => 16,
		'rank_class' => 2),
	array(
		'rank_name' => 'Sergeant 1st Class',
		'rank_short_name' => 'SGT1',
		'rank_image' => 'm-e7',
		'rank_order' => 16,
		'rank_class' => 3),
	array(
		'rank_name' => 'Sergeant 1st Class',
		'rank_short_name' => 'SGT1',
		'rank_image' => 'd-e7',
		'rank_order' => 16,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Petty Officer 1st Class',
		'rank_short_name' => 'PO1',
		'rank_image' => 'b-e6',
		'rank_order' => 17,
		'rank_class' => 1),
	array(
		'rank_name' => 'Petty Officer 1st Class',
		'rank_short_name' => 'PO1',
		'rank_image' => 's-e6',
		'rank_order' => 17,
		'rank_class' => 2),
	array(
		'rank_name' => 'Staff Sergeant',
		'rank_short_name' => 'SSGT',
		'rank_image' => 'm-e6',
		'rank_order' => 17,
		'rank_class' => 3),
	array(
		'rank_name' => 'Staff Sergeant',
		'rank_short_name' => 'SSGT',
		'rank_image' => 'd-e6',
		'rank_order' => 17,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Petty Officer 2nd Class',
		'rank_short_name' => 'PO2',
		'rank_image' => 'b-e5',
		'rank_order' => 18,
		'rank_class' => 1),
	array(
		'rank_name' => 'Petty Officer 2nd Class',
		'rank_short_name' => 'PO2',
		'rank_image' => 's-e5',
		'rank_order' => 18,
		'rank_class' => 2),
	array(
		'rank_name' => 'Sergeant',
		'rank_short_name' => 'SGT',
		'rank_image' => 'm-e5',
		'rank_order' => 18,
		'rank_class' => 3),
	array(
		'rank_name' => 'Sergeant',
		'rank_short_name' => 'SGT',
		'rank_image' => 'd-e5',
		'rank_order' => 18,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Petty Officer 3rd Class',
		'rank_short_name' => 'PO3',
		'rank_image' => 'b-e4',
		'rank_order' => 19,
		'rank_class' => 1),
	array(
		'rank_name' => 'Petty Officer 3rd Class',
		'rank_short_name' => 'PO3',
		'rank_image' => 's-e4',
		'rank_order' => 19,
		'rank_class' => 2),
	array(
		'rank_name' => 'Corporal',
		'rank_short_name' => 'CPL',
		'rank_image' => 'm-e4',
		'rank_order' => 19,
		'rank_class' => 3),
	array(
		'rank_name' => 'Corporal',
		'rank_short_name' => 'CPL',
		'rank_image' => 'd-e4',
		'rank_order' => 19,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Crewman',
		'rank_short_name' => 'CR',
		'rank_image' => 'b-e3',
		'rank_order' => 20,
		'rank_class' => 1),
	array(
		'rank_name' => 'Crewman',
		'rank_short_name' => 'CR',
		'rank_image' => 's-e3',
		'rank_order' => 20,
		'rank_class' => 2),
	array(
		'rank_name' => 'Private 1st Class',
		'rank_short_name' => 'PVT1',
		'rank_image' => 'm-e3',
		'rank_order' => 20,
		'rank_class' => 3),
	array(
		'rank_name' => 'Private 1st Class',
		'rank_short_name' => 'PVT1',
		'rank_image' => 'd-e3',
		'rank_order' => 20,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Crewman Apprentice',
		'rank_short_name' => 'CRA',
		'rank_image' => 'b-e2',
		'rank_order' => 21,
		'rank_class' => 1),
	array(
		'rank_name' => 'Crewman Apprentice',
		'rank_short_name' => 'CRA',
		'rank_image' => 's-e2',
		'rank_order' => 21,
		'rank_class' => 2),
	array(
		'rank_name' => 'Private E-2',
		'rank_short_name' => 'PVT(E2)',
		'rank_image' => 'm-e2',
		'rank_order' => 21,
		'rank_class' => 3),
	array(
		'rank_name' => 'Private E-2',
		'rank_short_name' => 'PVT(E2)',
		'rank_image' => 'd-e2',
		'rank_order' => 21,
		'rank_class' => 4),
		
	array(
		'rank_name' => 'Crewman Recruit',
		'rank_short_name' => 'CRR',
		'rank_image' => 'b-e1',
		'rank_order' => 22,
		'rank_class' => 1),
	array(
		'rank_name' => 'Crewman Recruit',
		'rank_short_name' => 'CRR',
		'rank_image' => 's-e1',
		'rank_order' => 22,
		'rank_class' => 2),
	array(
		'rank_name' => 'Private E-1',
		'rank_short_name' => 'PVT(E1)',
		'rank_image' => 'm-e1',
		'rank_order' => 22,
		'rank_class' => 3),
	array(
		'rank_name' => 'Private E-1',
		'rank_short_name' => 'PVT(E1)',
		'rank_image' => 'd-e1',
		'rank_order' => 22,
		'rank_class' => 4),
		
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'b-blank',
		'rank_order' => 23,
		'rank_class' => 1),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 's-blank',
		'rank_order' => 23,
		'rank_class' => 2),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'm-blank',
		'rank_order' => 23,
		'rank_class' => 3),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'd-blank',
		'rank_order' => 23,
		'rank_class' => 4),
);

$positions = array(
	array(
		'pos_name' => "Commanding Officer",
		'pos_desc' => "Ultimately responsible for the ship and crew, the Commanding Officer is the most senior officer aboard a vessel. S/he is responsible for carrying out the orders of EarthForce, and for representing both Earthforce & Earth Alliance.",
		'pos_dept' => 1,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => "Executive Officer",
		'pos_desc' => "The liaison between captain and crew, the Executive Officer acts as the disciplinarian, personnel manager, advisor to the captain, and much more. S/he is also one of only two officers, along with the Chief Medical Officer, that can remove a Commanding Officer from duty.",
		'pos_dept' => 1,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'senior'),
		
	array(
		'pos_name' => "Commander, Air Group",
		'pos_desc' => "The Air Group Commander oversees the day-to-day operations of the Starfury pilots, assigning them their flight duties as well as handling all training.",
		'pos_dept' => 2,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => "Squadron Leader",
		'pos_desc' => "A StarFury Squadron Leader is the second most senior officer below the CAG. Generally speaking, his duites are the same as the CAG, however, he also leads a squadron during missions.",
		'pos_dept' => 2,
		'pos_order' => 1,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => "StarFury Pilot",
		'pos_desc' => "A pilot in the StarFury squadron.",
		'pos_dept' => 2,
		'pos_order' => 2,
		'pos_open' => 20,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => "Chief of Security",
		'pos_desc' => "The Chief Security Officer is called Chief of Security. Her/his duty is to ensure the safety of ship and crew. She/he is also responsible for people under arrest and the safety of guests, liked or not. S/he also is a department head and a member of the senior staff, responsible for all the crew members in her/his department and duty rosters.",
		'pos_dept' => 3,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => "Assistant Chief of Security",
		'pos_desc' => "The Assistant Chief Security Officer is sometimes called Deputy of Security. S/he assists the Chief of Security in the daily work; in issues regarding Security and any administrative matters. If required the Deputy must be able to take command of the Security department.",
		'pos_dept' => 3,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => "Security Officer",
		'pos_desc' => "There are several Security Officers aboard each vessel. They are assigned to their duties by the Chief of Security and his/her Deputy and mostly guard sensitive areas, protect people, patrol, and handle other threats to the Ship & or station.",
		'pos_dept' => 3,
		'pos_order' => 2,
		'pos_open' => 5,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => "Chief of Engineering",
		'pos_desc' => "The Chief Engineer is responsible for the condition of all systems and equipment on board a Earth Force ship or facility. S/he oversees maintenance, repairs and upgrades of all equipment. S/he is also responsible for the many repairs teams during crisis situations.\r\n\r\nThe Chief Engineer is not only the department head but also a senior officer, responsible for all the crew members in her/his department and maintenance of the duty rosters.",
		'pos_dept' => 4,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => "Engineering Officer",
		'pos_desc' => "There are several non-specialized engineers aboard of each vessel. They are assigned to their duties by the Chief Engineer and his Assistant, performing a number of different tasks as required, i.e. general maintenance and repair. Generally, engineers as assigned to more specialized engineering person to assist in there work is so requested by the specialized engineer.",
		'pos_dept' => 4,
		'pos_order' => 1,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => "Damage Control Officer",
		'pos_desc' => "The Damage Control Specialist is a specialized Engineer. The Damage Control Specialist controls all damage control aboard the ship when it gets damaged in battle. S/he oversees all damage repair aboard the ship, and coordinates repair teams on the smaller jobs so the Chief Engineer can worry about other matters.\r\n\r\nA small team is assigned to the Damage Control Specialist which is made up from NCO personnel assigned by the Chief Engineer. The Damage Control Specialist reports to the Chief Engineer.",
		'pos_dept' => 4,
		'pos_order' => 2,
		'pos_open' => 5,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => "Chief Medical Officer",
		'pos_desc' => "The Chief Medical Officer is responsible for the physical health of the entire crew, but does more than patch up injured crew members. His/her function is to ensure that they do not get sick or injured to begin with, and to this end monitors their health and conditioning with regular check ups. If necessary, the Chief Medical Officer can remove anyone from duty, even a Commanding Officer. Besides this s/he is available to provide medical advice to any individual who requests it.\r\n\r\nAdditionally the Chief is also responsible for all aspect of the medical deck, such as the Medical labs, Surgical suites and Dentistry labs.\r\n\r\nS/he also is a department head and a member of the Senior Staff and responsible for all the crew members in her/his department and duty rosters.",
		'pos_dept' => 5,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => "Assistant Chief Medical Officer",
		'pos_desc' => "A ship or facility has numerous personnel aboard, and thus the Chief Medical Officer cannot be expect to do all the work required. The Asst. Chief Medical Officer assists Chief in all areas, such as administration, and application of medical care.",
		'pos_dept' => 5,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => "Medical Officer",
		'pos_desc' => "Medical Officer undertake the majority of the work aboard the ship/facility, examining the crew, and administering medical care under the instruction of the Chief Medical Officer and Assistant Chief Medical Officer also run the other Medical areas not directly overseen by the Chief Medical Officer.",
		'pos_dept' => 5,
		'pos_order' => 2,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => "Medic",
		'pos_desc' => "Medics undertake the majority of the work aboard the ship/facility, examining the crew, and administering medical care under the instruction of the Chief Medical Officer as well as running the other Medical areas not directly overseen by the Chief Medical Officer.",
		'pos_dept' => 5,
		'pos_order' => 3,
		'pos_open' => 5,
		'pos_type' => 'enlisted'),
		
	array(
		'pos_name' => "Chief Communications Officer",
		'pos_desc' => "The Chief Communications Officer oversees all of the communications arrays and equpment onbaord the ship/station maing sure everything is in working order.",
		'pos_dept' => 6,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => "Communications Officer",
		'pos_desc' => "Communications Officers work under the direction of the Chief Communication Officer and are responsible for keeping in contact with all ships and stations.",
		'pos_dept' => 6,
		'pos_order' => 1,
		'pos_open' => 3,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => "Marine Commander",
		'pos_desc' => "The Marine CO is responsible for all the Marine personnel assigned to the ship/facility. S/he is in required to take command of any special ground operations and lease such actions with security. The CO can range from a Second Lieutenant on a small ship to a Lieutenant Colonel on a large facility or colony. Charged with the training, condition and tactical leadership of the Marine compliment, they are a member of the senior staff.\r\n\r\nAnswers to the Commanding Officer of the ship/facility.",
		'pos_dept' => 7,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => "Marine Deputy Commander",
		'pos_desc' => "The Executive Officer of the Marines, works like any Asst. Department head, removing some of the work load from the Marine CO and if the need arises taking on the role of Marine CO. S/he oversees the regular duties of the Marines, from regular drills to equipment training, assignment and supply request to the ship/facilities Materials Officer.\r\n\r\nAnswers to the Marine Commanding Officer.",
		'pos_dept' => 7,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => "Marine Sergeant",
		'pos_desc' => "The First Sergeant is the highest ranked Enlisted marine. S/He is in charge of all of the marine enlisted affairs in the detachment. They assist the Company or Detachment Commander as their Executive Officer would. They act as a bridge, closing the gap between the NCOs and the Officers.\r\n\r\nAnswers To Marine Commanding Officer.",
		'pos_dept' => 7,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => "Marine",
		'pos_desc' => "Serving within a squad, the marine is trained in a variety of means of combat, from melee to ranged projectile to sniping.",
		'pos_dept' => 7,
		'pos_order' => 3,
		'pos_open' => 10,
		'pos_type' => 'enlisted'),
		
	array(
		'pos_name' => "Chief Weapons Control Officer",
		'pos_desc' => "The Chief Weapons Control Officer oversees all of the weapons onboard the ship/facility making sure all weapons are in useable condition.",
		'pos_dept' => 8,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => "Weapons Control Officer",
		'pos_desc' => "The Weapons Control Officers oversee the weapons platform and are responsible for firing of the weapons on command.",
		'pos_dept' => 8,
		'pos_order' => 1,
		'pos_open' => 3,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => "Chief Tactical Officer",
		'pos_desc' => "The Chief Tactical Officer oversees all tactical decisions made onboard the ship/facility. Tactical Operations can include coordination of StarFury squadrons as well as vessel-to-vessel tactical operations. The Chief Tactical Officer works closely with those in the Weapons Division for the successful execution of tactical operations.",
		'pos_dept' => 9,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => "Tactical Officer",
		'pos_desc' => "Tactical Officers assist the Chief Tactical Officer with the tactical operations aboard the ship/facility.",
		'pos_dept' => 9,
		'pos_order' => 1,
		'pos_open' => 3,
		'pos_type' => 'officer'),
);

$catalogue_ranks = array(
	array(
		'rankcat_name' => 'Duty Uniform',
		'rankcat_location' => 'default',
		'rankcat_credits' => "The rank sets used in Nova were created by Kuro-chan of Kuro-RPG. The ranksets can be found at <a href='http://www.kuro-rpg.net' target='_blank''>Kuro-RPG</a>. Please do not copy or modify the images.",
		'rankcat_default' => 'y',
		'rankcat_url' => 'http://www.kuro-rpg.net/',
		'rankcat_genre' => $g)
);
