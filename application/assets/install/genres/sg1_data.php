<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| INSTALL - GENRE DATA (SG1)
|---------------------------------------------------------------
|
| File: assets/install_data_sg1.php
| System Version: 1.0
|
| Data asset file for the STARGATE SG-1 genre.
|
*/

/*
|---------------------------------------------------------------
| Genre Variables
|---------------------------------------------------------------
*/
$g = 'sg1';

/*
|---------------------------------------------------------------
| Genre Table Data (SG1)
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
		'dept_desc' => "The command staff are responsible for organizing and directing the Off World teams, as well as handling any non terrestrial diplomatic occurrences.",
		'dept_order' => 0),
	array(
		'dept_name' => 'Medical Staff',
		'dept_desc' => "The base medical staff are in charge of keeping everyone in working condition, and they're good at it. It's up to them to make sure that all team members are healthy leaving, and returning through the Stargate.",
		'dept_order' => 1),
	array(
		'dept_name' => 'Engineering Staff',
		'dept_desc' => "The Engineering staff are responsible for maintaining all base equipment, as well as the base itself. Power Grid, Sanitation, the Weapons, the Gate, it all needs to be kept in near perfect working order.",
		'dept_order' => 2),
	array(
		'dept_name' => 'Research &amp; Development',
		'dept_desc' => "The Research and Development Division is by far one of the most important for the Stargate Program, without them we still could well be limited to traveling back and forth to Abydos or we wouldn't have the BC-304's to defend Earth with. You know those shiny alien devices locked up in Area 51? They are there because they are giving the awesome R&amp;D guys a run for their money. Just wait 'til they figure out what they do...",
		'dept_order' => 3),
	array(
		'dept_name' => 'Off-World Team',
		'dept_desc' => "An off world team usually consists of 4-8 members, depending on the mission type that the team is assigned. They could be an Exploration group charting the way for others to follow, or it could be a Marine Combat Unit, sent off world to repel the bad guy assault or to rescue a stranded team in the field.",
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

$positions = array(
	array(
		'pos_name' => 'Base Commander',
		'pos_desc' => "The base commander is the highest ranking officer around. He gets the big chair and the small office, along with the proverbial red phone if there's one to be had.",
		'pos_dept' => 1,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Duty Officer',
		'pos_desc' => "The base duty officer is the one usually in charge of directing the off world teams to their destinations, handing out the mission assignments to the best qualified and making sure they have everything they need to complete their mission before they leave. If something happens to an off world team he's responsible for organizing the response.",
		'pos_dept' => 1,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => "Commander's Aide",
		'pos_desc' => "The Commander's Aide is there to assist the duty officer and base commander whenever nessecary, they want a coffee black, they get it, they want the latest mission reports to P5X-732 they were on their desk 10 minutes ago.",
		'pos_dept' => 1,
		'pos_order' => 2,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Stargate Coordinator',
		'pos_desc' => "The gate coordinator is responsible for dialing the Stargate for missions, as well controlling any aspect of the gate that's linked to it, such as an iris or a shield. If there are any computer controlled defenses the gate coordinator deploys them when instructed and is also responsible for MALP or UAV deployment and retrieval.",
		'pos_dept' => 1,
		'pos_order' => 3,
		'pos_open' => 2,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Base Medical Officer',
		'pos_desc' => "The base medical officer sees to the well being of all base personnel, and ensures that all off world teams are capable of doing the missions that they are mandated. The Base MO can also quarantine the facility or just a specific section of there's sufficient reason, and without the Base Commander's permission.",
		'pos_dept' => 2,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Lab Technician',
		'pos_desc' => "Lab techs are famous for running tests, tests and more tests. Technicians set up, operate, and maintain laboratory instruments, monitor experiments, make observations, calculate and record results, and often develop conclusions.",
		'pos_dept' => 2,
		'pos_order' => 1,
		'pos_open' => 8,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Medical Orderly',
		'pos_desc' => "A medical orderly or orderly is a hospital attendant whose job consists of assisting medical and/or nursing staff with various nursing and/or medical interventions. These duties are classified as routine tasks involving no risk for the patient. Orderlies are often utilized in various hospital departments. Orderly duties can range in scope depending on the area of the health care facility they are employed. For that reason, duties can range from assisting in the physical restraint of combative patients, assisting physicians with the application of casts, transporting patients, shaving patients and providing other similar routine personal care to setting up specialized hospital equipment such as bed traction arrays.",
		'pos_dept' => 2,
		'pos_order' => 2,
		'pos_open' => 8,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Nurse',
		'pos_desc' => "A nurse is responsible for the treatment, safety, and recovery of acutely or chronically ill/injured people, health maintenance of the healthy, and treatment of life-threatening emergencies in a wide range of health care settings. Nurses may also be involved in medical and nursing research and perform a wide range of non-clinical functions necessary to the delivery of health care. Nurses also provide care at birth and death.",
		'pos_dept' => 2,
		'pos_order' => 3,
		'pos_open' => 8,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Corps of Engineers Lead',
		'pos_desc' => "The Corp of Engineers lead is responsible for maintaining all base systems, equipment, and of course the plumbing. If something's broken on base, he/she usually knows about it and can assign a person to fix the problem ASAP.",
		'pos_dept' => 3,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Stargate Technician',
		'pos_desc' => "The stargate technician is the one reason that the stargate continues to function so well, constantly monitoring power consumption and looking for any errors that may occur during gate use. The techs are also responsible for maintaining the base computer systems as a whole, and the other mechanical equipment present.",
		'pos_dept' => 3,
		'pos_order' => 1,
		'pos_open' => 4,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Electrical Engineer',
		'pos_desc' => "The gate uses a lot of power, and it uses the ever increasingly sized Naquadah generators that Colonel Carter started way back when, so be careful, besides, someone has to make sure the lights stay on.",
		'pos_dept' => 3,
		'pos_order' => 2,
		'pos_open' => 8,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Robotics Engineer',
		'pos_desc' => "MALPS, UAV's, MAT's, FRED's, if it's unmanned and robotic you know how to break it, find out what you did to break it, and fix it again in a jiffy.",
		'pos_dept' => 3,
		'pos_order' => 3,
		'pos_open' => 8,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Munitions Engineer',
		'pos_desc' => "You know all those firearms and explosives that are stored in the armory? It's your job to make sure it all works the way it's supposed to.",
		'pos_dept' => 3,
		'pos_order' => 4,
		'pos_open' => 8,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Lead R&amp;D Officer',
		'pos_desc' => "Typically a Captain or Major, the Leading R&amp;D Officer is responsible for inspecting new technologies and assessing use within the Stargate Program.",
		'pos_dept' => 4,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Assistant R&amp;D Officer',
		'pos_desc' => "The Assistant R&amp;D Officer is the man to go to when the Lead man (or woman) is off duty, they usually have an extensive engineering background, just not as extensive as their boss. Usually 1st or 2nd Lieutenant (or equivalent).",
		'pos_dept' => 4,
		'pos_order' => 1,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Alien Technologies Specialist',
		'pos_desc' => "The ATS is responsible for maintaining and testing all alien technologies, reverse engineering and analyzing all technology, and also able to perform repairs in the field.",
		'pos_dept' => 4,
		'pos_order' => 2,
		'pos_open' => 8,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Team Commander',
		'pos_desc' => "The team commander is the highest authority in the field and makes all operational and command decisions, team commanders typically select their team from a list of available candidates and are responsible for maintaining that teams readiness and training.",
		'pos_dept' => 5,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Weapons Officer',
		'pos_desc' => "The weapons officer is an expert in almost every single weapon fieldable by the base, and if he's not an expert he at least knows how to use it. This often includes explosives of various kinds as well marksman training. Every team typically has one Weapons Officer, maybe more if the situation calls for it.",
		'pos_dept' => 5,
		'pos_order' => 1,
		'pos_open' => 4,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Cultural Specialist',
		'pos_desc' => "The cultural specialist is the one position on the off world team that is usually filled by an individual not a part of the military. These members typically have aphd in their chosen 'field' and can typically speak a language or few more than their native fluently. They can often be the greatest asset on an exploration mission and during first contact scenarios.",
		'pos_dept' => 5,
		'pos_order' => 2,
		'pos_open' => 4,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Mission Specialist',
		'pos_desc' => "The mission specialist is typically a filler for the team, they need someone who knows the inner workings of a computer system they bring along a computer specialist, if they need to have a cave blasted into then they call upon demo experts. This position is usually filled by a member of the military, and is specific to the duty the team needs performed.",
		'pos_dept' => 5,
		'pos_order' => 3,
		'pos_open' => 4,
		'pos_type' => 'officer'),
);

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

/* End of file install_data_sg1.php */
/* Location: ./application/assets/install/install_data_sg1.php */