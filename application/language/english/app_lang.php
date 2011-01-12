<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * English language file
 *
 * Punctuation contants are defined in application/config/constants.php
 *
 * @package		Nova
 * @category	Language
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		2.0
 */

// figure out what language the file is
$language = basename(dirname(__FILE__));

// include the base language file
include_once MODPATH.'core/language/'.$language.'/base_lang'.EXT;

/*
 * Your language array keys go here in the following format:
 * 
 * $lang['key'] = 'My Key';
 * 
 * If you want to override an existing key, you can do so
 * by redeclaring it like this:
 * 
 * $lang['global_position'] = 'job';
 * 
 * An example item is below for you to copy and paste.
 */

//$lang['global_position'] = 'job';
