<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2009, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Email Class
 *
 * Permits email to be sent using Mail, Sendmail, or SMTP.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/email.html
 */
class MY_Email extends CI_Email
{

    /**
     * Send using mail()
     *
     * @access	private
     * @return	bool
     */
    public function _send_with_mail()
    {
        if ($this->_safe_mode == true) {
            if (! mail($this->_recipients, $this->_subject, $this->_finalbody, $this->_header_str)) {
                return false;
            } else {
                return true;
            }
        } else {
            // most documentation of sendmail using the "-f" flag lacks a space after it, however
            // we've encountered servers that seem to require it to be in place.
            if (! mail($this->_recipients, $this->_subject, $this->_finalbody, $this->_header_str)) {
                return false;
            } else {
                return true;
            }
        }
    }

    // --------------------------------------------------------------------
}
