<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * ExiteCMS
 *
 * An open source application development framework for PHP 4.3.2 or newer
 * ExiteCMS is based on CodeIgniter, Copyright (c) Ellislab Inc.
 *
 * Extension to the form validation library, to inform the library which
 * object contains your callback methods. Default, the CI superobject is
 * used.
 *
 * @package		ExiteCMS
 * @author		WanWizard
 * @copyright	Copyright (c) 2010, ExiteCMS.org
 * @link		http://www.exitecms.org
 * @since		Version 8.0
 * @filesource
 */

// ---------------------------------------------------------------------

class MY_Form_validation extends CI_Form_validation
{
    private $callback;

    // -----------------------------------------------------------------

    /**
     * Constructor
     *
     * @return void
     * @access public
     */
    public function __construct()
    {
        // call the parent constructor
        parent::__construct();

        // set the default callback object to the CI superobject
        $this->callback =& get_instance();
    }

    // -----------------------------------------------------------------

    /**
     * Inform the form validation library which object contains
     * the callback methods used in the validation rules.
     *
     * Only one object per set of rules can be defined.
     *
     * @param	object
     * @return	void
     * @access	public
     */
    public function set_callback_object(&$obj = null)
    {
        if (is_object($obj)) {
            // set the callback object
            $this->callback =& $obj;

            // make sure the callback object has access to the language library
            if (! isset($this->callback->lang) or ! is_object($this->callback->lang)) {
                $this->callback->lang =& $this->CI->lang;
            }
        }
    }

    // -----------------------------------------------------------------

    /**
     * Executes the Validation routines
     *
     * @access	private
     * @param	array
     * @param	array
     * @param	mixed
     * @param	integer
     * @return	void
     */
    public function _execute($row, $rules, $postdata = null, $cycles = 0)
    {
        // save the current CI object
        $CI = $this->CI;

        // set the CI object to our custom callback object
        $this->CI = $this->callback;

        parent::_execute($row, $rules, $postdata, $cycles);

        // restore the saved CI object
        $this->CI = $CI;
    }
}
