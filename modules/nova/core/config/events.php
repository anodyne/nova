<?php defined('SYSPATH') OR die('No direct access allowed.');
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

return array
(
	'preCreate'	=> array(),
	'postCreate' => array(),
	
	'preExecute' => array(),
	'postExecute' => array(),
	
	'preHeaders' => array(),
	'postHeaders' => array(),
	
	'preResponse' => array(),
	'postResponse' => array(),
);