<?php
/**
 * Part of the Fuel framework.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2011 Fuel Development Team
 * @link       http://fuelphp.com
 */

// load the base config from the nova core
$base_config = Fuel::load(NOVAPATH.'nova/config/session.php');

// this is where people can override the base config
$app_config = array();

// merge the two arrays
$merged_array = array_merge( (array) $base_config, (array) $app_config);

// make sure the items get unset
unset($base_config);
unset($app_config);

// return the merged array
return $merged_array;
