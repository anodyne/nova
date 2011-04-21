<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once MODPATH.'core/libraries/REST_Controller'.EXT;

class Nova_REST_Controller extends REST_Controller {
	
	private function _prepare_database_auth()
	{
		$uniqid = uniqid(""); // Empty argument for backward compatibility
		
		// We need to test which server authentication variable to use
		// because the PHP ISAPI module in IIS acts different from CGI
		if ($this->input->server('PHP_AUTH_DIGEST'))
		{
			$digest_string = $this->input->server('PHP_AUTH_DIGEST');
		}
		elseif ($this->input->server('HTTP_AUTHORIZATION'))
		{
			$digest_string = $this->input->server('HTTP_AUTHORIZATION');
		}
		else
		{
			$digest_string = "";
		}
		
		/**
		 * The $_SESSION['error_prompted'] variable is used to ask the password
		 * again if none is given or if the user enters a wrong authentication
		 * information.
		 */
		if ( empty($digest_string) )
		{
			$this->_force_login($uniqid);
		}
		
		// We need to retrieve authentication informations from the $auth_data variable
		preg_match_all('@(username|nonce|uri|nc|cnonce|qop|response)=[\'"]?([^\'",]+)@', $digest_string, $matches);
		$digest = array_combine($matches[1], $matches[2]);
		
		if ( ! array_key_exists('username', $digest) OR !$this->_check_login($digest['username']) )
		{
			$this->_force_login($uniqid);
		}
		
		$valid_logins =& $this->config->item('rest_valid_logins');
		$valid_pass = $valid_logins[$digest['username']];
		
		// This is the valid response expected
		$A1 = md5($digest['username'] . ':' . $this->config->item('rest_realm') . ':' . $valid_pass);
		$A2 = md5(strtoupper($this->request->method).':'.$digest['uri']);
		$valid_response = md5($A1.':'.$digest['nonce'].':'.$digest['nc'].':'.$digest['cnonce'].':'.$digest['qop'].':'.$A2);

		if ($digest['response'] != $valid_response)
		{
			header('HTTP/1.0 401 Unauthorized');
			header('HTTP/1.1 401 Unauthorized');
			exit;
		}
	}
}
