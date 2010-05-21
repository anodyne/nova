<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
	'alternate' => array
	(
		'type'       => 'mysql',
		'connection' => array(
			/**
			 * The following options are available for MySQL:
			 *
			 * string   hostname
			 * string   username
			 * string   password
			 * boolean  persistent
			 * string   database
			 *
			 * Ports and sockets may be appended to the hostname.
			 */
			'hostname'   => 'localhost',
			'username'   => 'nova',
			'password'   => FALSE,
			'persistent' => FALSE,
			'database'   => 'nova',
		),
		'table_prefix' => 'nova_',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),
	'default' => array(
		'type'       => 'pdo',
		'connection' => array(
			/**
			 * The following options are available for PDO:
			 *
			 * string   dsn
			 * string   username
			 * string   password
			 * boolean  persistent
			 * string   identifier
			 */
			'dsn'        => 'mysql:host=localhost;dbname=nova',
			'username'   => 'nova',
			'password'   => FALSE,
			'persistent' => FALSE,
		),
		'table_prefix' => 'nova_',
		'charset'      => 'utf8',
		'caching'      => FALSE,
		'profiling'    => TRUE,
	),
);