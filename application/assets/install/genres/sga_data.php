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
);

$depts = array(
	array(
		'dept_name' => 'Command',
		'dept_desc' => "The Command Department consists of the Commander and the Executive Officer. The Commander is ultimately responsible for the safety and welfare of the SG Team. S/he has final authority on all decisions regarding the ship and her mission. The Executive officer or XO is the commander's immediate subordinate, and is also his/her successor should the need arise.",
		'dept_order' => 0),
	array(
		'dept_name' => 'Archeology',
		'dept_desc' => "The Branch of anthropology studies people and their cultures on off world planets and catalogs them back on base for further study of the culture and its people.  Civilans play an important role in this department because Armed forces usually don't have jobs in Archeology.",
		'dept_order' => 1),
	array(
		'dept_name' => 'Linguistics',
		'dept_desc' => "Linguists are the people that can communicate in different languages with other cultures.  Both Military and Civilians are employed to do this.",
		'dept_order' => 2),
	array(
		'dept_name' => 'Engineering',
		'dept_desc' => "When something needs fixing these are the people men and women, military and civilian that get called.   Engineers are responsible for the fixing computer systems, to the stargate, and even sending in UAVs & MALPs.",
		'dept_order' => 3),
	array(
		'dept_name' => 'Science',
		'dept_desc' => "The Science department is always making discoveries on survival, coming up with new ideas on how to help the team, and cataloging information on current off world discoveries and events.",
		'dept_order' => 4),
	array(
		'dept_name' => 'Medical',
		'dept_desc' => "When a person is either hurt or sick the medical department will always be there.  These skilled men and women are doctors and medics either staying in the infirmary or going out in the fields with teams.",
		'dept_order' => 5),
	array(
		'dept_name' => 'Diplomatic Liaisons',
		'dept_desc' => "Representing Earth and Humans alike the diplomat Liaisons stay on base or travel out with teams making sure the human race is not seen in a negative right.",
		'dept_order' => 6),
	array(
		'dept_name' => 'Jumper Squadron',
		'dept_desc' => "The Jumper Squadron is a fast travel to close place or can fly through the gate and be a means of travel for the team.",
		'dept_order' => 7),
	array(
		'dept_name' => 'Military',
		'dept_desc' => "Your Military personnel in an SG Team are trained combat warriors from all branch all over the world.  In some times things get sticky and military is there to back it up with expert combat knowledge and firepower.",
		'dept_order' => 8),
	array(
		'dept_name' => 'Alpha Team',
		'dept_desc' => "The Alpha Team of Atlantis.  Capable of carrying out missions and orders directed to them.",
		'dept_order' => 9),
	array(
		'dept_name' => 'Bravo Team',
		'dept_desc' => "The Bravo Team of Atlantis.  Capable of carrying out missions and orders directed to them.",
		'dept_order' => 10)
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
		'pos_name' => 'Commanding Officer',
		'pos_desc' => "Ultimately responsible for the ship and crew, the Commanding Officer is the most senior officer aboard a vessel. S/he is responsible for carrying out the orders of the Generals above their position.",
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
		'pos_name' => 'Chief Archaeologist',
		'pos_desc' => "Studies people and cultures of off world planets.  Shares and discusses the human race with other cultures off world. In addition, they are in charge of the department and report to the Executive Officer. Is a member of the Senior Staff.",
		'pos_dept' => 2,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Assistant Chief Archaeologist',
		'pos_desc' => "Studies people and cultures of off world planets.  Shares and discusses the human race with other cultures off world. Also assists the Department head in daily operations.  If the Chief of the department is for some reason not able to perform his/her duties the Assistant Chief steps forwards as Acting Chief until the Chief returns.",
		'pos_dept' => 2,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Archaeologist',
		'pos_desc' => "Studies people and cultures of off world planets.  Shares and discusses the human race with other cultures off world.",
		'pos_dept' => 2,
		'pos_order' => 2,
		'pos_open' => 5,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Chief of Linguistics',
		'pos_desc' => "A person who speaks more than one language.  Most linguists specialize in languages.  The Linguist some times does more than English and one other languages. In addition, they are in charge of the department and reports to the Executive Officer.  Is a member of the Senior Staff.",
		'pos_dept' => 3,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Assistant Chief of Linguistics',
		'pos_desc' => "A person who speaks more than one language.  Most linguists specialize in languages.  The Linguist some times does more than English and one other languages. Also assists the Department head in daily operations.  If the Chief of the department is for some reason not able to perform his/her duties the Assistant Chief steps forwards as Acting Chief until the Chief returns.",
		'pos_dept' => 3,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Linguist',
		'pos_desc' => "A person who speaks more than one language.  Most linguists specialize in languages.  The Linguist some times does more than English and one other languages.",
		'pos_dept' => 3,
		'pos_order' => 2,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	
	array(
		'pos_name' => 'Chief of Engineering',
		'pos_desc' => "In charge of the department and reports to the Executive Officer.  Is a member of the Senior Staff.",
		'pos_dept' => 4,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Assistant Chief of Engineering',
		'pos_desc' => "Assists the Department head in daily operations.  If the Chief of the department is for some reason not able to perform his/her duties the Assistant Chief steps forwards as Acting Chief until the Chiefs return.",
		'pos_dept' => 4,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Chief of the Deck',
		'pos_desc' => "The Chief of the deck is in charge of the deck crew.  He reports to the Chief of Engineering.",
		'pos_dept' => 4,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Engineering Specialist',
		'pos_desc' => "",
		'pos_dept' => 4,
		'pos_order' => 3,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Deck Crew',
		'pos_desc' => "A Deck crew member is your grease monkey.  They maintain, test, and check the Jumpers.",
		'pos_dept' => 4,
		'pos_order' => 4,
		'pos_open' => 5,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Stargate Specialist',
		'pos_desc' => "A Stargate Specialist knows how to maintain and test the Stargate.  If the Stargate is not working they know the best means of trouble shooting.",
		'pos_dept' => 4,
		'pos_order' => 5,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'DHD Specialist',
		'pos_desc' => "The Dialer for the Stargate, the DHD is an ancient system that the humans rebuilt and made current to computers.  The DHD specialist knows how to troubleshoot and dial the DHD.",
		'pos_dept' => 4,
		'pos_order' => 6,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'UAV/MALP Specialist',
		'pos_desc' => "Before Stargate will send a team through they will send in a UAV (Unmanned Aerial Vehicle) or a MALP (Mobile Analytic Laboratory Probe) a wheeled robot.  The Specialist sends the device in and collects data and Intelligence for the team to use.",
		'pos_dept' => 4,
		'pos_order' => 7,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Communications Specialist',
		'pos_desc' => "Responsible for all communication equipment the Communications Specialist can travel with the team or stay on base.  They report to the front lines of the field and can send information to the team and vise versa.",
		'pos_dept' => 4,
		'pos_order' => 8,
		'pos_open' => 5,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Chief of Science',
		'pos_desc' => "In charge of the department and reports to the Executive Officer.  Is a member of the Senior Staff.",
		'pos_dept' => 5,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Assistant Chief of Science',
		'pos_desc' => "Assists the Department head in daily operations.  If the Chief of the department is for some reason not able to perform his/her duties the Assistant Chief steps forwards as Acting Chief until the Chief returns.",
		'pos_dept' => 5,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Botanist',
		'pos_desc' => "Specializing in the study of plants the Botanist catalogs data of off world plants as with studies plants.",
		'pos_dept' => 5,
		'pos_order' => 2,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Geologist',
		'pos_desc' => "Studies the liquid and matter that makes up off world planets.",
		'pos_dept' => 5,
		'pos_order' => 3,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Astrophysicist',
		'pos_desc' => "They look up towards the stars. These specialist look at start maps and charts and try to figure out new places to travel.  They also keep the catalog up to date on past visited planets.",
		'pos_dept' => 5,
		'pos_order' => 4,
		'pos_open' => 5,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Chief of Medical',
		'pos_desc' => "In charge of the department and reports to the Executive Officer.  Is a member of the Senior Staff.",
		'pos_dept' => 6,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Assistant Chief of Medical',
		'pos_desc' => "Assists the Department head in daily operations.  If the Chief of the department is for some reason not able to perform his/her duties the Assistant Chief steps forwards as Acting Chief until the Chief returns.",
		'pos_dept' => 6,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Physician',
		'pos_desc' => "The Physician stays on the base in the infirmary and assists the Chief of Medical and the Assistant Chief.",
		'pos_dept' => 6,
		'pos_order' => 2,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Field Medic',
		'pos_desc' => "Travels out into the field with the Stargate Teams.  The Field Medic is the expert in Emergency Medicine.",
		'pos_dept' => 6,
		'pos_order' => 3,
		'pos_open' => 5,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Chief of Diplomatics',
		'pos_desc' => "In charge of the department and reports to the Executive Officer.  Is a member of the Senior Staff.",
		'pos_dept' => 7,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Assistant Chief of Diplomatics',
		'pos_desc' => "Assists the Department head in daily operations.  If the Chief of the department is for some reason not able to perform his/her duties the Assistant Chief steps forwards as Acting Chief until the Chief returns.",
		'pos_dept' => 7,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Base Diplomatic Liaison',
		'pos_desc' => "The Base Diplomatic Liaison is a consultant for cultures coming to Atlantis. Base Diplomatic Liaisons consult with the American and other foreign countries to Earth.",
		'pos_dept' => 7,
		'pos_order' => 2,
		'pos_open' => 5,
		'pos_type' => 'other'),
	array(
		'pos_name' => 'Off World Diplomatic Liaison',
		'pos_desc' => "Representing Earth and Humans the Off world Diplomatic Liaison represents the team in a positive light.",
		'pos_dept' => 7,
		'pos_order' => 3,
		'pos_open' => 5,
		'pos_type' => 'other'),
		
	array(
		'pos_name' => 'Squadron Leader',
		'pos_desc' => "Is leader of the Jumper Squadron Air lift team. Reports to the Executive Officer. Is a member of the Senior Staff.",
		'pos_dept' => 8,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Squadron Pilot',
		'pos_desc' => "A member of the Jumper Squadron. The Jumper pilot reports the Squadron Leader.",
		'pos_dept' => 8,
		'pos_order' => 1,
		'pos_open' => 6,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Chief of Military',
		'pos_desc' => "In charge of the department and reports to the Executive Officer. Is a member of the Senior Staff.",
		'pos_dept' => 9,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Assistant Chief of Military',
		'pos_desc' => "Assists the Department head in daily operations. If the Chief of the department is for some reason not able to perform his/her duties the Assistant Chief steps forwards as Acting Chief until the Chiefs return.",
		'pos_dept' => 9,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Weapons Specialist',
		'pos_desc' => "The Weapons Specialist is the master of all weapons, US and foreign, and off world. They train in small and heavy weapons and assist others in weapons training.",
		'pos_dept' => 9,
		'pos_order' => 2,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Engineering Specialist',
		'pos_desc' => "A very crucial member of the team is the Engineering Specialist is your demolitions man. Able to do land and underwater demolitions and navigation as with fortification and sabotage.",
		'pos_dept' => 9,
		'pos_order' => 3,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Infiltration Specialist',
		'pos_desc' => "When you need to get in undetected the Infiltration can get him/herself and the team in. Sometimes the Infiltration specialist works alone and done specialized mission. While they can get in they can get out as well.  Expert in rescue operations as well s/he can get in and out of any area.",
		'pos_dept' => 9,
		'pos_order' => 4,
		'pos_open' => 5,
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

/* End of file install_data_sga.php */
/* Location: ./application/assets/install/install_data_sga.php */