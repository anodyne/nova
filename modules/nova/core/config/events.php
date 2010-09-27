<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Events are defined as a series of arrays that match up with a series pre-defined
 * events.
 *
 *     'preCreate' => array(
 *         array(
 *             'class' => 'Class',
 *             'method' => 'method',
 *             'param' => 'params'),
 *     );
 */

return array(
	'preCreate'	=> array(),
	'postCreate' => array(),
	
	'preExecute' => array(
		array(
			'class' => 'Hooks',
			'method' => 'browser',
			'param' => FALSE),
		array(
			'class' => 'Hooks',
			'method' => 'maintenance',
			'param' => FALSE),
	),
	'postExecute' => array(),
	
	'preHeaders' => array(),
	'postHeaders' => array(),
	
	'preResponse' => array(),
	'postResponse' => array(),
);