<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Install Genre - CRD
 *
 * @package		Nova
 * @category	Genre
 * @author		Hasahnaithiau Nghymru
 */
 
$g = 'crd';

$data = array(
	'departments_'. $g 	=> 'depts',
	'ranks_'. $g		=> 'ranks',
	'positions_'. $g	=> 'positions',
	'catalogue_ranks'	=> 'catalogue_ranks',
);

$depts = array(
	array(
		'dept_name' => 'Command',
		'dept_desc' => "All positions in this department are singular.  The Commanding Officer of the vessel is always a member of the Space Forces, unless the vessel serves as the Lead Ship of an Order, then the Commanding Officer can be a member of the Militia. Members of the Command Staff do not hold any other responsibilities on board the vessel.",
		'dept_order' => 0,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Ship Control',
		'dept_desc' => "Also known as a Helm Officer, one must always be present in operations of the vessel, and every vessel has a number of Space Control Officers to allow shift rotations. They plot courses, supervises the computers piloting, corrects any flight deviations and pilots the ship manually when needed.",
		'dept_order' => 1,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Engineering &amp; Maintenance',
		'dept_desc' => "Responsibility of ensuring that ship functions, such as the use of the lateral sensor array, do not interfere with one and another. They must prioritize resource allocations, so that the most critical activities can have every chance of success. If so required, they can curtail shipboard functions if they thinks they will interfere with the ship's current mission or routine operations. responsible for the condition of all systems and equipment on board the ship. They oversee maintenance, repairs and upgrades of all equipment. They control the output and maintain the operational status of the Warp Core. They also responsible for the many repairs teams during crisis situations.",
		'dept_order' => 2,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Communications Control',
		'dept_desc' => "Monitors any and all transmissions aboard the ship, as well as externally. Communications Officers are experienced linguist, proficient in many different languages.",
		'dept_order' => 3,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Warfare',
		'dept_desc' => "They are the vessels gunman and security. They responsible for the ships weapon system, and is also the COs tactical advisor in Star Ship Combat matters. Very often Warfare Officers are also trained in ground combat and small unit tactics. There is much more to Warfare than simply overseeing the weapons console on the bridge. Warfare maintains the weapons systems aboard the ship, maintaining and reloading photons magazines. Tactical planning and current Intelligence analysis (if no Intelligence operatives are aboard) and manning all secure areas of the vessel.",
		'dept_order' => 4,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Militia Infantry',
		'dept_desc' => "It is their duty is to ensure the safety of ship and crew. The Infantry Commander takes it as their personal duty to protect the Commanding Officer on landing parties. They are also responsible for people under arrest and the safety of guests, liked or not. They are also required to take command of any special ground operations.",
		'dept_order' => 5,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Science Staff',
		'dept_desc' => "Responsible for all the scientific data the vessel collects, and the distribution of such data to specific section amongst the staff for study. Scientists are seen with something bordering on contempt within the Cardassian Union, and are seen by the Central Command to serve one purpose; for the benefit of the military.  Members of the Science Staff are not technically members of either the Space Forces or the Militia, but are part of the Military but rather the Military Sciencetific Order, and are seen as seconded to a particular Order/Vessel.  Due to the specialist nature of the department, everyone within the Sciences has carried out their required Military Service, and has elected to continue within the Military and specialized in sciences.  Due to the gender biased within the Cardassian Union, the majority of Scientists appear to be female.",
		'dept_order' => 6,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Medical Staff',
		'dept_desc' => "Responsible for the physical health of the entire crew, but does more than patch up injured crew members. Their function is to ensure that they do not get sick or injured to begin with, and to this end monitors their health and conditioning with regular check ups. Unlike a Starfleet vessel a Cardassian Doctor cannot relieve the vessel's Commander of duty. Besides this they available to provide medical advice to any individual who requests it. As with the Sciences, the Medical Staff are not members of the Space Forces or Militia, but rather are members of the Military Medical Order and are seen as on seconded duty with the particular Order of the vessel on which they serve.",
		'dept_order' => 7,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Political Staff',
		'dept_desc' => "This department is of an oddity of the Cardassian Union.  The entire purpose of this department is to ensure that the vessel and her crew follow the will of the Central Command at all times.  Duty to the state is something that is programmed into the Cardassian psyche, and the Political Staff ensure they follow this programming.  As with the Sciences and Medical Staff members of the Political Staff are neither Space Force nor Militia Officers, but rather are directly answerable to the Central Command. In situations of First Contact or meetings with Alien species, a Political Officer can supersede the vessel's Commanding Officer is s/he believes that the Commanding Officer is not doing what is best for the Union or the Central Command. They are seen as a nasty necessity to life serving the Union.",
		'dept_order' => 8,
		'dept_manifest' => 1),
	array(
		'dept_name' => '5th Order',
		'dept_desc' => "The Fifth Order, also known as the 'Jade Order' (Cairhail Terapha), comprises the Central Command's military intelligence division. Central Command maintains the Fifth Order so it does not have to depend entirely on the Obsidian Order for military intelligence. The Jade Order is far smaller than the Obsidian Order, and has a fierce rivalry with its larger 'civilian' competitor. As with the above departments, the Officers of the Jade Order are not considered Space Forces or Militia, but are rather on seconded duty to the particular order of the vessel on which they serve.",
		'dept_order' => 9,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Logistics',
		'dept_desc' => "The logistics department keeps track of all matters coming in and off the vessel, also when carrying out private freight the Logistics Officer along with the Commanding Officer takes a percentage of any profit for doing so.",
		'dept_order' => 10,
		'dept_manifest' => 1)
);

$ranks= array(
	array(
		'rank_name' => 'Legate (3rd Order)',
		'rank_short_name' => 'LEG',
		'rank_image' => 'a4',
		'rank_order' => 0,
		'rank_class' => 1),
	array(
		'rank_name' => 'Legate (2nd Order)',
		'rank_short_name' => 'LEG',
		'rank_image' => 'a3',
		'rank_order' => 1,
		'rank_class' => 1),
	array(
		'rank_name' => 'Legate (1st Order)',
		'rank_short_name' => 'LEG',
		'rank_image' => 'a2',
		'rank_order' => 2,
		'rank_class' => 1),
	array(
		'rank_name' => 'Jagual',
		'rank_short_name' => 'JAG',
		'rank_image' => 'a1',
		'rank_order' => 3,
		'rank_class' => 1),
	array(
		'rank_name' => 'Gul',
		'rank_short_name' => 'GUL',
		'rank_image' => 'o6',
		'rank_order' => 4,
		'rank_class' => 1),
	array(
		'rank_name' => 'Glinn',
		'rank_short_name' => 'GLI',
		'rank_image' => 'o5',
		'rank_order' => 5,
		'rank_class' => 1),
	array(
		'rank_name' => 'Kel',
		'rank_short_name' => 'KEL',
		'rank_image' => 'o4',
		'rank_order' => 6,
		'rank_class' => 1),
	array(
		'rank_name' => 'Gil',
		'rank_short_name' => 'GIL',
		'rank_image' => 'o3',
		'rank_order' => 7,
		'rank_class' => 1),
	array(
		'rank_name' => 'Dalin',
		'rank_short_name' => 'DAL',
		'rank_image' => 'o2',
		'rank_order' => 8,
		'rank_class' => 1),
	array(
		'rank_name' => 'Riyak',
		'rank_short_name' => 'RIY',
		'rank_image' => 'o1',
		'rank_order' => 9,
		'rank_class' => 1),
	array(
		'rank_name' => 'Ragoc',
		'rank_short_name' => 'RAG',
		'rank_image' => 'e3',
		'rank_order' => 10,
		'rank_class' => 1),
	array(
		'rank_name' => 'Gor',
		'rank_short_name' => 'GOR',
		'rank_image' => 'e2',
		'rank_order' => 11,
		'rank_class' => 1),
	array(
		'rank_name' => 'Garhec',
		'rank_short_name' => 'GAR',
		'rank_image' => 'e1',
		'rank_order' => 12,
		'rank_class' => 1),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'blank',
		'rank_order' => 13,
		'rank_class' => 1)
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
		'pos_desc' => "The Infantry Commander is responsible for the infantry forces on the ship/base. They oversee any and all matters related to their units, including tactical strategy in concert with the Commanding Officer. Works with other members of his/her team to ensure the infantry forces are ready to be deployed at a moment's notice. Reports to the Commanding Officer.",
		'pos_dept' => 6,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Infantry Second-in-Command',
		'pos_desc' => "Responsible for overseeing the infantry forces on a ship/base. Works in tandem with the Infantry Commander to ensure their forces are ready to deployed at a moment's notice. Reports to the Infantry Commander.",
		'pos_dept' => 6,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Infantry Third-in-Command',
		'pos_desc' => "Responsible for overseeing the enlisted division of a ship/base's infantry complement. Reports to the Infantry Commander.",
		'pos_dept' => 6,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Infantry Soldier',
		'pos_desc' => "The lifeblood of the Infantry, soldiers make up the units stationed on ships and bases. Reports to the Infantry Commander.",
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
		'pos_desc' => "An experienced doctor with expertise in either Medicine or Surgery. In most cases, unlike the senior officers, they will not be experienced in all medical matters.",
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
		'pos_desc' => "The Head of Logistics is responsible for keeping track of all matters coming in and off the vessel. A nuanced position, the Head of Logistics also coordinates carrying out private freight, a task which they take a percentage of profits (along with the Commanding Officer) for doing so.",
		'pos_dept' => 11,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Deputy Head of Logistics',
		'pos_desc' => "The Deputy Head of Logistics is responsible for helping to keep track of all matters coming in and off the vessel. Reports to the Head of Logistics.",
		'pos_dept' => 11,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Assistant Deputy Head of Logistics',
		'pos_desc' => "Assists the Deputy Head of Logistics for tracking all matters coming in and off the vessel.",
		'pos_dept' => 11,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Logistics Officer',
		'pos_desc' => "Tracks all matters coming in and off the vessel along with the other members of the Logistics department.",
		'pos_dept' => 11,
		'pos_order' => 3,
		'pos_open' => 8,
		'pos_type' => 'officer')
);

$catalogue_ranks = array(
	array(
		'rankcat_name' => 'Duty Uniform',
		'rankcat_location' => 'default',
		'rankcat_credits' => "The rank sets used in Nova were created by Kuro-chan of Kuro-RPG. The ranksets can be found at <a href='http://www.kuro-rpg.net' target='_blank'>Kuro-RPG</a>. Please do not copy or modify the images.",
		'rankcat_default' => 'y',
		'rankcat_url' => 'http://www.kuro-rpg.net/',
		'rankcat_genre' => $g)
);
