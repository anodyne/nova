<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Install Genre - KLI
 *
 * @package		Nova
 * @category	Genre
 * @author		Anodyne Productions
 */
 
$g = 'kli';

$data = array(
	'departments_'. $g 	=> 'depts',
	'ranks_'. $g		=> 'ranks',
	'positions_'. $g	=> 'positions',
	'catalogue_ranks'	=> 'catalogue_ranks',
);

$depts = array(
	array(
		'dept_name' => 'Command',
		'dept_desc' => "The Command division on a Klingon vessel is made up of the seniormost Klingon officers. Commanding a ship, base or other vessel is considered an honor worthy of song and carries with it the responsibilities of running the ship, base or vessel and carrying out the orders of the Klingon Defense Force.",
		'dept_order' => 0,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Tactical',
		'dept_desc' => "When it comes to space battles, there are no finer tacticians and gunners than Klingons. All officers in the Klingon Defense Force undergo signficant tactical training before being given their officer status by the Klingon Oversight Council. Great honor can come from being an excellent tactical officer.",
		'dept_order' => 1,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Navigation',
		'dept_desc' => "Much like any warrior in the Tactical division, the Navigation division are known for their bold and innovative battle maneuvers. Warriors in the Navigation division work closely with the Tactical division and understand battle tactics better than most.",
		'dept_order' => 2,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Engineering',
		'dept_desc' => "The Klingon Empire isn't known for its engineers. Despite that though, the Klingon Defense Force Order of Engineers is an honorable one with a long history of keeping vessels in battles for greater glory.",
		'dept_order' => 3,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Medical',
		'dept_desc' => "Medical and Science services are sparse in the Klingon Empire and as such are in high demand on ships, bases and vessels near the front lines of a conflict. Besides dealing with medical problems, all Klingon physicians also double as science officers for the ship, base or vessel.",
		'dept_order' => 4,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Warriors',
		'dept_desc' => "Klingon Warriors are feared throughout the galaxy for their ferocity. There are few other better warriors than a Klingon, even half drunk. Being a warrior and dying honorably in combat is the highest honor a Klingon can achieve.",
		'dept_order' => 5,
		'dept_manifest' => 1)
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
		'pos_desc' => "The commanding officer is the seniormost Klingon aboard a vessel. The position of commanding a ship, base or vessel is seen as an honorable one that carries with it the responsibility of leading warriors into battle and carrying out the orders of the Klingon Defense Force.",
		'pos_dept' => 1,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'First Officer',
		'pos_desc' => "The first officer is the second in command to the commanding officer and assists them in carrying out their duties. According to Klingon tradition, it is the responsibility of the first officer to assassinate his captain if the captain becomes weak or unable to perform.",
		'pos_dept' => 1,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Second Officer',
		'pos_desc' => "The second officer is the third in command to the commanding officer and assists the first officer in carrying out the necessary duties on the ship, base or vessel. According to Klingon tradition, it is the responsibility of the second officer to assassinate the first officer if they becomes weak or unable to perform.",
		'pos_dept' => 1,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	
	array(
		'pos_name' => 'Chief Tactical Officer',
		'pos_desc' => "The Chief Tactical Officer is the seniormost tactician aboard a Klingon vessel. The position of Chief Tactical Officer is one of the few positions a Klingon Commanding Officer is allowed to pick themselves. It is considered a high honor to be selected to be the Chief Tactical Officer aboard a Klingon vessel. In addition to laying out tactical strategies with the Command officers, the Chief Tactical Officer oversees all weapons and armaments on the ship, base or vessel.",
		'pos_dept' => 2,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Second Tactical Officer',
		'pos_desc' => "The Second Tactical Officer assists the Chief Tactical Officer with their duties in maintaining the weapons and armaments of the ship, base or vessel, whether that's ship weapons or the armory.",
		'pos_dept' => 2,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Tactical Officer',
		'pos_desc' => "Tactical Officers are one of the most widely available positions in the Klingon Defense Force. Distinguished Tactical Officers can often go on to become Second Tactical Officers. Duties of the tactical officers is mainly carrying out the orders of their superiors and helping train and develop gunners into tactical officers.",
		'pos_dept' => 2,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Gunner',
		'pos_desc' => "The gunner is primarily responsible for manning the weapons systems on a Klingon ship, base or vessel. In most cases, gunners go on to become tactical officers. Because of the quest for honor, it isn't uncommon for tactical officers to relieve the gunners during battle.",
		'pos_dept' => 2,
		'pos_order' => 3,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => "Gunner's Mate",
		'pos_desc' => "Usually a young warrior on their first assignments, the gunner's mate is on the ship, base or vessel to learn the ins and outs of life aboard a Klingon vessel and get a taste of their first battles.",
		'pos_dept' => 2,
		'pos_order' => 4,
		'pos_open' => 4,
		'pos_type' => 'enlisted'),
		
	array(
		'pos_name' => 'Chief Navigator',
		'pos_desc' => "After the Tactical division, the Navigation division is one of the most important on a Klingon Vessel. The Chief Navigator is responsible for piloting the vessel and working with the Tactical division for optimal tactical effectiveness during battle. Klingon navigators are known for their bold and innovative navigational tactics during battle and are often known to be unpredictable, lending to their successes during combat.",
		'pos_dept' => 3,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Second Navigator',
		'pos_desc' => "The Second Navigator is an experienced navigator who assists the Chief Navigator in their duties piloting the Klingon vessel. In most instances, the Chief Navigator will take over the helm controls during battle, but highly skilled Second Navigators can also be entrusted with the duties. In addition, Second Navigators oversee all auxiliary craft on the ship, base or vessel under the oversight of the Chief Navigator.",
		'pos_dept' => 3,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Navigator',
		'pos_desc' => "Navigators are usually warriors who wish to move up into the officer ranks and pursue other honorable avenues to ultimate glory. Most navigators have little to know experience piloting and are trained on auxiliary craft and when the vessel isn't engaged in battle. It is rare for a navigator to ever pilot a vessel during combat.",
		'pos_dept' => 3,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
		
	array(
		'pos_name' => 'Chief Engineer',
		'pos_desc' => "The Chief Engineer is the seniormost Klingon engineer aboard a ship, base or vessel and is a member of the Order of Engineers. Klingon engineers have one job: keep the vessel's damage from interfering with continuing the battle. Because of the long history of doing so, most engineers are highly respected and honored on Klingon vessels.",
		'pos_dept' => 4,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Second Engineer',
		'pos_desc' => "The Second Engineer is often an aspiring Chief Engineer who has not been granted admission to the Order of Engineers. During their assignment, they are usually evaluated by the Chief Engineer for admission into the order. The Second Engineer's duties are assisting the Chief Engineer in maintaining the ship, base or vessel both leading up to and during battle.",
		'pos_dept' => 4,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Engineer',
		'pos_desc' => "Klingon engineers are usually young officers on some of their first assignments. Due to the limitd number of engineers available in the Klingon Defense Force, they're often promoted to Second Engineer more rapidly than in other departments. Engineers report to the Chief Engineer and are responsible for maintaining the ship, base or vessel in and out of combat.",
		'pos_dept' => 4,
		'pos_order' => 2,
		'pos_open' => 6,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Damage Control Specialist',
		'pos_desc' => "A Klingon Damage Control Specialist is responsible for reporting all damage to the Chief Engineer and assisting in triaging and repairing damaged systems before they force the Klingon vessel to retreat from battle.",
		'pos_dept' => 4,
		'pos_order' => 3,
		'pos_open' => 4,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Cloaking Technician',
		'pos_desc' => "Cloaking devices are one of the most difficult pieces of technology for Klingons to deal with. Cloaking Technicians are proficient in repairs and optimization of the cloaking device and often go on to become Chief Engineers in the Klingon Defense Force.",
		'pos_dept' => 4,
		'pos_order' => 4,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Weapons Systems Specialist',
		'pos_desc' => "One of the most integral engineers on any Klingon ship, base or vessel, the Weapons Systems Specialist is responsible for the maintainence of the tactical hardware found throughout the ship, whether it's shipboard weapons or the armory.",
		'pos_dept' => 4,
		'pos_order' => 5,
		'pos_open' => 4,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Chief Physician',
		'pos_desc' => "The Chief Physician is tasked with the physical well-being of the crew and providing medical assistance where needed. In many cases, the Chief Physician will be charged with assisting wounded warriors in attaining a more honorable death than lying on a bed waiting to die. In addition, physicians carry the added responsibility of being the science officers aboard a Klingon vessel.",
		'pos_dept' => 5,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Physician',
		'pos_desc' => "While rare on smaller vessels, some Klingon vessels and bases have more than one physician who aids the Chief Physician in their medical and scientific duties. On medium-sized vessels, a physician will usually take on the duties the Chief Physician prefers not to do. Like Chief Physicians, normal physicians carry the added responsibility of being the science officers aboard a Klingon ship, base or vessel.",
		'pos_dept' => 5,
		'pos_order' => 1,
		'pos_open' => 3,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Chief Warrior',
		'pos_desc' => "While most warriors on a Klingon ship, base or vessel are enlisted, the Chief Warrior is an officer and highly decorated warrior with a vast amount of combat experience. In many cases, Chief Warriors have been admitted to the Order of the Bat'leth during their time as a Chief Warrior.\r\n\r\nThe Chief Warrior is responsible for ground combat tactical decisions and leading Klingon warriors into battle, be it on a planet or on another vessel.",
		'pos_dept' => 6,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Second Warrior',
		'pos_desc' => "The Second Warrior is a respected officer and warrior who reports to the Chief Warrior and is responsible for assisting the Chief Warrior in their duties. In some rare cases, Second Warriors are also members of the Order of the Bat'leth. In addition to assisting with tactical decisions, the Second Warrior is most often responsible for shipboard security as well under the oversight of the Chief Warrior.",
		'pos_dept' => 6,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Squad Leader',
		'pos_desc' => "Warriors are broken down into squads that are commanded by junior officers with combat experience or highly senior enlisted warriors. Working with the Chief and Second Warriors, they are responsible for executing battle orders.",
		'pos_dept' => 6,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Master-at-Arms',
		'pos_desc' => "The Master-at-Arms is primarily responsible for training warriors on the things they need most. In many cases, this includes continued training on hand-to-hand combat, but can also include training on explosives, infiltration and more technical matters of an upcoming assignment.",
		'pos_dept' => 6,
		'pos_order' => 3,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Warrior',
		'pos_desc' => "Comprising the highest majority of Klingons on a ship, warriors are the lifeblood of the Klingon Defense Force and strive to bring glory and honor to their houses through battle.",
		'pos_dept' => 6,
		'pos_order' => 4,
		'pos_open' => 20,
		'pos_type' => 'enlisted')
);

$catalogue_ranks = array(
	array(
		'rankcat_name' => 'Duty Uniform',
		'rankcat_location' => 'default',
		'rankcat_credits' => "The rank sets was created by Kuro-chan of Kuro-RPG. The rankset (and others) can be found at <a href='http://www.kuro-rpg.net' target='_blank'>Kuro-RPG</a>. Please do not copy or modify the images.",
		'rankcat_default' => 'y',
		'rankcat_url' => 'http://www.kuro-rpg.net/',
		'rankcat_genre' => $g)
);
