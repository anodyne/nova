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

# TODO: should there be some kind of religious department?

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
		'dept_desc' => "",
		'dept_order' => 0),
	array(
		'dept_name' => 'Operations',
		'dept_desc' => "",
		'dept_order' => 1),
	array(
		'dept_name' => 'Engineering',
		'dept_desc' => "",
		'dept_order' => 2),
	array(
		'dept_name' => 'Security &amp; Tactical',
		'dept_desc' => "",
		'dept_order' => 3),
	array(
		'dept_name' => 'Medical',
		'dept_desc' => "",
		'dept_order' => 4),
	array(
		'dept_name' => 'Science',
		'dept_desc' => "",
		'dept_order' => 5),
	array(
		'dept_name' => 'Tactical Forces',
		'dept_desc' => "",
		'dept_order' => 6)
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
);

$positions = array(
	array(
		'pos_name' => 'Commanding Officer',
		'pos_desc' => "A stand alone position. Either an experienced Space Forces Officer or a Militia Officer with a high level of vesala.",
		'pos_dept' => 1,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Deputy Commanding Officer',
		'pos_desc' => "The second highest Officer on board the vessel, an experienced Officer, and does not necessarily have to be a Space Forces Officer.  Responsible for over-seeing a specific group of staff along with the ADCO.",
		'pos_dept' => 1,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Assistant Deputy Commanding Officer',
		'pos_desc' => "The third highest ranking/experienced officer on board the vessel.  Responsible for over-seeing a specific group of staff along with the DCO.",
		'pos_dept' => 1,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	
	array(
		'pos_name' => 'Head of Ship Control',
		'pos_desc' => "The most senior Pilot and Navigator on board the vessel.  An expert in all aspects of flight control and spacial navigation.",
		'pos_dept' => 2,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Deputy Head of Ship Control',
		'pos_desc' => "The second most senior Pilots and Navigators on board the vessel.  An expert in all aspects of flight control and spacial navigation.",
		'pos_dept' => 2,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Assistant Deputy Head of Ship Control',
		'pos_desc' => "An expert in all aspects of flight control and spacial navigation.",
		'pos_dept' => 2,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Pilot',
		'pos_desc' => "An experienced Pilot.",
		'pos_dept' => 2,
		'pos_order' => 3,
		'pos_open' => 4,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Navigator',
		'pos_desc' => "An experienced Navigator.",
		'pos_dept' => 2,
		'pos_order' => 4,
		'pos_open' => 4,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Head of Engineering &amp; Maintenance',
		'pos_desc' => "The most senior Engineer on board the vessel.  An expert in all aspects of vessel systems operations.",
		'pos_dept' => 3,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Deputy Head of Engineering &amp; Maintenance',
		'pos_desc' => "The second most senior Engineer on board the vessel.  An expert in all aspects of vessel systems operations.",
		'pos_dept' => 3,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Assistant Deputy Head of Engineering &amp; Maintenance',
		'pos_desc' => "An expert in all aspects of vessel systems operations.",
		'pos_dept' => 3,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Engineer',
		'pos_desc' => "An experienced Engineer.",
		'pos_dept' => 3,
		'pos_order' => 3,
		'pos_open' => 8,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Head of Communications',
		'pos_desc' => "The most senior Linguist on board the vessel.  An expert in over 20 languages, and in all Communications equipment.",
		'pos_dept' => 4,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Deputy Head of Communications',
		'pos_desc' => "The second most senior Linguist on board the vessel.  An expert in over 10 languages, and in all Communications equipment.",
		'pos_dept' => 4,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Assistant Deputy Head of Communications',
		'pos_desc' => "An expert in over 10 languages and Communications equipment.",
		'pos_dept' => 4,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Communications Officer',
		'pos_desc' => "An experienced linguist with knowledge in Communications equipment.",
		'pos_dept' => 4,
		'pos_order' => 3,
		'pos_open' => 8,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Head of Warfare',
		'pos_desc' => "The most seasoned and experienced weapons and tactical expert aboard the vessel, as well as stratetician, who ensures the safety of the vessel from external forces via usage of weapons.  Also maintains all weapons on board the vessel.",
		'pos_dept' => 5,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Deputy Head of Warfare',
		'pos_desc' => "A seasoned and experienced weapons and tactical expert, as well as stratetician, who ensures the safety of the vessel from external forces via usage of weapons.  Also maintains all weapons on board the vessel.",
		'pos_dept' => 5,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Assistant Deputy Head of Warfare',
		'pos_desc' => "An experienced weapons and tactical expert, as well as stratetician, who ensures the safety of the vessel from external forces via usage of weapons.  Also maintains all weapons on board the vessel.",
		'pos_dept' => 5,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Warfare Officer',
		'pos_desc' => "An experienced weapons and tactical officer.",
		'pos_dept' => 5,
		'pos_order' => 3,
		'pos_open' => 8,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Infantry Commander',
		'pos_desc' => "",
		'pos_dept' => 6,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Infantry Second-in-Command',
		'pos_desc' => "",
		'pos_dept' => 6,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Infantry Third-in-Command',
		'pos_desc' => "",
		'pos_dept' => 6,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Infantry Soldier',
		'pos_desc' => "",
		'pos_dept' => 6,
		'pos_order' => 3,
		'pos_open' => 20,
		'pos_type' => 'officer'),
	
	array(
		'pos_name' => 'Head of Sciences',
		'pos_desc' => "The most senior Scientist on board the vessel.  An expert in several specialist fields of scientific research.",
		'pos_dept' => 7,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Deputy Head of Sciences',
		'pos_desc' => "The second most senior Scientist on board the vessel.  Primarily deals with the day to day running of the Department, allowing the Head of Sciences to carry out their research projects.",
		'pos_dept' => 7,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Assistant Deputy Head of Sciences',
		'pos_desc' => "The third most senior Scientist on board the vessel.  Usually an expert in on specialist field of study, but also an experienced generalist to be able to deal and understand all information they gather.",
		'pos_dept' => 7,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Scientist',
		'pos_desc' => "A Generalist Scientist on board the vessel. They are not yet considered to be an expert in any one particular field of scientific research, but considered well versed in the many fields of scientific research to carry out solo study.",
		'pos_dept' => 7,
		'pos_order' => 3,
		'pos_open' => 5,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Head of Medicine &amp; Surgery',
		'pos_desc' => "The most Senior Doctor on board the vessel, considered to be an expert in the both Medicine and Surgery.",
		'pos_dept' => 8,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Deputy Head of Medicine &amp; Surgery',
		'pos_desc' => "The second most senior Doctor on the vessel.  Experienced in both Medicine and Surgery.",
		'pos_dept' => 8,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Assistant Deputy Head of Medicine &amp; Surgery',
		'pos_desc' => "The third most senior Doctor on the vessel.  Experienced in both Medicine and Surgery.",
		'pos_dept' => 8,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Doctor',
		'pos_desc' => "",
		'pos_dept' => 8,
		'pos_order' => 3,
		'pos_open' => 4,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Medical Orderly',
		'pos_desc' => "They carry out the roles of Nurses and assistants to the Doctors.",
		'pos_dept' => 8,
		'pos_order' => 4,
		'pos_open' => 8,
		'pos_type' => 'enlisted'),
		
	array(
		'pos_name' => 'Political Officer',
		'pos_desc' => "The eyes and ears of the Central Command and Detapa Council on board the vessel, generally it is assumed all Political Officers also serve the Obsidian Order.",
		'pos_dept' => 9,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Political Aide',
		'pos_desc' => "The eyes and ears of the Central Command and Detapa Council on board the vessel that work with the Political Officer. Generally, it is assumed all Political Aides also serve the Obsidian Order.",
		'pos_dept' => 9,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
		
	array(
		'pos_name' => 'Head Jade Officer',
		'pos_desc' => "Ensures all intelligence the vessel gathers is relayed to Central Command, as well as all pertinent information from the Jade Order and Central Command is given to the Commanding Officer.",
		'pos_dept' => 10,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Deputy Head Jade Officer',
		'pos_desc' => "Ensures all intelligence the vessel gathers is relayed to Central Command, as well as all pertinent information from the Jade Order and Central Command is given to the Commanding Officer. Reports to the Head Jade Officer.",
		'pos_dept' => 10,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Head of Logistics',
		'pos_desc' => "",
		'pos_dept' => 11,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Deputy Head of Logistics',
		'pos_desc' => "",
		'pos_dept' => 11,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Assistant Deputy Head of Logistics',
		'pos_desc' => "",
		'pos_dept' => 11,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Logistics Officer',
		'pos_desc' => "",
		'pos_dept' => 11,
		'pos_order' => 3,
		'pos_open' => 8,
		'pos_type' => 'officer')
);

$catalogue_ranks = array(
	array(
		'rankcat_name' => 'Cardassian Ranks',
		'rankcat_location' => 'default',
		'rankcat_credits' => "The rank sets used in Nova were created by Kuro-chan of Kuro-RPG. The ranksets can be found at <a href='http://www.kuro-rpg.net' target='_blank'>Kuro-RPG</a>. Please do not copy or modify the images.",
		'rankcat_default' => 'y',
		'rankcat_url' => 'http://www.kuro-rpg.net/')
);

/* End of file install_data_baj.php */
/* Location: ./application/assets/install/install_data_baj.php */