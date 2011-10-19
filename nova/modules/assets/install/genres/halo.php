<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Install Genre - HALO
 *
 * @package		Nova
 * @category	Genre
 * @author		Anodyne Productions
 */
 
$g = 'halo';

$data = array(
	'departments_'. $g 	=> 'depts',
	'ranks_'. $g		=> 'ranks',
	'positions_'. $g	=> 'positions',
	'catalogue_ranks'	=> 'catalogue_ranks',
);

$depts = array();
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
$positions = array();
