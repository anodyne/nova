<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Install Genre - ROM
 *
 * @package		Nova
 * @category	Genre
 * @author		Hasahnaithiau Nghymru
 */
 
$g = 'rom';

$data = array(
	'departments_'. $g 	=> 'depts',
	'ranks_'. $g		=> 'ranks',
	'positions_'. $g	=> 'positions',
	'catalogue_ranks'	=> 'catalogue_ranks'
);

$depts = array(
	array(
		'dept_name' => 'Command',
		'dept_desc' => "As on most space-faring vessels the Command Department is made up of those officers deemed to be in the day-to-day control of the Warbird.  The Apart from the Commanding Officer, other members of the Command Staff also serve in other faculties/ departments.",
		'dept_order' => 0,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Scientific Research',
		'dept_desc' => "Responsible for all the scientific data the warbird collects, and the distribution of such data to specific section within the department for analysis. They are also responsible with providing the ship's captain with scientific information needed for command decisions.",
		'dept_order' => 1,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Medical Sciences',
		'dept_desc' => "Responsible for the physical health of the entire crew, but does more than patch up injured crew members. Their function is to ensure that they do not get sick or injured to begin with, and to this end monitors their health and conditioning with regular check ups. If necessary, the Leader of Medical Sciences can remove anyone from duty, excluding the Commander. Besides this they available to provide medical advice to any individual who requests it. Additionally the Seniors of the 3 bracnhes of Medical Sciences as well as the Leader of the Department are also responsible for all aspect of the medical deck, such as the Medical labs, Surgical suites, Psychiatric treatment areas.",
		'dept_order' => 2,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Research &amp; Development',
		'dept_desc' => "This department is of an oddity only found within the Romulan Star Empire.  The entire purpose of this department is to take alien technology (e.g. Starfleet) and backwards engineer it and to create something similiar to the original but allowing it to be compatible with other Romulan Technologies.",
		'dept_order' => 3,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Flight Control',
		'dept_desc' => "A Flight Controller must always be present on the bridge of a starship, and every vessel has a number of Flight Control Officers to allow shift rotations. They plot courses, supervises the computers piloting, corrects any flight deviations and pilots the ship manually when needed.",
		'dept_order' => 4,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Warbird Control',
		'dept_desc' => "Responsibility of ensuring that ship functions, such as the use of the lateral sensor array, do not interfere with one and another. They must prioritize resource allocations, so that the most critical activities can have every chance of success. If so required, they can curtail shipboard functions if they thinks they will interfere with the ship's current mission or routine operations.",
		'dept_order' => 5,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Singularity Control',
		'dept_desc' => "Responsible for the condition of all systems and equipment on board the Warbird. They oversee maintenance, repairs and upgrades of all equipment. They control the output and maintain the operational status of the Singularity Drive. They also responsible for the many repairs teams during crisis situations.",
		'dept_order' => 6,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Cloaking Control',
		'dept_desc' => "Responsible for the smooth operation of the Cloaking Device and other related systems, unlike other Control departments, Cloaking Control is a very small department, with members usually having served for many tours within an Singularity Control Department, and then undergoing specialist Cloaking Technology Training Programmes. The department only contains 3 staff members.",
		'dept_order' => 7,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Communications Control',
		'dept_desc' => "Monitors any and all transmissions aboard the warbird, as well as externally. Communications Officers are experienced linguist, proficient in many different languages.",
		'dept_order' => 8,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Weapons Control',
		'dept_desc' => "They are the vessels gunman.They responsible for the ships weapon system, and is also the COs tactical advisor in Star Ship Combat matters. Very often Weapons Officers are also trained in ground combat and small unit tactics. There is much more to Weapons Control than simply overseeing the weapons console on the bridge. Weapons Control maintains the weapons systems aboard the warbird, maintaining and reloading photons magazines. Tactical planning and current Intelligence analysis (if no Intelligence operatives are aboard) is also overseen by the tactical department.",
		'dept_order' => 9,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Tal Diann',
		'dept_desc' => "Responsible for collected and collating all information that they deem appropriate for delivery to the Command Staff.  Unlike most departments the Tal Diann are considered a seperate force within the Galae in the same manner as the Tal Shi'ar.  They are often at odds with the Tal Shi'ar Agent on-board the warbird.",
		'dept_order' => 10,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Reman Commando Corps',
		'dept_desc' => "It is their duty is to ensure the safety of ship and crew. The Commando Commander takes it as their personal duty to protect the Commanding Officer on landing parties. They are also responsible for people under arrest and the safety of guests, liked or not. They are also required to take command of any special ground operations. The Reman Commando Corps is the only branch of the Galae to have an enlisted service.  The RCC is always controlled by Galae Officers, but the rank and file is made up of Remans who are considered too inferior to hold a commissioned rank.",
		'dept_order' => 11,
		'dept_manifest' => 1)
);

$ranks= array(
	array(
		'rank_name' => 'Admiral',
		'rank_short_name' => 'ADM',
		'rank_image' => 's-o8',
		'rank_order' => 0,
		'rank_class' => 1),
	array(
		'rank_name' => 'Commodore',
		'rank_short_name' => 'COMO',
		'rank_image' => 's-o7',
		'rank_order' => 1,
		'rank_class' => 1),
	array(
		'rank_name' => 'Commander',
		'rank_short_name' => 'CMDR',
		'rank_image' => 's-o6',
		'rank_order' => 2,
		'rank_class' => 1),
	array(
		'rank_name' => 'Sub-Commander',
		'rank_short_name' => 'SCMDR',
		'rank_image' => 's-o5',
		'rank_order' => 3,
		'rank_class' => 1),
	array(
		'rank_name' => 'Centurion',
		'rank_short_name' => 'CENT',
		'rank_image' => 's-o4',
		'rank_order' => 4,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant',
		'rank_short_name' => 'LT',
		'rank_image' => 's-o3',
		'rank_order' => 5,
		'rank_class' => 1),
	array(
		'rank_name' => 'Sub-Lieutenant',
		'rank_short_name' => 'SLT',
		'rank_image' => 's-o2',
		'rank_order' => 6,
		'rank_class' => 1),
	array(
		'rank_name' => 'Uhlan',
		'rank_short_name' => 'UHL',
		'rank_image' => 's-o1',
		'rank_order' => 7,
		'rank_class' => 1),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'blank',
		'rank_order' => 8,
		'rank_class' => 1),
	array(
		'rank_name' => 'General',
		'rank_short_name' => 'GEN',
		'rank_image' => 'g-o8',
		'rank_order' => 9,
		'rank_class' => 2),
	array(
		'rank_name' => 'Sub-General',
		'rank_short_name' => 'SGEN',
		'rank_image' => 'g-o7',
		'rank_order' => 10,
		'rank_class' => 2),
	array(
		'rank_name' => 'Colonel',
		'rank_short_name' => 'COL',
		'rank_image' => 'g-o6',
		'rank_order' => 11,
		'rank_class' => 2),
	array(
		'rank_name' => 'Sub-Colonel',
		'rank_short_name' => 'SCOL',
		'rank_image' => 'g-o5',
		'rank_order' => 12,
		'rank_class' => 2),
	array(
		'rank_name' => 'Major',
		'rank_short_name' => 'MAJ',
		'rank_image' => 'g-o4',
		'rank_order' => 13,
		'rank_class' => 2),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'g-o3',
		'rank_order' => 14,
		'rank_class' => 2),
	array(
		'rank_name' => 'Lieutenant',
		'rank_short_name' => 'LT',
		'rank_image' => 'g-o2',
		'rank_order' => 15,
		'rank_class' => 2),
	array(
		'rank_name' => 'Uhlan',
		'rank_short_name' => 'UHL',
		'rank_image' => 'g-o1',
		'rank_order' => 16,
		'rank_class' => 2),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'blank',
		'rank_order' => 17,
		'rank_class' => 2)
);

$positions = array(
	array(
		'pos_name' => 'Commander',
		'pos_desc' => "Seniormost officer on a warbird and responsible for everything that happens. The Commander receives their orders straight from the Star Empire leadership.",
		'pos_dept' => 1,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Sub-Commander',
		'pos_desc' => "Second seniormost officer on a warbird and usually hand-selected by the Commander. The Sub-Commander is responsible for helping to run the warbird and carry out the orders of the Commander.",
		'pos_dept' => 1,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Sciences Head',
		'pos_desc' => "A position held by the most senior Sciences Department Leader, included in Command Staff if not held by the First Officer.",
		'pos_dept' => 1,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Control Head',
		'pos_desc' => "A position held by the most senior Support Department Leader, included in Command Staff if not held by the First Officer.",
		'pos_dept' => 1,
		'pos_order' => 3,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Warfare Head',
		'pos_desc' => "A position held by the most senior Warfare Department Leader, included in Command Staff if not held by the First Officer.",
		'pos_dept' => 1,
		'pos_order' => 4,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => "Protocol Officer/Tal Prai'ex Representative",
		'pos_desc' => "A stand alone position, this person is usually a member of the Tal Prai'ex and ensures that all actions carried out by the Command Staff are in-line with the policies of the Praetorate.  Generally seen as the Praetor's spy on a Warbird.",
		'pos_dept' => 1,
		'pos_order' => 5,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => "Tal Shi'ar Representative",
		'pos_desc' => "If the Protocol Officer is the Praetor's eyes and ears on a Warbird, the Tal Shi'ar Representative is his/her nemesis, as they act as the eyes and ears of the Tal Shi'ar on the vessel.",
		'pos_dept' => 1,
		'pos_order' => 6,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	
	array(
		'pos_name' => 'Leader of Science',
		'pos_desc' => "The most senior Scientist on board the warbird.  An expert in several specialist fields of scientific research, but also an experienced generalist to be able to deal and understand all information they gather.",
		'pos_dept' => 2,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Senior Scientist',
		'pos_desc' => "The second two most senior Scientist on board the warbird.  An expert in two specialist fields of scientific research, but also an experienced generalist to be able to deal and understand all information they gather.",
		'pos_dept' => 2,
		'pos_order' => 1,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Specialist Scientist',
		'pos_desc' => "A Specialist Scientist on board the warbird.  An expert in a specialist field of scientific research, but also an experienced generalist to be able to deal and understand all information they gather.",
		'pos_dept' => 2,
		'pos_order' => 2,
		'pos_open' => 3,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'General Scientist',
		'pos_desc' => "A Generalist Scientist on board the warbird. They are not yet considered to be an expert in a particular field of scientific research, but considered well versed in the many fields of scienctific research to carry out solo study.",
		'pos_dept' => 2,
		'pos_order' => 3,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Lower Scientist',
		'pos_desc' => "A Lower Generalist Scientist on board the warbird. They are not yet considered to be an expert in a particular field of scientific research, but considered versed in the many fields of scienctific research to carry out supervised study.",
		'pos_dept' => 2,
		'pos_order' => 4,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Research Aide',
		'pos_desc' => "Generally an officer carrying out Military Service, they act as a general dogs-body to other scientists and aide them in their research programmes.",
		'pos_dept' => 2,
		'pos_order' => 5,
		'pos_open' => 10,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Leader of Medical Sciences',
		'pos_desc' => "The most Senior Doctor on board the Warbird, considered to be an expert in the 3 main branches of Medicial Sciences, Medicine, Surgery and Psychiatry.  It is to him/her that the Senior Surgeon, Senior Physician and Senior Psychiatrist all report.",
		'pos_dept' => 3,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Senior of Surgery',
		'pos_desc' => "The most Senior Surgeon on board the Warbird (save for the Leader of Medical Sciences), considered to be an expert in Surgery.  It is to him/her that the Specialist (Surgical) Doctors report.",
		'pos_dept' => 3,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Senior of Medicine',
		'pos_desc' => "The most Senior Physician on board the Warbird (save for the Leader of Medical Sciences), considered to be an expert in Medicine.  It is to him/her that the Specialist (Medical) Doctors report.",
		'pos_dept' => 3,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Senior of Psychiatry',
		'pos_desc' => "The most Senior Psychiatrist on board the Warbird (save for the Leader of Medical Sciences), considered to be an expert in Psychiatry.  It is to him/her that the Specialist (Psychiaric) Doctors report.",
		'pos_dept' => 3,
		'pos_order' => 3,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Specialist Doctor',
		'pos_desc' => "Doctors whom Specialise in one of the three main branches of Medical Sciences, and report to the Senior of their Branch.",
		'pos_dept' => 3,
		'pos_order' => 5,
		'pos_open' => 6,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'General Doctor',
		'pos_desc' => "Unlike a Specialist, these Doctors are rather seen as jack of all trades, and can deal with most medical situations, but may refer to a Specialist",
		'pos_dept' => 3,
		'pos_order' => 6,
		'pos_open' => 6,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Medical Aide',
		'pos_desc' => "Generally an officer carrying out Military Service, they act as a general dogs-body for Doctors to assist them in medical treatments etc.",
		'pos_dept' => 3,
		'pos_order' => 7,
		'pos_open' => 10,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Leader of R&amp;D',
		'pos_desc' => "This person is responsible for the gathering of all alien technologies and reverse engineering them to be viable for use with other Romulan Technologies.  Also works with Ship and Singularity Control for intergrating such technologies into the Warbird.",
		'pos_dept' => 4,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Senior Developer',
		'pos_desc' => "This person acts as a deputy to the Leader of R&D, assisting him/her in reverse engineering technology for use within the Romulan Star Empire.",
		'pos_dept' => 4,
		'pos_order' => 1,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Developer',
		'pos_desc' => "This person assists in reverse engineering technology for use within the Romulan Star Empire.",
		'pos_dept' => 4,
		'pos_order' => 2,
		'pos_open' => 4,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Researcher',
		'pos_desc' => "This person carries out research into technologies and acts as collector of alien Technologies for use in reverse engineering.",
		'pos_dept' => 4,
		'pos_order' => 3,
		'pos_open' => 4,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Research Aide',
		'pos_desc' => "Generally an officer carrying out Military Service, they act as a general dogs-body for Developers and Researchers.",
		'pos_dept' => 4,
		'pos_order' => 4,
		'pos_open' => 10,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Leader of Flight Control',
		'pos_desc' => "The most senior Pilot and Navigator on board the warbird.  An expert all aspects of flight control and spacial navigation.",
		'pos_dept' => 5,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Senior Controller',
		'pos_desc' => "The second two most senior Pilots and Navigators on board the warbird.  An expert all aspects of flight control and spacial navigation.",
		'pos_dept' => 5,
		'pos_order' => 1,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Specialist Controller',
		'pos_desc' => "An expert all aspects of flight control and spacial navigation.",
		'pos_dept' => 5,
		'pos_order' => 2,
		'pos_open' => 4,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'General Controller',
		'pos_desc' => "An experienced Pilot and/or Navigator.",
		'pos_dept' => 5,
		'pos_order' => 3,
		'pos_open' => 8,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Lower Controller',
		'pos_desc' => "A junior Pilot and/or Navigator.",
		'pos_dept' => 5,
		'pos_order' => 4,
		'pos_open' => 8,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Control Aide',
		'pos_desc' => "enerally an officer carrying out Military Service, they act as a general dogs-body for the Flight Control Department.",
		'pos_dept' => 5,
		'pos_order' => 5,
		'pos_open' => 10,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Leader of Warbird Control',
		'pos_desc' => "The most senior Techie on board the warbird.  An expert in all aspects of warbird systems operations.",
		'pos_dept' => 6,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Senior Controller',
		'pos_desc' => "The second two most senior Techies on board the warbird.  An expert in all aspects of warbird systems operations.",
		'pos_dept' => 6,
		'pos_order' => 1,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Specialist Controller',
		'pos_desc' => "An expert all aspects of warbird systems operations.",
		'pos_dept' => 6,
		'pos_order' => 2,
		'pos_open' => 4,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'General Controller',
		'pos_desc' => "An experienced Techie.",
		'pos_dept' => 6,
		'pos_order' => 3,
		'pos_open' => 8,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Lower Controller',
		'pos_desc' => "A junior techie.",
		'pos_dept' => 6,
		'pos_order' => 4,
		'pos_open' => 8,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Control Aide',
		'pos_desc' => "Generally an officer carrying out Military Service, they act as a general dogs-body for the Warbird Control Department.",
		'pos_dept' => 6,
		'pos_order' => 5,
		'pos_open' => 10,
		'pos_type' => 'officer'),
	
	array(
		'pos_name' => 'Leader of Singularity Control',
		'pos_desc' => "The most senior Engineer on board the warbird.  An expert in all aspects of Warbird Engineering.",
		'pos_dept' => 7,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Senior Controller',
		'pos_desc' => "The second two most senior Engineers on board the warbird.  An expert in all aspects of Warbird Engineering.",
		'pos_dept' => 7,
		'pos_order' => 1,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Specialist Controller',
		'pos_desc' => "An expert all aspects of warbird engineering.",
		'pos_dept' => 7,
		'pos_order' => 2,
		'pos_open' => 4,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'General Controller',
		'pos_desc' => "An experienced engineer.",
		'pos_dept' => 7,
		'pos_order' => 3,
		'pos_open' => 8,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Lower Controller',
		'pos_desc' => "A junior engineer.",
		'pos_dept' => 7,
		'pos_order' => 4,
		'pos_open' => 8,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Control Aide',
		'pos_desc' => "Generally an officer carrying out Military Service, they act as a general dogs-body for the Singularity Control Department.",
		'pos_dept' => 7,
		'pos_order' => 5,
		'pos_open' => 10,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Leader of Cloaking Control',
		'pos_desc' => "A seasoned and experienced Engineer, who has proven him or herself an expert in all brances of Engineering, and has served as a Leader of Singularity Control or Warbird Control and is loyal enough to the RSE to warrant his or her being trained in the classified Cloaking Device.",
		'pos_dept' => 8,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Senior Controller',
		'pos_desc' => "A seasoned and experienced Engineer although less so than the Leader of Singularity Control, who has proven him or herself an expert in all brances of Engineering, and has served as a Leader of Singularity Control or Warbird Control and is loyal enough to the RSE to warrant his or her being trained in the classified Cloaking Device.",
		'pos_dept' => 8,
		'pos_order' => 1,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Specialist Controller',
		'pos_desc' => "A seasoned and experienced Engineer although less so than the Senior Controller, who has proven him or herself an expert in all brances of Engineering, and has served as a Leader of Singularity Control or Warbird Control and is loyal enough to the RSE to warrant his or her being trained in the classified Cloaking Device.",
		'pos_dept' => 8,
		'pos_order' => 2,
		'pos_open' => 4,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Leader of Communications Control',
		'pos_desc' => "The most senior Linguists on board the warbird.  An expert in over 20 languages, and in all Communications equipment.",
		'pos_dept' => 9,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Senior Controller',
		'pos_desc' => "The second two most senior Linguists on board the warbird.  An expert in over 10 languages, and in all Communications equipment.",
		'pos_dept' => 9,
		'pos_order' => 1,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Specialist Controller',
		'pos_desc' => "An expert in over 10 languages and Communications equipment.",
		'pos_dept' => 9,
		'pos_order' => 2,
		'pos_open' => 4,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'General Controller',
		'pos_desc' => "An experienced linguist.",
		'pos_dept' => 9,
		'pos_order' => 3,
		'pos_open' => 8,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Lower Controller',
		'pos_desc' => "An junior linguist.",
		'pos_dept' => 9,
		'pos_order' => 4,
		'pos_open' => 8,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Control Aide',
		'pos_desc' => "Generally an officer carrying out Military Service, they act as a general dogs-body for the Communications Control Department.",
		'pos_dept' => 9,
		'pos_order' => 5,
		'pos_open' => 10,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Weapons Master/Mistress',
		'pos_desc' => "A seasoned and experienced weapons expert, as well as stratetician, who ensures the safety of the vessel from external forces via useage of weapons.  Also maintains all weapons on board the Warbird.",
		'pos_dept' => 10,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Senior Weapons Controller',
		'pos_desc' => "A highly experienced weapons expert, as well as stratetician, who ensures the safety of the vessel from external forces via useage of weapons.  Also maintains all weapons on board the Warbird.",
		'pos_dept' => 10,
		'pos_order' => 1,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Weapons Master/Mistress',
		'pos_desc' => "An experienced weapons officer who ensures the safety of the vessel from external forces. These individuals have a high level of expertise in all weapons aboard a Warbird.",
		'pos_dept' => 10,
		'pos_order' => 0,
		'pos_open' => 2,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Specialist Controller',
		'pos_desc' => "Specialized weapons officers who help ensure the safety of the vessel from external forces. Generally, these specialists have trained on one or two specific weapons systems instead of general weapons knowledge.",
		'pos_dept' => 10,
		'pos_order' => 2,
		'pos_open' => 4,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'General Controller',
		'pos_desc' => "An experienced weapons officer who help ensure the safety of the vessel from external forces.",
		'pos_dept' => 10,
		'pos_order' => 3,
		'pos_open' => 8,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Lower Controller',
		'pos_desc' => "A junior weapons officer who works with the General Controllers to ensure the safety of the vessel from external forces.",
		'pos_dept' => 10,
		'pos_order' => 4,
		'pos_open' => 8,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Control Aide',
		'pos_desc' => "Generally an officer carrying out Military Service, they act as a general dogs-body for the Weapons Control Department.",
		'pos_dept' => 10,
		'pos_order' => 5,
		'pos_open' => 10,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Tal Diann Master/Mistress',
		'pos_desc' => "The gatherer of all intelligence on the vessel for use by the Command Staff.  Often works with the Commander to subvert the machinations of the Tal Shi'ar Representative due to the animosity between the two Intelligence groups.",
		'pos_dept' => 11,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Tal Diann Deputy Leader',
		'pos_desc' => "An experienced and trusted intelligence asset that works to help the Master/Mistress subert the machinations of the Tal Shi'ar aboard Warbirds.",
		'pos_dept' => 11,
		'pos_order' => 1,
		'pos_open' => 2,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Tal Diann Officer',
		'pos_desc' => "An experienced intelligence asset aboard a Warbird that works to subvert the machinations of the Tal'Shiar on their vessel.",
		'pos_dept' => 11,
		'pos_order' => 2,
		'pos_open' => 4,
		'pos_type' => 'officer'),
		
	array(
		'pos_name' => 'Reman Master/Mistress',
		'pos_desc' => "S/he is the person that controls all the Reman Slaves on board the Warbird, ensuring their loyalty to the RSE, as well as disciplining them.  S/he has a station on the Command Deck and monitors internal security.  Also s/he is present on landing and boarding parties.",
		'pos_dept' => 12,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Slave Overseer',
		'pos_desc' => "The Over-seer of one unit of Reman Slaves.",
		'pos_dept' => 12,
		'pos_order' => 1,
		'pos_open' => 4,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Elder Slave',
		'pos_desc' => "The most senior Reman Commando within a Unit.",
		'pos_dept' => 12,
		'pos_order' => 2,
		'pos_open' => 4,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Slave',
		'pos_desc' => "A normal Reman Commando.",
		'pos_dept' => 12,
		'pos_order' => 3,
		'pos_open' => 20,
		'pos_type' => 'officer')
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
