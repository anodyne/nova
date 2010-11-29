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
			'param' => false),
		array(
			'class' => 'Hooks',
			'method' => 'maintenance',
			'param' => false),
	),
	'postExecute' => array(),
	
	'preHeaders' => array(),
	'postHeaders' => array(),
	
	'preResponse' => array(),
	'postResponse' => array(),
);