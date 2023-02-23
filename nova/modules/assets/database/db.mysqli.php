<?php

defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = true;

$db['default']['dsn'] = '';
$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'novauser';
$db['default']['password'] = 'novapass';
$db['default']['database'] = 'novadb';
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = 'nova_';
$db['default']['port'] = 3306;
$db['default']['pconnect'] = false;
$db['default']['db_debug'] = (ENVIRONMENT !== 'production');
$db['default']['cache_on'] = false;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['encrypt'] = false;
$db['default']['compress'] = false;
$db['default']['stricton'] = false;
$db['default']['failover'] = [];
$db['default']['save_queries'] = true;
