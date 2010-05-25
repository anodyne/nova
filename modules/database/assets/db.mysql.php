<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
'default' => array(
'type' => 'mysql',

'connection' => array(
'hostname' => 'localhost',
'username' => FALSE,
'password' => FALSE,
'persistent' => FALSE,
'database' => 'nova',
),

'table_prefix' => '',
'charset' => 'utf8',
'caching' => FALSE,
'profiling' => TRUE,
),
);