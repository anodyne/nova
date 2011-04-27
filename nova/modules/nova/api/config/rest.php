<?php

return array(
	
	/**
	 * What format should the data be returned in by default?
	 */
	'default_format' => 'xml',
	
	/**
	 * Name for the password-protected REST API displayed on login dialogs
	 *
	 *     E.g: My Secret REST API
	 */
	'realm' => 'REST API',
	
	/**
	 * Is login required and if so, which type of login?
	 *
	 *     '' = no login required
	 *     'basic' = unsecure login
	 *     'digest' = more secure login
	 */
	'auth' => '',
	
	/**
	 * Array of usernames and passwords for login
	 *
	 *     array('admin' => '1234')
	 */
	'valid_logins' => array('admin' => '1234'),
);
