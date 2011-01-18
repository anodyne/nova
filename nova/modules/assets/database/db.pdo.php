<?php defined('SYSPATH') or die('No direct script access.');

return array(
'default' => array(
'type' => 'pdo',

'connection' => array(
'dsn' => 'mysql:host=localhost;dbname=nova',
'username' => false,
'password' => false,
'persistent' => false,
),

'table_prefix' => '',
'charset' => 'utf8',
'collate' => 'utf8_general_ci',
'caching' => false,
'profiling' => true,
),
);