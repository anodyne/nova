<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Debug Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		David VanScott
 */

// ------------------------------------------------------------------------

/**
 * Print Variable
 *
 * Print out the variable fed to the helper for debugging purposes
 *
 * @access	public
 * @param	string/array/object
 * @return	string
 */	
if ( ! function_exists('print_var'))
{
	function print_var($variable = '')
	{
		if (is_array($variable))
		{
			$type = 'array';
		}
		elseif (is_object($variable))
		{
			$type = 'object';
		}
		else
		{
			$type = 'variable';
		}
		
		echo _before();
		
		switch ($type)
		{
			case 'array':
				print_r($variable);
				break;
				
			case 'object':
				print_r($variable);
				break;
				
			case 'variable':
				echo $variable;
				
				break;
		}
		
		echo _after();
	}
}
	
//------------------------------------------------------------------------------

/**
 * Outputs the last query
 *
 * @return    string
 */
if ( ! function_exists('last_query'))
{
    function last_query()
    {
        $CI =& get_instance();
        
        echo _before();
        echo $CI->db->last_query();
        echo _after();
    }
}

//------------------------------------------------------------------------------

/**
* Outputs the query result
*
* @param    $query object
* @return    string
*/
if ( ! function_exists('query_result'))
{
    function query_result($query = '')
    {
        echo _before();
        
        print_r($query->result_array());
        
        echo _after();
    }
}

//------------------------------------------------------------------------------

/**
 * Outputs all session data
 *
 * @return    string
 */
if ( ! function_exists('print_session'))
{
    function print_session()
    {
        $CI =& get_instance();
        
        echo _before();
        print_r($CI->session->all_userdata());
        echo _after();
    }
}

//------------------------------------------------------------------------------

/**
 * _before
 *
 * @return    string
 */
function _before()
{
    $before = '<div style="padding:10px 20px 10px 20px; background-color:#fbe6f2; border:1px solid #d893a1; color: #000; font-size: 12px;>'."\n";
    $before .= '<h5 style="font-family:verdana,sans-serif; font-weight:bold; font-size:18px;">Debug Helper Output</h5>'."\n";
    $before .= '<pre>'."\n";
    return $before;
}
    
//------------------------------------------------------------------------------

/**
 * _after
 *
 * @return    string
 */
function _after()
{
    $after = '</pre>'."\n";
    $after .= '</div>'."\n";
    return $after;
}

//------------------------------------------------------------------------------

/* End of file debug_helper.php */
/* Location: ./application/helpers/debug_helper.php */