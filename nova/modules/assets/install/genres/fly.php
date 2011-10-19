<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Install Genre - FLY
 *
 * @package		Nova
 * @category	Genre
 * @author		Indigo (Anodyne forums)
 */
 
$g = 'fly';

$data = array(
	'departments_'. $g 	=> 'depts',
	'ranks_'. $g		=> 'ranks',
	'positions_'. $g	=> 'positions',
	'catalogue_ranks'	=> 'catalogue_ranks',
);

$depts = array(
	array(
		'dept_name' => 'Crew',
		'dept_desc' => "Individuals who live and work on the ship.",
		'dept_order' => 0,
		'dept_manifest' => 1),
	array(
		'dept_name' => 'Passengers',
		'dept_desc' => "Individuals who pay for passage and are not considered part of the crew.",
		'dept_order' => 1,
		'dept_manifest' => 1)
);

$ranks = array(
	/*
		this rank needs to stay here as it protects against errors being thrown
		in the event that someone's rank field gets blown away
	*/
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => '',
		'rank_order' => 0,
		'rank_class' => 0)
);

$positions = array(
	array(
		'pos_name' => 'Captain',
		'pos_desc' => "Individual in command of the vessel, usually also the owner of record responsible for management of the ship's operations.",
		'pos_dept' => 1,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Executive Officer',
		'pos_desc' => "Second in command of the vessel responsible for management of ship's operations under the direction of the Captain. The XO reports directly to the Captain.",
		'pos_dept' => 1,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Pilot',
		'pos_desc' => "Individual responsible primarily for navigation and piloting the ship with other duties when the ship has landed such as purchasing fuel. The pilot accepts orders from the XO or the Captain but reports directly to the Captain.",
		'pos_dept' => 1,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'crew'),
	array(
		'pos_name' => 'Mechanic',
		'pos_desc' => "Individual responsible for repair and upkeep of the vessel as well as maintaining an inventory of supplies needed for emergency repairs in space. The mechanic accepts orders from the XO or Captain but reports directly to the Captain.",
		'pos_dept' => 1,
		'pos_order' => 3,
		'pos_open' => 1,
		'pos_type' => 'crew'),
	array(
		'pos_name' => 'Muscle/Gun Hand',
		'pos_desc' => "Individuals adept with weapons used for protection of the ship and assorted other tasks. Works under the direction of the XO or Captain but reports directly to the Captain.",
		'pos_dept' => 1,
		'pos_order' => 4,
		'pos_open' => 2,
		'pos_type' => 'crew'),
	array(
		'pos_name' => 'Companion',
		'pos_desc' => "Guild-registered, the companion rents space on the ship and works independent of the crew. Many worlds will not let a vessel land without a companion on board. The Companion pays for space on the ship and does not report to the Captain. Instead, the Companion must work with the Captain to negotiate ports of call that are mutually beneficial.",
		'pos_dept' => 1,
		'pos_order' => 5,
		'pos_open' => 1,
		'pos_type' => 'crew'),
);

$catalogue_ranks = array(
	array(
		'rankcat_name' => 'Canon Ranks',
		'rankcat_location' => 'default',
		'rankcat_credits' => "The rank sets used in Nova were created by Kuro-chan of Kuro-RPG. The ranksets can be found at <a href='http://www.kuro-rpg.net' target='_blank'>Kuro-RPG</a>. Please do not copy or modify the images.",
		'rankcat_default' => 'y',
		'rankcat_url' => 'http://www.kuro-rpg.net/')
);
