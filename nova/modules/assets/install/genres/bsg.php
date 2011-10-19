<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Install Genre - BSG
 *
 * @package		Nova
 * @category	Genre
 * @author		ladythorne (Anodyne forums)
 */
 
$g = 'bsg';

$data = array(
	'departments_'. $g 	=> 'depts',
	'ranks_'. $g		=> 'ranks',
	'positions_'. $g	=> 'positions',
	'catalogue_ranks'	=> 'catalogue_ranks',
);

$depts = array(
	array(
		'dept_name' => 'Command',
		'dept_desc' => "The Command Department consists of the Commander and the Executive Officer. The Commander is ultimately responsible for the safety and welfare of the entire crew. S/he has final authority on all decisions regarding the ship and her mission. The Executive officer or XO is the commander's immediate subordinate, and is also his/her successor should the need arise.",
		'dept_order' => 0,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Combat Information Center Staff',
		'dept_desc' => "The CIC Staff consists of the FTL officers, techs and various other systems techs that keep a battlestar and her systems running smoothly.",
		'dept_order' => 1,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Viper Wing',
		'dept_desc' => "The Viper Wing is responsible for engaging the enemy in ship to ship battles, as well as providing escort for military vessels.",
		'dept_order' => 2,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Raptor Wing',
		'dept_desc' => "The Raptor Wing often takes on jobs of reconnaissance, rescue, scouting, and transportation.",
		'dept_order' => 3,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Hangar Deck Staff',
		'dept_desc' => "The Hangar Deck Staff repairs Vipers and Raptors between missions.",
		'dept_order' => 4,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Medical',
		'dept_desc' => "The medical department is responsible for the physical health of the crew, from running annual physicals to treating a wide variety of wounds and diseases.",
		'dept_order' => 5,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Engineering',
		'dept_desc' => "The engineering department has the enormous task of keeping the ship working; they are responsible for making repairs, fixing problems, and making sure that the ship is ready for anything.",
		'dept_order' => 6,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Marine Detachment',
		'dept_desc' => "A Marine's duties include guarding the CIC and the brig as well as other critical areas on the ship, and assisting the Master-at-Arms and are part of Raptor boarding parties. They are also responsible for stopping enemy boarding actions.",
		'dept_order' => 7,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Civilians',
		'dept_desc' => "Civilians fill positions that are not related to the Colonial military. Their jobs may help serve military forces in some form.",
		'dept_order' => 8,
		'dept_manifest' => 1),
);

$ranks = array(
	array(
		'rank_name' => 'Admiral',
		'rank_short_name' => 'ADM',
		'rank_image' => 'a4',
		'rank_order' => 0,
		'rank_class' => 1),
	array(
		'rank_name' => 'Rear-Admiral',
		'rank_short_name' => 'RADM',
		'rank_image' => 'a3',
		'rank_order' => 1,
		'rank_class' => 1),
	array(
		'rank_name' => 'Commander',
		'rank_short_name' => 'CDR',
		'rank_image' => 'a2',
		'rank_order' => 2,
		'rank_class' => 1),
	array(
		'rank_name' => 'Colonel',
		'rank_short_name' => 'COL',
		'rank_image' => 'a1',
		'rank_order' => 3,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant Colonel',
		'rank_short_name' => 'LTCOL',
		'rank_image' => 'o6',
		'rank_order' => 4,
		'rank_class' => 1),
	array(
		'rank_name' => 'Major',
		'rank_short_name' => 'MAJ',
		'rank_image' => 'o5',
		'rank_order' => 5,
		'rank_class' => 1),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'o4',
		'rank_order' => 6,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant',
		'rank_short_name' => 'LT',
		'rank_image' => 'o3',
		'rank_order' => 7,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant JG',
		'rank_short_name' => 'LT(JG)',
		'rank_image' => 'o2',
		'rank_order' => 8,
		'rank_class' => 1),
	array(
		'rank_name' => 'Ensign',
		'rank_short_name' => 'ENS',
		'rank_image' => 'o1',
		'rank_order' => 9,
		'rank_class' => 1),
	array(
		'rank_name' => 'Master Chief Petty Officer',
		'rank_short_name' => 'MCPO',
		'rank_image' => 'e9',
		'rank_order' => 10,
		'rank_class' => 1),
	array(
		'rank_name' => 'Senior Chief Petty Officer',
		'rank_short_name' => 'SCPO',
		'rank_image' => 'e8',
		'rank_order' => 11,
		'rank_class' => 1),
	array(
		'rank_name' => 'Chief Petty Officer',
		'rank_short_name' => 'CPO',
		'rank_image' => 'e7',
		'rank_order' => 12,
		'rank_class' => 1),
	array(
		'rank_name' => 'Petty Officer, 1st Class',
		'rank_short_name' => 'PO1',
		'rank_image' => 'e6',
		'rank_order' => 13,
		'rank_class' => 1),
	array(
		'rank_name' => 'Petty Officer, 2nd Class',
		'rank_short_name' => 'PO2',
		'rank_image' => 'e5',
		'rank_order' => 14,
		'rank_class' => 1),
	array(
		'rank_name' => 'Petty Officer, 3rd Class',
		'rank_short_name' => 'PO3',
		'rank_image' => 'e4',
		'rank_order' => 15,
		'rank_class' => 1),
	array(
		'rank_name' => 'Crewman Specialist',
		'rank_short_name' => 'SPEC',
		'rank_image' => 'e3',
		'rank_order' => 16,
		'rank_class' => 1),
	array(
		'rank_name' => 'Deckhand',
		'rank_short_name' => 'DECK',
		'rank_image' => 'e2',
		'rank_order' => 17,
		'rank_class' => 1),
	array(
		'rank_name' => 'Recruit',
		'rank_short_name' => 'REC',
		'rank_image' => 'e1',
		'rank_order' => 18,
		'rank_class' => 1),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'blank',
		'rank_order' => 19,
		'rank_class' => 1),
		
	array(
		'rank_name' => 'General',
		'rank_short_name' => 'GEN',
		'rank_image' => 'a4',
		'rank_order' => 0,
		'rank_class' => 2),
	array(
		'rank_name' => 'Lieutenant General',
		'rank_short_name' => 'LTGEN',
		'rank_image' => 'a3',
		'rank_order' => 1,
		'rank_class' => 2),
	array(
		'rank_name' => 'Major General',
		'rank_short_name' => 'MAJGEN',
		'rank_image' => 'a2',
		'rank_order' => 2,
		'rank_class' => 2),
	array(
		'rank_name' => 'Brigadier General',
		'rank_short_name' => 'BGEN',
		'rank_image' => 'a1',
		'rank_order' => 3,
		'rank_class' => 2),
	array(
		'rank_name' => 'Colonel',
		'rank_short_name' => 'COL',
		'rank_image' => 'o6',
		'rank_order' => 4,
		'rank_class' => 2),
	array(
		'rank_name' => 'Lieutenant Colonel',
		'rank_short_name' => 'LTCOL',
		'rank_image' => 'o5',
		'rank_order' => 5,
		'rank_class' => 2),
	array(
		'rank_name' => 'Major',
		'rank_short_name' => 'MAJ',
		'rank_image' => 'o4',
		'rank_order' => 6,
		'rank_class' => 2),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'o3',
		'rank_order' => 7,
		'rank_class' => 2),
	array(
		'rank_name' => '1st Lieutenant',
		'rank_short_name' => '1LT',
		'rank_image' => 'o2',
		'rank_order' => 8,
		'rank_class' => 2),
	array(
		'rank_name' => '2nd Lieutenant',
		'rank_short_name' => '2LT',
		'rank_image' => 'o1',
		'rank_order' => 9,
		'rank_class' => 2),
	array(
		'rank_name' => 'Sergeant Major',
		'rank_short_name' => 'SGTMAJ',
		'rank_image' => 'e9',
		'rank_order' => 10,
		'rank_class' => 2),
	array(
		'rank_name' => 'Master Sergeant',
		'rank_short_name' => 'MSGT',
		'rank_image' => 'e8',
		'rank_order' => 11,
		'rank_class' => 2),
	array(
		'rank_name' => 'Gunnery Sergeant',
		'rank_short_name' => 'GYSGT',
		'rank_image' => 'e7',
		'rank_order' => 12,
		'rank_class' => 2),
	array(
		'rank_name' => 'Staff Sergeant',
		'rank_short_name' => 'SSGT',
		'rank_image' => 'e6',
		'rank_order' => 13,
		'rank_class' => 2),
	array(
		'rank_name' => 'Sergeant',
		'rank_short_name' => 'SGT',
		'rank_image' => 'e5',
		'rank_order' => 14,
		'rank_class' => 2),
	array(
		'rank_name' => 'Corporal',
		'rank_short_name' => 'CPL',
		'rank_image' => 'e4',
		'rank_order' => 15,
		'rank_class' => 2),
	array(
		'rank_name' => 'Lance Corporal',
		'rank_short_name' => 'LCPL',
		'rank_image' => 'e3',
		'rank_order' => 16,
		'rank_class' => 2),
	array(
		'rank_name' => 'Private, 1st Class',
		'rank_short_name' => 'PFC',
		'rank_image' => 'e2',
		'rank_order' => 17,
		'rank_class' => 2),
	array(
		'rank_name' => 'Private',
		'rank_short_name' => 'PVT',
		'rank_image' => 'e1',
		'rank_order' => 18,
		'rank_class' => 2),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'blank',
		'rank_order' => 19,
		'rank_class' => 2),
);

$positions = array(
	array(
		'pos_name' => 'Commanding Officer',
		'pos_desc' => "Ultimately responsible for the ship and crew, the Commanding Officer is the most senior officer aboard a vessel. S/he is responsible for carrying out the orders of the President, and for representing the Colonial Fleet.",
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
		'pos_name' => 'Officer of the Deck',
		'pos_desc' => "The OOD, or Officer of the Deck monitors the CIC's operation in the absence of the ship's commanding officer. The OOD generally carries out or relays the command officer's standing orders. In the absence of a command officer, the OOD has the conn, but typically calls the commanding officer before taking any action if time allows.",
		'pos_dept' => 2,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Tactical Officer',
		'pos_desc' => "The Tactical Officer is tasked with the monitoring of DRADIS and coordinating various command and control functionality, including computer control, the Tactical Officer must relay changes in status and keep the commander updated continuously during the fluid events of battle. The Tactical officer is typically the first to know that an attack is imminent and will address the Battlestar by the public address system to go to battle stations through Condition One or Two alerts.\r\n\r\nTactical officer must manually print or offload data from the various central computers s/he monitors (Fire control, Navigation, FTL, and mainframe computers) and relay this information to the other officers and staff in the room. Fortunately, many stations see the same information on displays similar to those at the Tactical Station, but it is the Tactical Officer who is charged with notifying the commander of the changes and interpreting the results. The Tactical Officer also is the administrator for all central computers onboard and provides maintenance as required.\r\n\r\nWhile the Helm officers drive the ship, it is the Tactical officer that plots FTL jumps, the apparently instantaneous leap from one location in space to another location millions of kilometers away. The Tactical officer not only has to provide Jump coordinates to the battlestar's helm, but also relay them if other ships are accompanying the Battlestar.",
		'pos_dept' => 2,
		'pos_order' => 1,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Communications Officer',
		'pos_desc' => "Communications Officers monitors, directs or relays communications to and from fighters and other ships. In coordination with the Tactical Station, the Communications officer can also verify transponders that register as friendly, and alerts the Tactical Officer or commander if they pick up signals without transponders or recognized enemy transponders. The Communications Officer has a link to the mainframe computer, where a library of Colonial recognition information resides.",
		'pos_dept' => 2,
		'pos_order' => 2,
		'pos_open' => 2,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Helm Control Officer',
		'pos_desc' => "Navigation is managed by spatial coordinates based on DRADIS and other sensor information. The helm crewmembers drive the battlestar through a series of controls and based on commands from the Executive officer or commanding officer.",
		'pos_dept' => 2,
		'pos_order' => 3,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Damage Control Officer',
		'pos_desc' => "A Damage Control officer can perform many actions to repair or mitigate the effects of an enemy attack through the controls here, including the venting of compartments, coordination of damage control teams, and the like.",
		'pos_dept' => 2,
		'pos_order' => 4,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Weapons Control Officer',
		'pos_desc' => "The Weapons Control Officer manages the battlestar's gun batteries and other defensive controls. In the event that the Weapons Control Room or CIC is knocked offline or its crew incapacitated, control of the ship's batteries can be managed at Auxiliary Fire Control.",
		'pos_dept' => 2,
		'pos_order' => 5,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Commander, Air Group',
		'pos_desc' => "The Officer in charge of the Viper Wing aboard a battlestar. S/he conducts preflight briefings, is traditionally the lead pilot and is responsible for the Viper pilots as well as the Raptor pilots aboard the ship.",
		'pos_dept' => 3,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Squadron Leader',
		'pos_desc' => "The Squadron Leader directs his or her lower ranking pilots in the heat of battle. The Squadron leader answers directly to the CAG.",
		'pos_dept' => 3,
		'pos_order' => 1,
		'pos_open' => 3,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Viper Pilot',
		'pos_desc' => "Pilots are officers in the Colonial Fleet that trained and qualified to operate a Viper fighter. A Viper Pilot’s main function is to engage in military operations that have been prearranged by superior officers  and take on enemy fighters that are attempting to destroy a ship.",
		'pos_dept' => 3,
		'pos_order' => 5,
		'pos_open' => 6,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Raptor Wing Leader',
		'pos_desc' => "The Raptor Wing Leader works directly with the CAG on future rescue and military operations that Raptors may be needed for.",
		'pos_dept' => 4,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Raptor Pilot',
		'pos_desc' => "Raptor pilots undertake short and medium-range scans to detect electromagnetic, heat or other signatures from other vessels, scan planetary surfaces for signs of life, energy output, or to locate and assess mineral deposits, and scout ahead of its parent warship in other planetary or celestial systems for any signs of hostile intent or stellar conditions prior to the parent ship's arrival.  Raptor pilots also undertake search & rescue operations after an engagement with enemy forces.",
		'pos_dept' => 4,
		'pos_order' => 1,
		'pos_open' => 6,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Electronic Countermeasures Officer',
		'pos_desc' => "An ECO, or Electronic Countermeasures Officer, is responsible for the electronic countermeasures on a Raptor. ECOs also operate computer equipment, including scanning and detection equipment.  ECOs are also trained to fly a Raptor in case the primary pilot is incapacitated or unavailable.",
		'pos_dept' => 4,
		'pos_order' => 5,
		'pos_open' => 6,
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
		'rankcat_credits' => "The rank sets used in Nova were created by Kuro-chan of Kuro-RPG. The ranksets can be found at <a href='http://www.kuro-rpg.net' target='_blank'>Kuro-RPG</a>. Please do not copy or modify the images.",
		'rankcat_default' => 'y',
		'rankcat_url' => 'http://www.kuro-rpg.net/',
		'rankcat_genre' => $g),
);
