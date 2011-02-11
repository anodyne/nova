<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class that all validation rules are converted to.
 *
 * @package Jelly
 */
class Jelly_Core_Validator_Rule
{
	/**
	 * @var  callback  The callback that will be called
	 */
	protected $_callback = NULL;

	/**
	 * @var  array  Any params that will be added to the callback
	 */
	protected $_params = NULL;

	/**
	 * @var  array  Original parameters, used for generating error params
	 */
	protected $_original_params = array();
	
	/**
	 * Creates a new rule.
	 * 
	 * If $params is empty or doesn't contain the :value context, the
	 * :value context is added to the front of the array as was the 
	 * behavior for the old validate class.
	 *
	 * @param  callback  $callback 
	 * @param  array     $params 
	 */
	public function __construct($callback, array $params = NULL)
	{
		if ($params === NULL)
		{
			// Default to array(':value')
			$params = array(':value');
		}
		
		// Save the original parameters for the potential error messe
		$this->_original_params = $params;

		// Set callback and params
		$this->_callback = $callback;
		$this->_params   = $params;
	}
	
	/**
	 * Calls the rule and returns a value from the callback.
	 * 
	 * For rules, an error is added to the validation array if FALSE is returned.
	 *
	 * @param   Validation $validation
	 * @return  mixed
	 */
	public function call(Validation $validation)
	{
		// Contextualize the callback and parameters
		list($callback, $params) = $this->_contextualize($validation);

		// Simply call the method
		if (call_user_func_array($callback, $params) === FALSE)
		{
			// Determine the name of the error based on the callback
			$error = is_array($this->_callback) ? $this->_callback[1] : $this->_callback;

			$params = array();
			$i = 1;
			
			// Create the error context
			foreach ($this->_original_params as $key => $param)
			{
				// Each error, with contexts, has the potential for multiple keys
				$keys = array(':param'.$i);
				
				// See if we need to replace the parameter with its context
				if (is_string($param) AND substr($param, 0, 1) === ':')
				{
					// Add the context to the keys so it 
					// can be identified by that name as well
					$keys[] = $param;
					
					// We only need to re-contextualize the parameter
					// if $key is not a string, which indicates it should be used as a message
					if ( ! is_string($key))
					{
						$param = $this->_replace_context($validation, $param);
					}
				}
				
				// Key is a custom message for this parameter, use that as the param instead
				if (is_string($key))
				{
					$param = __($key);
				}
				
				// Add any and all keys
				foreach ($keys as $key)
				{
					$params[$key] = $param;
				}
				
				// Increment parameter count
				$i++;
			}
			
			// Ensure :value is passed to the params
			if ( ! isset($params[':value']))
			{
				$params[':value'] = $validation->context('value');
			}
			
			// Add it to the list
			$validation->error($validation->context('field'), $error, $params);
		}
	}

	/**
	 * Returns a callback and parameter list with contexts replaced.
	 *
	 * @param   Validation  $validation
	 * @return  array
	 */
	protected function _contextualize(Validation $validation)
	{
		// Copy locally, because we don't want
		// to go mucking with the originals
		$callback = $this->_callback;
		$params   = $this->_params;

		// Check for a context to replace on the callback object
		if (is_array($callback) AND isset($callback[0]))
		{
			$callback[0] = $this->_replace_context($validation, $callback[0]);
		}

		// Replace all param contexts
		foreach ((array)$params as $key => $param)
		{
			$params[$key] = $this->_replace_context($validation, $param);
		}

		return array($callback, $params);
	}

	/**
	 * Replaces a context with its actual replacement.
	 *
	 * If $key is not a string or does not start with ':'
	 * the key is simply returned.
	 *
	 * @param   Validation  $validation
	 * @param   mixed     $key
	 * @return  mixed
	 */
	protected function _replace_context(Validation $validation, $key)
	{
		// Ensure we actually have a potentially valid context
		if ( ! is_string($key) OR substr($key, 0, 1) !== ':')
		{
			return $key;
		}

		return $validation->context(substr($key, 1));
	}

} // End Kohana_Validate_Rule