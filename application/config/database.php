<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
'default' => array(
'type' => 'mysql',

'connection' => array(
'hostname' => 'localhost',
'username' => 'root',
'password' => '',
'persistent' => FALSE,
'database' => 'nova2_dbforge_test',
),

'table_prefix' => 'nova_',
'charset' => 'utf8',
'collate' => 'utf8_general_ci',
'caching' => FALSE,
'profiling' => TRUE,
),
);