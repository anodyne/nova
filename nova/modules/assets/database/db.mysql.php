<?php defined('SYSPATH') or die('No direct script access.');

return array(
'default' => array(
'type' => 'mysql',

'connection' => array(
'hostname' => 'localhost',
'username' => false,
'password' => false,
'persistent' => false,
'database' => 'nova',
),

'table_prefix' => '',
'charset' => 'utf8',
'collate' => 'utf8_general_ci',
'caching' => false,
'profiling' => true,
),
);