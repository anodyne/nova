<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$active_group = 'default';
$active_record = true;

$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'novauser';
$db['default']['password'] = 'novapass';
$db['default']['database'] = 'novadb';
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = 'nova_';
$db['default']['pconnect'] = true;
$db['default']['db_debug'] = NOVA_DB_DEBUG;
$db['default']['cache_on'] = false;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = true;
$db['default']['stricton'] = false;
