<?php
/**
 * Messages controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		2.0
 */

require_once MODPATH.'core/libraries/Nova_controller_admin'.EXT;

abstract class Nova_messages extends Nova_controller_admin {
	
	public function __construct()
	{
		parent::__construct();
		
		// load the PM model
		$this->load->model('privmsgs_model', 'pm');
		
		// load the user agent library
		$this->load->library('user_agent');
	}
	
	public function index()
	{
		Auth::check_access();
		
		// load the resources
		$this->load->helper('text');
		
		if (isset($_POST['inbox']) or isset($_POST['outbox']))
		{
			if (isset($_POST['inbox']))
			{
				$update_count = 0;
				
				foreach ($_POST as $k => $v)
				{
					if (substr($k, 0, 6) == 'inbox_')
					{
						$update_array = array(
							'pmto_display' => 'n',
							'pmto_unread' => 'n'
						);
						
						$update = $this->pm->update_to_message($v, $this->session->userdata('userid'), $update_array);
						
						if ($update > 0)
						{
							$update_count++;
						}
					}
				}
				
				if ($update_count > 0)
				{
					$message = sprintf(
						lang('flash_success_plural'),
						ucfirst(lang('global_privatemessages')),
						lang('actions_removed'),
						''
					);
					
					$flash['status'] = 'success';
					$flash['message'] = text_output($message);
				}
				else
				{
					$message = sprintf(
						lang('flash_failure_plural'),
						ucfirst(lang('global_privatemessages')),
						lang('actions_removed'),
						''
					);
					
					$flash['status'] = 'error';
					$flash['message'] = text_output($message);
				}
			}
			
			if (isset($_POST['outbox']))
			{
				$update_count = 0;
				
				foreach ($_POST as $k => $v)
				{
					if (substr($k, 0, 7) == 'outbox_')
					{
						$update_array = array('privmsgs_author_display' => 'n');
						
						$update = $this->pm->update_private_message($v, $update_array);
						
						if ($update > 0)
						{
							$update_count++;
						}
					}
				}
				
				if ($update_count > 0)
				{
					$message = sprintf(
						lang('flash_success_plural'),
						ucfirst(lang('global_privatemessages')),
						lang('actions_removed'),
						''
					);
					
					$flash['status'] = 'success';
					$flash['message'] = text_output($message);
				}
				else
				{
					$message = sprintf(
						lang('flash_failure_plural'),
						ucfirst(lang('global_privatemessages')),
						lang('actions_removed'),
						''
					);
					
					$flash['status'] = 'error';
					$flash['message'] = text_output($message);
				}
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		// run the methods
		$inbox = $this->pm->get_inbox($this->session->userdata('userid'));
		$outbox = $this->pm->get_outbox($this->session->userdata('userid'));
		
		$data['header'] = ucwords(lang('global_privatemessages'));
		
		$data['images'] = array(
			'write' => array(
				'src' => Location::img('mail-message-new.png', $this->skin, 'admin'),
				'alt' => lang('actions_write'),
				'class' => 'image inline_img_left'),
			'unread' => array(
				'src' => Location::img('mail-unread.png', $this->skin, 'admin'),
				'alt' => '*',
				'class' => 'image')
		);
		
		$data['button'] = array(
			'inbox' => array(
				'type' => 'submit',
				'class' => 'button-main float_right',
				'name' => 'inbox',
				'value' => 'remove',
				'content' => ucwords(lang('actions_remove'))),
			'outbox' => array(
				'type' => 'submit',
				'class' => 'button-main float_right',
				'name' => 'outbox',
				'value' => 'remove',
				'content' => ucwords(lang('actions_remove')))
		);
		
		if ($inbox->num_rows() > 0)
		{
			$datestring = $this->options['date_format'];
			$data['inbox_check_all'] = array(
				'name' => 'inbox_check_all',
				'id' => 'inbox_check_all'
			);
			
			foreach ($inbox->result() as $item)
			{
				$date = gmt_to_local($item->privmsgs_date, $this->timezone, $this->dst);
				
				$data['inbox'][$item->pmto_id]['id'] = $item->privmsgs_id;
				$data['inbox'][$item->pmto_id]['author'] = $this->char->get_character_name($item->privmsgs_author_character, true);
				$data['inbox'][$item->pmto_id]['subject'] = $item->privmsgs_subject;
				$data['inbox'][$item->pmto_id]['blurb'] = word_limiter($item->privmsgs_content, 15);
				$data['inbox'][$item->pmto_id]['date'] = mdate($datestring, $date);
				$data['inbox'][$item->pmto_id]['unread'] = ($item->pmto_unread == 'y') ? img($data['images']['unread']) : false;
				$data['inbox'][$item->pmto_id]['checkbox'] = array(
					'name' => 'inbox_'. $item->pmto_id,
					'value' => $item->pmto_id,
					'class' => 'inbox'
				);
			}
		}
		
		if ($outbox->num_rows() > 0)
		{
			$datestring = $this->options['date_format'];
			
			$data['outbox_check_all'] = array(
				'name' => 'outbox_check_all',
				'id' => 'outbox_check_all'
			);
			
			foreach ($outbox->result() as $item)
			{
				$messages = $this->pm->get_messages_for_id($item->privmsgs_id);
				
				if ($messages->num_rows() > 0)
				{
					$array = array();
					
					foreach ($messages->result() as $msg)
					{
						$array[] = $this->char->get_character_name($msg->pmto_recipient_character, true);
					}
				}
				
				$to = implode(' &amp; ', $array);
				
				$date = gmt_to_local($item->privmsgs_date, $this->timezone, $this->dst);
				
				// build the data used
				$data['outbox'][$item->privmsgs_id]['id'] = $item->privmsgs_id;
				$data['outbox'][$item->privmsgs_id]['to'] = $to;
				$data['outbox'][$item->privmsgs_id]['subject'] = $item->privmsgs_subject;
				$data['outbox'][$item->privmsgs_id]['blurb'] = word_limiter($item->privmsgs_content, 15);
				$data['outbox'][$item->privmsgs_id]['date'] = mdate($datestring, $date);
				$data['outbox'][$item->privmsgs_id]['checkbox'] = array(
					'name' => 'outbox_'. $item->privmsgs_id,
					'value' => $item->privmsgs_id,
					'class' => 'outbox'
				);
			}
		}
		
		$js_data['tab'] = ($this->uri->segment(3) == 'sent') ? 1 : 0;
		
		$data['loader'] = array(
			'src' => Location::img('loading-bar.gif', $this->skin, 'admin'),
			'alt' => lang('actions_loading'),
		);
		
		$data['label'] = array(
			'from' => ucfirst(lang('time_from')),
			'inbox' => ucwords(lang('labels_inbox')),
			'loading' => ucfirst(lang('actions_loading')) .'...',
			'no_inbox' => sprintf(lang('error_not_found'), lang('global_privatemessages')),
			'no_outbox' => sprintf(lang('error_not_found'), lang('actions_sent').' '.lang('global_privatemessages')),
			'sent' => ucwords(lang('actions_sent') .' '. lang('labels_messages')),			
			'subject' => ucfirst(lang('labels_subject')),
			'to' => ucfirst(lang('labels_to')),
			'write' => ucwords(lang('actions_write') .' '. lang('status_new') .' '. lang('labels_message')),
		);
		
		$this->_regions['content'] = Location::view('messages_index', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('messages_index_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	function read($id = false)
	{
		Auth::check_access('messages/index');
		
		// sanity check
		$id = (is_numeric($id)) ? $id : false;
		
		// get the message
		$message = $this->pm->get_message($id);
		
		if ($message->num_rows() > 0)
		{
			$row = $message->row();
			
			// get the recipients array
			$recips = $this->pm->get_message_recipients($row->privmsgs_id);
			
			// set the date format
			$datestring = $this->options['date_format'];
			
			// the person trying to view must either be the author or a recipient of the PM
			if ($row->privmsgs_author_user == $this->session->userdata('userid') or
					in_array($this->session->userdata('userid'), $recips))
			{
				$date = gmt_to_local($row->privmsgs_date, $this->timezone, $this->dst);
				
				$data['id'] = $row->privmsgs_id;
				$data['header'] = text_output($row->privmsgs_subject, 'h1', 'page-head');
				$data['content'] = $row->privmsgs_content;
				$data['date'] = mdate($datestring, $date);
				$data['author'] = $this->char->get_character_name($row->privmsgs_author_character, true);
				
				foreach ($recips as $rec)
				{
					$array[] = $this->char->get_character_name($this->user->get_main_character($rec), true);
				}
				
				$data['to'] = implode(' &amp; ', $array);
				
				$data['images'] = array(
					'reply' => array(
						'src' => Location::img('mail-reply-sender.png', $this->skin, 'admin'),
						'alt' => '',
						'class' => 'image inline_img_left'),
					'reply_all' => array(
						'src' => Location::img('mail-reply-all.png', $this->skin, 'admin'),
						'alt' => '',
						'class' => 'image inline_img_left'),
					'forward' => array(
						'src' => Location::img('mail-forward.png', $this->skin, 'admin'),
						'alt' => '',
						'class' => 'image inline_img_left')
				);
				
				if (in_array($this->session->userdata('userid'), $recips))
				{
					$update_array = array('pmto_unread' => 'n');
					$update = $this->pm->update_message($id, $this->session->userdata('userid'), $update_array);
				}
				
				// set the title
				$title = ucwords(lang('global_privatemessage')) .' - '.  $row->privmsgs_subject;
			}
			else
			{
				redirect('admin/error/2');
			}
		}
		else
		{
			$data['header'] = lang_output('error_title_id_not_found', 'h1', 'red');
			$data['msg'] = lang('error_no_pm');
			
			$title = lang('error_pagetitle');
		}
		
		$data['label'] = array(
			'by' => lang('labels_by'),
			'forward' => ucfirst(lang('actions_forward')),
			'inbox' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') 
				.' '. ucfirst(lang('labels_inbox')),
			'reply' => ucfirst(lang('actions_reply')),
			'replyall' => ucfirst(lang('actions_reply')) .' '. lang('labels_to') .' '. ucfirst(lang('labels_all')),
			'sent' => ucfirst(lang('actions_sent') .' '. lang('labels_on')),
			'to' => ucfirst(lang('labels_to')) .':',
		);
		
		$this->_regions['content'] = Location::view('messages_read', $this->skin, 'admin', $data);
		$this->_regions['title'].= $title;
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function write($action = false, $id = false)
	{
		Auth::check_access('messages/index');
		
		if ($this->options['system_email'] == 'off')
		{
			$flash['status'] = 'info';
			$flash['message'] = lang_output('flash_system_email_off');
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		// set the action array
		$action_array = array('reply', 'replyall', 'forward');
		
		// sanity checks
		$action = (in_array($action, $action_array)) ? $action : false;
		$id = (is_numeric($id)) ? $id : false;
		
		// set the variables
		$data['key'] = '';
		$message = false;
		$subject = false;
		
		if (isset($_POST['submit']))
		{
			// define the POST variables
			$subject = $this->input->post('subject', true);
			$message = $this->input->post('message', true);
			$recipients = $this->input->post('recipients', true);
			
			if ( ! is_array($recipients) and count($recipients) == 0)
			{
				$flash['status'] = 'error';
				$flash['message'] = lang_output('flash_privmsgs_no_recipient');
			}
			else
			{
				foreach ($recipients as $key => $value)
				{
					if ( ! is_numeric($value) || $value < 1)
					{
						unset($recipients[$key]);
					}
				}
				
				$insert_array = array(
					'privmsgs_author_user' => $this->session->userdata('userid'),
					'privmsgs_author_character' => $this->session->userdata('main_char'),
					'privmsgs_date' => now(),
					'privmsgs_subject' => $subject,
					'privmsgs_content' => $message
				);
				
				// do the insert
				$insert = $this->pm->insert_private_message($insert_array);
				
				// get the message ID
				$msgid = $this->db->insert_id();
				
				$this->sys->optimize_table('privmsgs');
				
				foreach ($recipients as $value)
				{
					$insert_array = array(
						'pmto_message' => $msgid,
						'pmto_recipient_user' => $value,
						'pmto_recipient_character' => $this->user->get_main_character($value)
					);
					
					$insert2 = $this->pm->insert_pm_recipients($insert_array);
				}
				
				if ($insert > 0)
				{
					$flashmsg = sprintf(
						lang('flash_success'),
						ucfirst(lang('global_privatemessage')),
						lang('actions_sent'),
						''
					);
					
					$flash['status'] = 'success';
					$flash['message'] = text_output($flashmsg);
					
					// set the array of data for the email
					$email_data = array(
						'author' => $this->session->userdata('main_char'),
						'subject' => $subject,
						'to' => implode(',', $recipients),
						'message' => $message
					);
					
					// send the email
					$email = ($this->options['system_email'] == 'on') ? $this->_email($email_data) : false;
				}
				else
				{
					$message = sprintf(
						lang('flash_failure'),
						ucfirst(lang('global_privatemessage')),
						lang('actions_sent'),
						''
					);
					
					$flash['status'] = 'error';
					$flash['message'] = text_output($message);
				}
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
			
			// reset the message and subject variables
			$message = false;
			$subject = false;
		}
		
		// run the methods
		$characters = $this->user->get_main_characters();
		
		if ($characters->num_rows() > 0)
		{
			// we do this to make sure active characters are on top
			$data['characters'][ucwords(lang('status_active') .' '. lang('global_characters'))] = array();
			$data['characters'][ucwords(lang('status_inactive') .' '. lang('global_characters'))] = array();
			
			foreach ($characters->result() as $item)
			{
				if ($item->status != 'pending')
				{
					$type = ($item->status == 'active')
						? ucwords(lang('status_active') .' '. lang('global_characters')) 
						: ucwords(lang('status_inactive') .' '. lang('global_characters'));
						
					$data['characters'][$type][$item->userid] = $this->char->get_character_name($item->main_char, true);
				}
			}
			
			// make sure there's something in the inactive section
			if (count($data['characters'][ucwords(lang('status_inactive') .' '. lang('global_characters'))]) == 0)
			{
				unset($data['characters'][ucwords(lang('status_inactive') .' '. lang('global_characters'))]);
			}
		}
		
		$data['inputs'] = array(
			'subject' => array(
				'name' => 'subject',
				'id' => 'subject',
				'value' => $subject),
			'message' => array(
				'name' => 'message',
				'id' => 'message-textarea',
				'rows' => 20,
				'value' => $message),
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		// get the data if it is not a new PM
		$info = ($action !== false) ? $this->pm->get_message($id) : false;
		$row = ($info !== false and $info->num_rows() > 0) ? $info->row() : false;
		$recipient_list = ($action == 'reply' or $action == 'replyall') ? $this->pm->get_message_recipients($id) : false;
		
		// make sure the person is allowed to be replying
		if ($recipient_list !== false)
		{
			if ( ! in_array($this->session->userdata('userid'), $recipient_list) and
					! ($this->session->userdata('userid') == $row->privmsgs_author_user))
			{
				redirect('admin/error/3');
			}
		}
		
		$data['recipient_list'] = array();
		
		switch ($action)
		{
			case 'reply':
				// is the RE: tag in the subject already?
				$pos = strpos($row->privmsgs_subject, lang('abbr_reply'));
				
				// make sure the subject is set right
				$subj = ($pos === false) ? lang('abbr_reply').': '.$row->privmsgs_subject : $row->privmsgs_subject;
				
				// set the subject value
				$data['inputs']['subject']['value'] = $subj;
				
				// set the user
				$selected = $row->privmsgs_author_user;
				
				// set the arrays
				$active = array();
				$inactive = array();
				
				if (isset($data['characters'][ucwords(lang('status_active') .' '. lang('global_characters'))]))
				{
					$active = $data['characters'][ucwords(lang('status_active') .' '. lang('global_characters'))];
				}
				
				if (isset($data['characters'][ucwords(lang('status_inactive') .' '. lang('global_characters'))]))
				{
					$inactive = $data['characters'][ucwords(lang('status_inactive') .' '. lang('global_characters'))];
				}
				
				// grab the key for the array
				$key = (array_key_exists($selected, $active)) ? $selected : 0;
				
				if ($key == 0)
				{
					$key = (array_key_exists($selected, $inactive)) ? $selected : 0;
				}
				
				// set the key
				$data['recipient_list'] = $key;
				
				$data['header'] = ucfirst(lang('actions_reply')).' '.lang('labels_to').' '.ucwords(lang('global_privatemessage'));
				
				$date = gmt_to_local($row->privmsgs_date, $this->timezone, $this->dst);
				
				// set the data for the previous PM
				$data['previous'] = array(
					'from' => $this->char->get_character_name($row->privmsgs_author_character),
					'date' => mdate($this->options['date_format'], $date),
					'content' => $row->privmsgs_content
				);
			break;
			
			case 'replyall':
				// find if the current user is listed in the recipient list
				$key = array_search($this->session->userdata('userid'), $recipient_list);
				
				// drop the current user off the recipient list
				if ($key !== false)
				{
					unset($recipient_list[$key]);
				}
				
				// set the hidden TO field
				$data['recipient_list'] = implode(',', $recipient_list).','.$row->privmsgs_author_user;
				
				// is the RE: tag in the subject already?
				$pos = strpos($row->privmsgs_subject, lang('abbr_reply'));
				
				// make sure the subject is set right
				$subj = ($pos === false) ? lang('abbr_reply').': '.$row->privmsgs_subject : $row->privmsgs_subject;
				
				// set the subject value
				$data['inputs']['subject']['value'] = $subj;
				
				$data['header'] = ucfirst(lang('actions_reply')).' '.lang('labels_to').' '.ucwords(lang('global_privatemessage'));
				
				$date = gmt_to_local($row->privmsgs_date, $this->timezone, $this->dst);
				
				// set the data for the previous PM
				$data['previous'] = array(
					'from' => $this->char->get_character_name($row->privmsgs_author_character),
					'date' => mdate($this->options['date_format'], $date),
					'content' => $row->privmsgs_content
				);
			break;
				
			case 'forward':
				// set the hidden TO field
				$data['to'] = 0;
				
				// build an array to hold the recipients
				$to_array = $this->pm->get_message_recipients($id);
				
				foreach ($to_array as $rec)
				{
					$array[] = $this->char->get_character_name($this->user->get_main_character($rec), true);
				}
				
				// create a string of character names
				$to = implode(' &amp; ', $array);
				
				$date = gmt_to_local($row->privmsgs_date, $this->timezone, $this->dst);
				
				// set the textarea value
				$data['inputs']['message']['value'] = "\r\n\r\n\r\n==========\r\n\r\n";
				$data['inputs']['message']['value'].= ucfirst(lang('time_from')) .': ';
				$data['inputs']['message']['value'].= $this->char->get_character_name($row->privmsgs_author_character, true);
				$data['inputs']['message']['value'].= "\r\n". ucfirst(lang('labels_to')).': '.str_replace(' &amp; ', ', ', $to);
				$data['inputs']['message']['value'].= "\r\n". ucfirst(lang('labels_on')) .' ';
				$data['inputs']['message']['value'].= mdate($this->options['date_format'], $date);
				$data['inputs']['message']['value'].= "\r\n\r\n". $row->privmsgs_content;
				
				// is the FWD: tag in the subject already?
				$pos = strpos($row->privmsgs_subject, lang('abbr_forward'));
				
				// make sure the subject is set right
				$subj = ($pos === false) ? lang('abbr_forward').': '.$row->privmsgs_subject : $row->privmsgs_subject;
				
				// set the subject value
				$data['inputs']['subject']['value'] = $subj;
				
				$data['header'] = ucfirst(lang('actions_forward')) .' '. ucwords(lang('global_privatemessage'));
			break;
				
			default:
				$data['to'] = 0;
				$data['header'] = ucwords(lang('actions_write') .' '. lang('global_privatemessage'));
			break;
		}
		
		$data['label'] = array(
			'add' => ucwords(lang('actions_add') .' '. lang('labels_recipient')),
			'inbox' => LARROW.' '.ucfirst(lang('actions_back')).' '.lang('labels_to').' '.ucfirst(lang('labels_inbox')),
			'message' => ucfirst(lang('labels_message')),
			'on' => ucfirst(lang('labels_on')),
			'subject' => ucfirst(lang('labels_subject')),
			'to' => ucfirst(lang('labels_to')),
			'wrote' => lang('actions_wrote') .':',
			'select' => ucwords(lang('labels_please').' '.lang('actions_select')).' '.lang('labels_the').' '.ucfirst(lang('labels_recipients')),
			'chosen_incompat' => lang('chosen_incompat'),
		);
		
		$this->_regions['content'] = Location::view('messages_write', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('messages_write_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	protected function _email($data)
	{
		// load the resources
		$this->load->library('email');
		$this->load->library('parser');
		
		// define the variables
		$email = false;
		
		// create an array from the data TO var and prep the emails array
		$email_start = explode(',', $data['to']);
		$emails = array();
		
		// set the temp array
		$array = array();
		
		foreach ($email_start as $em)
		{
			$emails[$em] = $this->user->get_email_address('user', $em);
		}
		
		foreach ($emails as $key => $email)
		{
			$array[] = $this->char->get_character_name($this->user->get_main_character($key), true, true);
			
			// get their prefs
			$pref = $this->user->get_pref('email_private_message', $key);
			
			if ($pref == 'y')
			{
				// don't do anything
			}
			else
			{
				unset($emails[$key]);
			}
		}
		
		// set some variables
		$from_name = $this->char->get_character_name($data['author'], true, true);
		$from_email = $this->user->get_email_address('character', $data['author']);
		$subject = $this->options['email_subject'] .' '. lang('email_subject_private_message') .' - '. $data['subject'];
		$to_names = implode(', ', $array);
		
		// set the content
		$content = sprintf(
			lang('email_content_private_message'),
			$from_name,
			$data['message'],
			site_url('login/index')
		);
		
		// set the email data
		$email_data = array(
			'email_subject' => $data['subject'],
			'email_from' => ucfirst(lang('time_from')) .': '. $from_name,
			'email_to' => ucfirst(lang('labels_to')) .': '. $to_names,
			'email_content' => nl2br($content)
		);
		
		// where should the email be coming from
		$em_loc = Location::email('messages_new', $this->email->mailtype);
		
		// parse the message
		$message = $this->parser->parse($em_loc, $email_data, true);
		
		// for use by the email library
		$to = implode(',', $emails);
		
		// set the parameters for sending the email
		$this->email->from($from_email, $from_name);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		
		// send the email
		$email = $this->email->send();
		
		return $email;
	}
}
