<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
'default' => array(
'type' => 'pdo',

'connection' => array(
'dsn' => 'mysql:host=localhost;dbname=nova',
'username' => 'nova',
'password' => '',
'persistent' => FALSE,
),

'table_prefix' => 'nova_',
'charset' => 'utf8',
'caching' => FALSE,
'profiling' => TRUE,
),
);