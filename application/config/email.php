<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
|  EMAIL CONFIGURATION
| -------------------------------------------------------------------
| From this page you can set the various email configuration options
| for the system. More information about config options can be found
| at http://codeigniter.com/user_guide/libraries/email.html.
|
| If you are having issues with email messages being routed to your
| spam folder immediately and setting rules and adding the addresses
| to your address book doesn't help, you can set the mailtype to
| text to have emails delivered like SMS 2.
*/

$config['useragent']		= 'CodeIgniter';
$config['protocol']			= 'mail';
$config['mailpath']			= '/usr/sbin/sendmail';
$config['smtp_host']		= '';
$config['smtp_user']		= '';
$config['smtp_pass']		= '';
$config['smtp_port']		= '25';
$config['smtp_timeout']		= 5;
$config['wordwrap']			= FALSE;
$config['wrapchars']		= '76';
$config['mailtype']			= 'html';
$config['charset']			= 'utf-8';
$config['validate']			= FALSE;
$config['priority']			= '3';
$config['crlf']				= "\n";
$config['newline']			= "\n";
$config['bcc_batch_mode']	= FALSE;
$config['bcc_batch_size']	= 200;

/* End of file email.php */
/* Location: ./application/config/email.php */