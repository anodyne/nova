<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Install Genre - BLANK
 *
 * @package		Nova
 * @category	Genre
 * @author		Anodyne Productions
 */
 
$g = 'blk';

$data = array(
	'departments_'. $g 	=> 'depts',
	'ranks_'. $g		=> 'ranks',
	'positions_'. $g	=> 'positions',
	'catalogue_ranks'	=> 'catalogue_ranks',
);

$depts = array(
	array(
		'dept_name' => 'Department',
		'dept_desc' => "This is a blank department to be used as an example of what should be included in a department record. Please edit this record to match your sim's style and needs or remove the record altogether.",
		'dept_order' => 0,
		'dept_manifest' => 1),
);

$ranks = array(
	array(
		'rank_name' => 'Blank',
		'rank_short_name' => 'BLANK',
		'rank_image' => '',
		'rank_order' => 0,
		'rank_class' => 1),
);

$positions = array(
	array(
		'pos_name' => 'Position',
		'pos_desc' => "This is a blank position to be used as an example of what should be included in a position record. Please edit this record to match your sim's style and needs or remove the record altogether.",
		'pos_dept' => 1,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
);

$catalogue_ranks = array(
	array(
		'rankcat_name' => 'Rank Catalogue',
		'rankcat_location' => 'default',
		'rankcat_credits' => "This is a blank rank catalogue record to be used as an example of what should be included in a rank catalogue record. Please edit this record to match your ranks or remove the record altogether.",
		'rankcat_default' => 'y',
		'rankcat_url' => '',
		'rankcat_genre' => $g),
);
