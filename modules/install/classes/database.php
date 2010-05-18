<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Database connection wrapper.
 *
 * @package    Database
 * @author     Kohana Team
 * @copyright  (c) 2008-2009 Kohana Team
 * @license    http://kohanaphp.com/license
 */
abstract class Database extends Kohana_Database {
	
	// Query types
	const CREATE =  5;
	const ALTER =  6;
	const DROP =  7;
	const TRUNCATE =  8;
	
} // End Database