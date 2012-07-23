<?php
/**
 * Base Database Config.
 *
 * See the individual environment DB configs for specific config information.
 */

return array(
	'active' => 'default',
	
	/**
	 * Base config, just need to set the DSN, username and password in env. config.
	 */
	'default' => array(
		'type'        => 'mysqli',
		'connection'  => array(
			'persistent' => false,
		),
		'identifier'   => '`',
		'charset'      => 'utf8',
		'caching'      => false,
		'profiling'    => false,
	),
);
