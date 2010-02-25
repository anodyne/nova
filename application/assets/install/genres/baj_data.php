<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| INSTALL - GENRE DATA (ST:BAJ)
|---------------------------------------------------------------
|
| File: assets/install_data_baj.php
| System Version: 1.0
|
| Genre data compiled by David VanScott
|
*/

# TODO: religious ranks

# TODO: security and tactical positions
# TODO: medical positions
# TODO: science positions
# TODO: aerial guard fighter detachment positions

# TODO: need a new name for chief of the boat position

/*
|---------------------------------------------------------------
| Genre Variables
|---------------------------------------------------------------
*/
$g = 'baj';

/*
|---------------------------------------------------------------
| Genre Table Data (ST:BAJ)
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
		'dept_desc' => "The Command division of the Bajoran Militia is made up of experienced officers that are responsible for carrying out the orders of the Bajoran Provisional Government and the Bajoran Militia. Members of the Command division have undergone training at the Bajoran Military Academy's Command School before accepting positions in the fleet.",
		'dept_order' => 0),
	array(
		'dept_name' => 'Aerial Operations',
		'dept_desc' => "The Aerial Operations division is comprised of pilots of both large vessels as well as single-seat fighters and atmospheric vessels. The Aerial Operations division is responsible for the safe navigation of all vessels in the Bajoran Militia including operation of Aerial Guard Fighter Detachments.",
		'dept_order' => 1),
	array(
		'dept_name' => 'Operations',
		'dept_desc' => "The Operations division is responsible for keeping systems functioning properly, rerouting power, bypassing relays and doing whatever else is necessary to keep the systems operating at peak efficiency. Most Operations graduates of the Bajoran Military Academy are also highly skilled in engineering skills as well.",
		'dept_order' => 2),
	array(
		'dept_name' => 'Engineering',
		'dept_desc' => "The Engineering division has the enormous task of keeping the vessel working; they are responsible for making repairs, fixing problems and ensuring the vessel is ready for anything. In addition to maintaining the larger vessels, the Engineering division also works closely with the Aerial Guard to maintain the Aerial Guard Fighter Detachments as well.",
		'dept_order' => 3),
	array(
		'dept_name' => 'Security &amp; Tactical',
		'dept_desc' => "Comprised of veterans of the Cardassian Occupation and Dominion War, the Security &amp; Tactical division of the Bajoran Militia is responsible for the safety of the personnel aboard a ship or base as well as the tactical planning, preparation, maintenance and execution of tactical tasks.",
		'dept_order' => 4),
	array(
		'dept_name' => 'Medical',
		'dept_desc' => "The healers of the Bajoran Militia, the Medical division on a ship or base are among some of the best trained medical personnel in the quadrant. After completing required coursework at the Bajoran Military Academy, medical students spend great amounts of time at several of Bajor's premier medical facilities before accepting positions in the Militia.",
		'dept_order' => 5),
	array(
		'dept_name' => 'Science',
		'dept_desc' => "Over the years, Bajoran scientists have been at the forefront of many significant scientific breakthroughs. Though they have to attend the Bajoran Military Academy to gain a commission in the Bajoran Militia, many Militia scientists spend time on Earth and Vulcan working with their Federation counterparts before taking posts in the Militia.",
		'dept_order' => 6),
	array(
		'dept_name' => 'Aerial Guard Fighter Detachment',
		'dept_desc' => "Originally conceived as planetary air defense, the Aerial Guard division of the Bajoran Militia has evolved to take on the role of space superiority as well. While not as adept at space superiority as Starfleet, Bajoran fighter pilots have innate tenacity from the Cardassian Occupation as well as conflicts throughout their history.",
		'dept_order' => 7),
	array(
		'dept_name' => 'Bajoran Religious Order',
		'dept_desc' => "Faith permeates the entire Bajoran culture through a stratified religious order that holds significant cultural and political influence on Bajor.",
		'dept_order' => 8),
	array(
		'dept_name' => 'Vedek Assembly',
		'dept_desc' => "The Vedek Assembly is the governing body of the Bajoran religion and holds great political influence as well. The Assembly is led by the Kai, the leading religious figure on Bajor.",
		'dept_order' => 0,
		'dept_parent' => 9),
);

$ranks= array(
	array(
		'rank_name' => 'General',
		'rank_short_name' => 'GEN',
		'rank_image' => 'r-a4',
		'rank_order' => 0,
		'rank_class' => 1),
	array(
		'rank_name' => 'General',
		'rank_short_name' => 'GEN',
		'rank_image' => 'g-a4',
		'rank_order' => 0,
		'rank_class' => 2),
	array(
		'rank_name' => 'General',
		'rank_short_name' => 'GEN',
		'rank_image' => 'y-a4',
		'rank_order' => 0,
		'rank_class' => 3),
	array(
		'rank_name' => 'General',
		'rank_short_name' => 'GEN',
		'rank_image' => 'b-a4',
		'rank_order' => 0,
		'rank_class' => 4),
	array(
		'rank_name' => 'General',
		'rank_short_name' => 'GEN',
		'rank_image' => 's-a4',
		'rank_order' => 0,
		'rank_class' => 5),
	array(
		'rank_name' => 'Emissary',
		'rank_short_name' => 'EMS',
		'rank_image' => 's-a4',
		'rank_order' => 0,
		'rank_class' => 6),
		
	array(
		'rank_name' => 'Lieutenant General',
		'rank_short_name' => 'LT GEN',
		'rank_image' => 'r-a3',
		'rank_order' => 1,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant General',
		'rank_short_name' => 'LT GEN',
		'rank_image' => 'g-a3',
		'rank_order' => 1,
		'rank_class' => 2),
	array(
		'rank_name' => 'Lieutenant General',
		'rank_short_name' => 'LT GEN',
		'rank_image' => 'y-a3',
		'rank_order' => 1,
		'rank_class' => 3),
	array(
		'rank_name' => 'Lieutenant General',
		'rank_short_name' => 'LT GEN',
		'rank_image' => 'b-a3',
		'rank_order' => 1,
		'rank_class' => 4),
	array(
		'rank_name' => 'Lieutenant General',
		'rank_short_name' => 'LT GEN',
		'rank_image' => 's-a3',
		'rank_order' => 1,
		'rank_class' => 5),
	array(
		'rank_name' => 'Kai',
		'rank_short_name' => 'KAI',
		'rank_image' => 's-a3',
		'rank_order' => 1,
		'rank_class' => 6),
		
	array(
		'rank_name' => 'Major General',
		'rank_short_name' => 'MAJ GEN',
		'rank_image' => 'r-a2',
		'rank_order' => 2,
		'rank_class' => 1),
	array(
		'rank_name' => 'Major General',
		'rank_short_name' => 'MAJ GEN',
		'rank_image' => 'g-a2',
		'rank_order' => 2,
		'rank_class' => 2),
	array(
		'rank_name' => 'Major General',
		'rank_short_name' => 'MAJ GEN',
		'rank_image' => 'y-a2',
		'rank_order' => 2,
		'rank_class' => 3),
	array(
		'rank_name' => 'Major General',
		'rank_short_name' => 'MAJ GEN',
		'rank_image' => 'b-a2',
		'rank_order' => 2,
		'rank_class' => 4),
	array(
		'rank_name' => 'Major General',
		'rank_short_name' => 'MAJ GEN',
		'rank_image' => 's-a2',
		'rank_order' => 2,
		'rank_class' => 5),
	array(
		'rank_name' => 'Vedek',
		'rank_short_name' => 'VDK',
		'rank_image' => 's-a2',
		'rank_order' => 2,
		'rank_class' => 6),
		
	array(
		'rank_name' => 'Brigadier General',
		'rank_short_name' => 'BRG GEN',
		'rank_image' => 'r-a1',
		'rank_order' => 3,
		'rank_class' => 1),
	array(
		'rank_name' => 'Brigadier General',
		'rank_short_name' => 'BRG GEN',
		'rank_image' => 'g-a1',
		'rank_order' => 3,
		'rank_class' => 2),
	array(
		'rank_name' => 'Brigadier General',
		'rank_short_name' => 'BRG GEN',
		'rank_image' => 'y-a1',
		'rank_order' => 3,
		'rank_class' => 3),
	array(
		'rank_name' => 'Brigadier General',
		'rank_short_name' => 'BRG GEN',
		'rank_image' => 'b-a1',
		'rank_order' => 3,
		'rank_class' => 4),
	array(
		'rank_name' => 'Brigadier General',
		'rank_short_name' => 'BRG GEN',
		'rank_image' => 's-a1',
		'rank_order' => 3,
		'rank_class' => 5),
	array(
		'rank_name' => 'Ranjen',
		'rank_short_name' => 'RNJ',
		'rank_image' => 's-a1',
		'rank_order' => 3,
		'rank_class' => 6),
		
	array(
		'rank_name' => 'Colonel',
		'rank_short_name' => 'COL',
		'rank_image' => 'r-o6',
		'rank_order' => 4,
		'rank_class' => 1),
	array(
		'rank_name' => 'Colonel',
		'rank_short_name' => 'COL',
		'rank_image' => 'g-o6',
		'rank_order' => 4,
		'rank_class' => 2),
	array(
		'rank_name' => 'Colonel',
		'rank_short_name' => 'COL',
		'rank_image' => 'y-o6',
		'rank_order' => 4,
		'rank_class' => 3),
	array(
		'rank_name' => 'Colonel',
		'rank_short_name' => 'COL',
		'rank_image' => 'b-o6',
		'rank_order' => 4,
		'rank_class' => 4),
	array(
		'rank_name' => 'Colonel',
		'rank_short_name' => 'COL',
		'rank_image' => 's-o6',
		'rank_order' => 4,
		'rank_class' => 5),
	array(
		'rank_name' => 'Prylar',
		'rank_short_name' => 'PYL',
		'rank_image' => 's-o6',
		'rank_order' => 4,
		'rank_class' => 6),
		
	array(
		'rank_name' => 'Field Colonel',
		'rank_short_name' => 'FCOL',
		'rank_image' => 'r-o5',
		'rank_order' => 5,
		'rank_class' => 1),
	array(
		'rank_name' => 'Field Colonel',
		'rank_short_name' => 'FCOL',
		'rank_image' => 'g-o5',
		'rank_order' => 5,
		'rank_class' => 2),
	array(
		'rank_name' => 'Field Colonel',
		'rank_short_name' => 'FCOL',
		'rank_image' => 'y-o5',
		'rank_order' => 5,
		'rank_class' => 3),
	array(
		'rank_name' => 'Field Colonel',
		'rank_short_name' => 'FCOL',
		'rank_image' => 'b-o5',
		'rank_order' => 5,
		'rank_class' => 4),
	array(
		'rank_name' => 'Field Colonel',
		'rank_short_name' => 'FCOL',
		'rank_image' => 's-o5',
		'rank_order' => 5,
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Major',
		'rank_short_name' => 'MAJ',
		'rank_image' => 'r-o4',
		'rank_order' => 6,
		'rank_class' => 1),
	array(
		'rank_name' => 'Major',
		'rank_short_name' => 'MAJ',
		'rank_image' => 'g-o4',
		'rank_order' => 6,
		'rank_class' => 2),
	array(
		'rank_name' => 'Major',
		'rank_short_name' => 'MAJ',
		'rank_image' => 'y-o4',
		'rank_order' => 6,
		'rank_class' => 3),
	array(
		'rank_name' => 'Major',
		'rank_short_name' => 'MAJ',
		'rank_image' => 'b-o4',
		'rank_order' => 6,
		'rank_class' => 4),
	array(
		'rank_name' => 'Major',
		'rank_short_name' => 'MAJ',
		'rank_image' => 's-o4',
		'rank_order' => 6,
		'rank_class' => 5),
		
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'r-o3',
		'rank_order' => 7,
		'rank_class' => 1),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'g-o3',
		'rank_order' => 7,
		'rank_class' => 2),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'y-o3',
		'rank_order' => 7,
		'rank_class' => 3),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'b-o3',
		'rank_order' => 7,
		'rank_class' => 4),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 's-o3',
		'rank_order' => 7,
		'rank_class' => 5),
		
	array(
		'rank_name' => '1st Lieutenant',
		'rank_short_name' => '1LT',
		'rank_image' => 'r-o2',
		'rank_order' => 8,
		'rank_class' => 1),
	array(
		'rank_name' => '1st Lieutenant',
		'rank_short_name' => '1LT',
		'rank_image' => 'g-o2',
		'rank_order' => 8,
		'rank_class' => 2),
	array(
		'rank_name' => '1st Lieutenant',
		'rank_short_name' => '1LT',
		'rank_image' => 'y-o2',
		'rank_order' => 8,
		'rank_class' => 3),
	array(
		'rank_name' => '1st Lieutenant',
		'rank_short_name' => '1LT',
		'rank_image' => 'b-o2',
		'rank_order' => 8,
		'rank_class' => 4),
	array(
		'rank_name' => '1st Lieutenant',
		'rank_short_name' => '1LT',
		'rank_image' => 's-o2',
		'rank_order' => 8,
		'rank_class' => 5),
		
	array(
		'rank_name' => '2nd Lieutenant',
		'rank_short_name' => '2LT',
		'rank_image' => 'r-o1',
		'rank_order' => 9,
		'rank_class' => 1),
	array(
		'rank_name' => '2nd Lieutenant',
		'rank_short_name' => '2LT',
		'rank_image' => 'g-o1',
		'rank_order' => 9,
		'rank_class' => 2),
	array(
		'rank_name' => '2nd Lieutenant',
		'rank_short_name' => '2LT',
		'rank_image' => 'y-o1',
		'rank_order' => 9,
		'rank_class' => 3),
	array(
		'rank_name' => '2nd Lieutenant',
		'rank_short_name' => '2LT',
		'rank_image' => 'b-o1',
		'rank_order' => 9,
		'rank_class' => 4),
	array(
		'rank_name' => '2nd Lieutenant',
		'rank_short_name' => '2LT',
		'rank_image' => 's-o1',
		'rank_order' => 9,
		'rank_class' => 5),
		
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'r-blank',
		'rank_order' => 10,
		'rank_class' => 1),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'g-blank',
		'rank_order' => 10,
		'rank_class' => 2),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'y-blank',
		'rank_order' => 10,
		'rank_class' => 3),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'b-blank',
		'rank_order' => 10,
		'rank_class' => 4),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 's-blank',
		'rank_order' => 10,
		'rank_class' => 5)
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 's-blank',
		'rank_order' => 5,
		'rank_class' => 6)
);

$positions = array(
	array(
		'pos_name' => 'Commanding Officer',
		'pos_desc' => "The Commanding Officer is the seniormost Militia officer aboard the vessel and is in charge of everything that happens on the vessel. The Commanding Officer is responsible for executing the orders from the Provisional Government and Militia leaders.",
		'pos_dept' => 1,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'First Officer',
		'pos_desc' => "The First Officer is the second seniormost Militia officer aboard the vessel and assists the Commanding Officer in their duties including management of all officers and enlisted personnel aboard the vessel. In the event the Commanding Officer is unable to do their duties, the First Officer assumes their role.",
		'pos_dept' => 1,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Chief of the Boat',
		'pos_desc' => "The Chief of the Boat is the seniormost enlisted officer aboard the vessel. Usually handpicked by the Commanding Officer, the Chief of the Boat is responsible for working with the First Officer to manage the enlisted personnel on the vessel including training and additional qualifications.",
		'pos_dept' => 1,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
		
	array(
		'pos_name' => 'First Pilot',
		'pos_desc' => "The First Pilot is the seniormost Aerial Operations officer aboard the vessel. The First Pilot is responsible for the safe navigation and piloting of the vessel as well as any non-Militia auxiliary craft such as shuttlepods, shuttlecraft and impulse vessels that may be assigned to the vessel.",
		'pos_dept' => 2,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Second Pilot',
		'pos_desc' => "The Second Pilot is a senior Aerial Operations officer aboard the vessel and is responsible for assisting the First Pilot with their duties. Often, the Second Pilot will be the primary pilot of auxiliary craft and helps training the other pilots aboard the vessel.",
		'pos_dept' => 2,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Pilot',
		'pos_desc' => "The pilot is a member of the Aerial Operations division and is responsible for aiding the First and Second Pilots in navigating and piloting the vessel as well as auxiliary craft.",
		'pos_dept' => 2,
		'pos_order' => 2,
		'pos_open' => 5,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'First Operations Officer',
		'pos_desc' => "The First Operations Officer is the seniormost Operations officer aboard the vessel and is responsible for maintaining the vessel on a day-to-day basis including anything that maintains the smooth operation of the vessel. Because of the close ties to the Engineering division, most First Operations Officers also spend some of their time working with the Engineering division.",
		'pos_dept' => 3,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Second Operations Officer',
		'pos_desc' => "The Second Operations Officer is a senior Operations officer aboard the vessel and is responsible for assisting the First Operations Officer in their duties. Part of qualifications for becoming a First Operations Officer includes engineering qualifications overseen by the First Operations Officer and the Chief Engineer.",
		'pos_dept' => 3,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Operations Officer',
		'pos_desc' => "The Operations Officer is responsible for maintaining the smooth operation of the vessel at the orders of the First Operations Officer. Operations Officers report to the First Operations Officer.",
		'pos_dept' => 3,
		'pos_order' => 2,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Quartermaster',
		'pos_desc' => "The Quartermaster specializes in distributing supplies and provisions to personnel aboard the vessel. In addition, the Quartermaster controls all physical assignments to quarters throughout the vessel.",
		'pos_dept' => 3,
		'pos_order' => 3,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Boatswain',
		'pos_desc' => "Each vessel and base has one enlisted officer who holds the position of Boatswain. The Boatswain (pronounced and also written 'Bosun') trains and supervises personnel (including both the ship's company or base personnel as well as passengers or vessels) in general ship and base operations, repairs, and protocols; maintains duty assignments for all Operations personnel; sets the agenda for instruction in general ship and base operations; supervises auxiliary and utility service personnel and daily ship or base maintenance; coordinates all personnel cross-trained in damage control operations and supervises damage control and emergency operations; may assume any Bridge or Operations role as required; and is qualified to temporarily act at Operations if so ordered.\r\n\r\nThe Boatswain reports to the First Operations Officer.",
		'pos_dept' => 3,
		'pos_order' => 4,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
		
	array(
		'pos_name' => 'Chief Engineer',
		'pos_desc' => "The Chief Engineer is responsible for the condition of all systems and equipment aboard the vessel and oversees maintenance, repairs and upgrades of all equipment. During crisis situations, the Chief Engineer is also responsible for the any repair teams.\r\n\r\nThe Chief Engineer is not only the division head but also a senior officer, responsible for all the crew members in her/his division and maintenance of the duty rosters.",
		'pos_dept' => 4,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Second Engineer',
		'pos_desc' => "The Second Engineer assists the Chief Engineer in the daily work; in issues regarding mechanical, administrative matters and coordinating repairs with other departments.\r\n\r\nIf so required, the Second Engineer must be able to take over as Chief Engineer and must be versed in current information regarding the ship or facility.",
		'pos_dept' => 4,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Engineer',
		'pos_desc' => "Engineers are at the core of the Bajoran Corps of Engineers and are responsible for, under the guidance of the Chief Engineer, maintaining and repairing the vessel.",
		'pos_dept' => 4,
		'pos_order' => 2,
		'pos_open' => 10,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Aerial Operations Specialist',
		'pos_desc' => "The Aerial Operations Specialist is a specially trained enlisted personnel who works closed with Aerial Guard units on the repair and maintenance of shuttlepods, shuttlecraft, impulse vessels and fighters. The Aerial Operations Specialist reports to the Chief Engineer.",
		'pos_dept' => 4,
		'pos_order' => 3,
		'pos_open' => 5,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Communications Specialist',
		'pos_desc' => "The Communications Specialist is a specialized engineer. Communication aboard a ship or facility takes two basic forms, voice and data. Both are handled by the onboard computer system and dedicated hardware. The vastness and complexity of this system requires a dedicated team to maintain the system.\r\n\r\nThe Communications Specialist is the person in charge of this team, which is made up from enlisted personnel, assigned to the team by the First and Chief Engineer.",
		'pos_dept' => 4,
		'pos_order' => 4,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Computer Systems Specialist',
		'pos_desc' => "The Computer Systems Specialist is a specialized Engineer. The new generation of Computer systems are highly developed. This system needs much maintenance and the Computer Systems Specialist was introduced to relieve the Science Officer, whose duty this was in the very early days.\r\n\r\nA small team is assigned to the Computer Systems Specialist, which is made up from enlisted personnel assigned by the First and Chief Engineer.",
		'pos_dept' => 4,
		'pos_order' => 5,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Damage Control Specialist',
		'pos_desc' => "The Damage Control Specialist is a specialized Engineer. The Damage Control Specialist controls all damage control aboard the ship when it gets damaged in battle. S/he oversees all damage repair aboard the ship, and coordinates repair teams on the smaller jobs so the Chief Engineer can worry about other matters.\r\n\r\nA small team is assigned to the Damage Control Specialist which is made up from NCO personnel assigned by the Assistant and Chief Engineer. The Damage Control Specialist reports to the Assistant and Chief Engineer.",
		'pos_dept' => 4,
		'pos_order' => 6,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Matter/Energy Systems Specialist',
		'pos_desc' => "The Matter/Energy Systems Specialist is a specialized Engineer. All aspect of matter energy transfers with the sole exception of the warp drive systems are handled by the Matter/Energy Systems Specialist. Such areas involved are transporter and replicator systems. The Matter/Energy Systems Specialist is the officer in charge of a small team, which is made up of enlisted personnel, assigned by the First and Chief Engineer.",
		'pos_dept' => 4,
		'pos_order' => 7,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Propulsion Specialist',
		'pos_desc' => "Specializing in impulse and warp propulsion, these engineers specialize in the complexities of warp and impulse systems and can sometimes even specialize in specific classes of vessels.",
		'pos_dept' => 4,
		'pos_order' => 8,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Structural/Environmental Specialist',
		'pos_desc' => "The Structural and Environmental Systems Specialist is a specialized Engineer. From a small ship/facility to a large one, all requires constant monitoring. The hull, bulkheads, walls, lifts, structural integrity field, internal dampening field and environmental systems are all monitored and maintained by this officer and his/her team.\r\n\r\nThe team assigned to the Structural and Environmental Systems Specialist is made up of enlisted personnel assigned by the First and Chief Engineer.",
		'pos_dept' => 4,
		'pos_order' => 9,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
		
	array(
		'pos_name' => 'Emissary',
		'pos_desc' => "The Emissary of the Prophets is a pivotal figure in the Bajoran religion who, according to prophecy, can speak to the Prophets and would save Bajor by finding the Celestial Temple. The Emissary has the authority to perform several Bajoran ceremonies and blessings, and is often looked to by the people for guidance.",
		'pos_dept' => 8,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Vedek',
		'pos_desc' => "Vedeks are established members within Bajoran religion. Not all sit on the Vedek Assembly; one had to be selected to join the ranks. Vedeks are among the highest religious positions a Bajoran can attain.",
		'pos_dept' => 8,
		'pos_order' => 1,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Ranjen',
		'pos_desc' => "Ranjen monks are a rank within the Bajoran religious system, falling between Prylars and Vedeks. The role of ranjen varied from advisors to sermonizers, and were often seen serving the Kai.",
		'pos_dept' => 8,
		'pos_order' => 2,
		'pos_open' => 10,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Prylar',
		'pos_desc' => "Prylars are considered monks within the Bajoran religious establishment. They are able to hold services, and also assist vedeks and other higher-ranking members of the religious orders.",
		'pos_dept' => 8,
		'pos_order' => 3,
		'pos_open' => 20,
		'pos_type' => 'enlisted'),
	
	array(
		'pos_name' => 'Kai of Bajor',
		'pos_desc' => "The Kai is the religious leader of the Bajorans, elected from among and by the Vedek Assembly to a life term. A symbol of strength and unity, the Kai's religious authority is rivaled only by that of the Emissary to the Prophets.\r\n\r\nBesides religious power, the Kai also has a great deal of political influence in the Bajoran government. Disputes between the Kai and the First Minister of the government, while rare, can be extremely divisive. While it is not forbidden for the Kai to server as First Minister, such involvement in political matters is discouraged.",
		'pos_dept' => 9,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Vedek',
		'pos_desc' => "Vedeks are established members within Bajoran religion. Not all sit on the Vedek Assembly; one had to be selected to join the ranks. Vedeks are among the highest religious positions a Bajoran can attain.",
		'pos_dept' => 9,
		'pos_order' => 1,
		'pos_open' => 5,
		'pos_type' => 'officer'),
);

$catalogue_ranks = array(
	array(
		'rankcat_name' => 'Bajoran Ranks',
		'rankcat_location' => 'default',
		'rankcat_credits' => "The Bajoran rank set was created by Kuro-chan of Kuro-RPG. The rankset (and others) can be found at <a href='http://www.kuro-rpg.net' target='_blank'>Kuro-RPG</a>. Please do not copy or modify the images.",
		'rankcat_default' => 'y',
		'rankcat_url' => 'http://www.kuro-rpg.net/')
);

/* End of file install_data_baj.php */
/* Location: ./application/assets/install/install_data_baj.php */