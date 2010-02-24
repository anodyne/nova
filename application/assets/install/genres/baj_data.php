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
# TODO: positions
# TODO: department descriptions

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
		'dept_order' => 6),
	array(
		'dept_name' => 'Bajoran Religious Order',
		'dept_desc' => "Faith permeates the entire Bajoran culture through a stratified religious order that holds significant cultural and political influence on Bajor.",
		'dept_order' => 7),
	array(
		'dept_name' => 'Vedek Assembly',
		'dept_desc' => "The Vedek Assembly is the governing body of the Bajoran religion and holds great political influence as well. The Assembly is led by the Kai, the leading religious figure on Bajor.",
		'dept_order' => 0,
		'dept_parent' => 8),
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
		'pos_desc' => "A stand alone position. Either an experienced Space Forces Officer or a Militia Officer with a high level of vesala.",
		'pos_dept' => 1,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
		
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