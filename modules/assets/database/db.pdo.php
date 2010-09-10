<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(
'default' => array(
'type' => 'pdo',

'connection' => array(
'dsn' => 'mysql:host=localhost;dbname=nova',
'username' => FALSE,
'password' => FALSE,
'persistent' => FALSE,
),

'table_prefix' => '',
'charset' => 'utf8',
'collate' => 'utf8_general_ci',
'caching' => FALSE,
'profiling' => TRUE,
),
);