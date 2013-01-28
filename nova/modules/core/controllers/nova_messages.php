<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Messages controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

require_once MODPATH.'core/libraries/Nova_controller_admin.php';

abstract class Nova_messages extends Nova_controller_admin {
	
	public function __construct()
	{
		parent::__construct();
		
		// load the PM model
		$this->load->model('privmsgs_model', 'pm');
	}
	
	public function index($offset = 0)
	{
		Auth::check_access();
		
		// load the resources
		$this->load->library('pagination');
		$this->load->helper('text');
		
		if (isset($_POST['inbox']))
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
				
				$message = sprintf(
					($update_count > 0) ? lang('flash_success_plural') : lang('flash_failure_plural'),
					ucfirst(lang('global_privatemessages')),
					lang('actions_removed'),
					''
				);
				$flash['status'] = ($update_count > 0) ? 'success' : 'error';
				$flash['message'] = text_output($message);
				
				// set the flash message
				$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
			}
		}
		
		$config['base_url'] = site_url('messages/index/');
		$config['total_rows'] = $this->pm->count_pms($this->session->userdata('userid'), 'inbox');
		$config['per_page'] = 25;
		$config['full_tag_open'] = '<p class="fontMedium bold">';
		$config['full_tag_close'] = '</p>';
	
		// initialize the pagination library
		$this->pagination->initialize($config);
		
		// create the page links
		$data['inbox_pagination'] = $this->pagination->create_links();
		
		// get the inbox data
		$inbox = $this->pm->get_inbox($this->session->userdata('userid'), $config['per_page'], $offset);
		
		$data['header'] = ucwords(lang('global_privatemessages'));
		
		$data['images'] = array(
			'write' => array(
				'src' => Location::img('mail-message-new.png', $this->skin, 'admin'),
				'alt' => lang('actions_write'),
				'class' => 'image inline_img_left'),
			'read' => array(
				'src' => Location::img('icon-check.png', $this->skin, 'admin'),
				'alt' => lang('mark_as_read'),
				'class' => 'image inline_img_left'),
			'unread' => array(
				'src' => Location::img('mail-unread.png', $this->skin, 'admin'),
				'alt' => '*',
				'class' => 'image'),
			'clock' => array(
				'src' => Location::img('clock.png', $this->skin, 'admin'),
				'alt' => '*',
				'class' => 'image inline_img_left'),
			'user' => array(
				'src' => Location::img('user.png', $this->skin, 'admin'),
				'alt' => '*',
				'class' => 'image inline_img_left'),
			'preview' => array(
				'src' => Location::img('magnifier-medium.png', $this->skin, 'admin'),
				'alt' => '[?]',
				'class' => 'image'),
		);
		
		$data['button'] = array(
			'inbox' => array(
				'type' => 'submit',
				'class' => 'button-sec',
				'name' => 'inbox',
				'value' => 'remove',
				'content' => ucwords(lang('actions_remove'))),
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
				$data['inbox'][$item->pmto_id]['author'] = $this->char->get_character_name($item->privmsgs_author_character, true, false, true);
				$data['inbox'][$item->pmto_id]['subject'] = $item->privmsgs_subject;
				$data['inbox'][$item->pmto_id]['date'] = mdate($datestring, $date);
				$data['inbox'][$item->pmto_id]['unread'] = ($item->pmto_unread == 'y') ? img($data['images']['unread']) : false;
				$data['inbox'][$item->pmto_id]['preview'] = nl2br(htmlspecialchars(strip_tags(word_limiter($item->privmsgs_content, 100))));
				$data['inbox'][$item->pmto_id]['checkbox'] = array(
					'name' => 'inbox_'. $item->pmto_id,
					'value' => $item->pmto_id,
					'class' => 'inbox',
				);
			}
		}
		
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'search',
				'id' => 'submitSearch',
				'content' => ucfirst(lang('actions_search'))),
			'search' => array(
				'name' => 'search_terms',
				'id' => 'search_terms',
				'placeholder' => ucfirst(lang('actions_search').'...')),
		);
		
		$data['loader'] = array(
			'src' => Location::img('loading-bar.gif', $this->skin, 'admin'),
			'alt' => lang('actions_loading'),
		);
		
		$data['label'] = array(
			'inbox' => ucwords(lang('labels_inbox')),
			'loading' => ucfirst(lang('actions_loading')) .'...',
			'message_preview' => ucwords(lang('labels_message').' '.lang('labels_preview')),
			'no_inbox' => sprintf(lang('error_not_found'), lang('global_privatemessages')),
			'mark_read' => lang('mark_as_read'),
			'search' => ucfirst(lang('actions_search')),
			'sent' => ucwords(lang('actions_sent').' '.lang('labels_messages').' '.RARROW),
			'write' => ucwords(lang('actions_write') .' '. lang('status_new') .' '. lang('labels_message')),
		);
		
		$this->_regions['content'] = Location::view('messages_index', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('messages_index_js', $this->skin, 'admin');
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
				$data['author'] = $this->char->get_character_name($row->privmsgs_author_character, true, false, true);
				$data['to_count'] = count($recips);
				
				foreach ($recips as $rec)
				{
					$array[] = $this->char->get_character_name($this->user->get_main_character($rec), true, false, true);
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
	
	public function search()
	{
		if (isset($_POST['submit']))
		{
			// get the POST values
			$term = $this->input->post('search_term', true);
			
			// run the search
			$data['results'] = $this->pm->search_private_messages($this->session->userdata('userid'), $term);
		}
		else
		{
			# code...
		}
		
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'search',
				'id' => 'submitSearch',
				'content' => ucfirst(lang('actions_search'))),
			'search' => array(
				'name' => 'search_terms',
				'id' => 'search_terms',
				'placeholder' => ucfirst(lang('actions_search').'...')),
		);
		
		$data['label'] = array(
			'back' => LARROW.' '.ucfirst(lang('actions_back')).' '.lang('labels_to').' '.ucfirst(lang('labels_inbox')),
			'no_results' => sprintf(lang('error_not_found'), lang('actions_search').' '.lang('labels_results')),
		);
		
		// set the header
		$data['header'] = ucwords(lang('actions_search').' '.lang('labels_results'));
		
		$this->_regions['content'] = Location::view('messages_search_results', $this->skin, 'admin', $data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function sent($offset = 0)
	{
		Auth::check_access('messages/index');
		
		// load the resources
		$this->load->library('pagination');
		$this->load->helper('text');
		
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
			
			$message = sprintf(
				($update_count > 0) ? lang('flash_success_plural') : lang('flash_failure_plural'),
				ucfirst(lang('global_privatemessages')),
				lang('actions_removed'),
				''
			);
			$flash['status'] = ($update_count > 0) ? 'success' : 'error';
			$flash['message'] = text_output($message);
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		$config['base_url'] = site_url('messages/sent/');
		$config['total_rows'] = $this->pm->count_pms($this->session->userdata('userid'), 'sent');
		$config['per_page'] = 25;
		$config['full_tag_open'] = '<p class="fontMedium bold">';
		$config['full_tag_close'] = '</p>';
	
		// initialize the pagination library
		$this->pagination->initialize($config);
		
		// create the page links
		$data['outbox_pagination'] = $this->pagination->create_links();
		
		// get the inbox data
		$outbox = $this->pm->get_outbox($this->session->userdata('userid'), $config['per_page'], $offset);
		
		$data['header'] = ucwords(lang('actions_sent').' '.lang('global_privatemessages'));
		
		$data['images'] = array(
			'write' => array(
				'src' => Location::img('mail-message-new.png', $this->skin, 'admin'),
				'alt' => lang('actions_write'),
				'class' => 'image inline_img_left'),
			'clock' => array(
				'src' => Location::img('clock.png', $this->skin, 'admin'),
				'alt' => '*',
				'class' => 'image inline_img_left'),
			'user' => array(
				'src' => Location::img('user.png', $this->skin, 'admin'),
				'alt' => '*',
				'class' => 'image inline_img_left'),
			'preview' => array(
				'src' => Location::img('magnifier-medium.png', $this->skin, 'admin'),
				'alt' => '[?]',
				'class' => 'image'),
		);
		
		$data['button'] = array(
			'outbox' => array(
				'type' => 'submit',
				'class' => 'button-sec',
				'name' => 'outbox',
				'value' => 'remove',
				'content' => ucwords(lang('actions_remove'))),
		);
		
		if ($outbox->num_rows() > 0)
		{
			$datestring = $this->options['date_format'];
			$data['outbox_check_all'] = array(
				'name' => 'outbox_check_all',
				'id' => 'outbox_check_all'
			);
			
			foreach ($outbox->result() as $item)
			{
				$date = gmt_to_local($item->privmsgs_date, $this->timezone, $this->dst);
				
				// get the chacter IDs
				$recipients_array = $this->pm->get_message_recipients($item->privmsgs_id, 'character');
				
				// make it a string
				$recipients_string = (is_array($recipients_array)) ? implode(',', $recipients_array) : false;
				
				// get the list of characters
				$recipients = $this->char->get_authors($recipients_string, true, true);
				
				$data['outbox'][$item->privmsgs_id]['id'] = $item->privmsgs_id;
				$data['outbox'][$item->privmsgs_id]['recipients'] = $recipients;
				$data['outbox'][$item->privmsgs_id]['subject'] = $item->privmsgs_subject;
				$data['outbox'][$item->privmsgs_id]['date'] = mdate($datestring, $date);
				$data['outbox'][$item->privmsgs_id]['preview'] = nl2br(htmlspecialchars(strip_tags(word_limiter($item->privmsgs_content, 100))));
				$data['outbox'][$item->privmsgs_id]['checkbox'] = array(
					'name' => 'outbox_'. $item->privmsgs_id,
					'value' => $item->privmsgs_id,
					'class' => 'outbox',
				);
			}
		}
		
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'search',
				'id' => 'submitSearch',
				'content' => ucfirst(lang('actions_search'))),
			'search' => array(
				'name' => 'search_terms',
				'id' => 'search_terms',
				'placeholder' => ucfirst(lang('actions_search').'...')),
		);
		
		$data['loader'] = array(
			'src' => Location::img('loading-bar.gif', $this->skin, 'admin'),
			'alt' => lang('actions_loading'),
		);
		
		$data['label'] = array(
			'inbox' => ucwords(lang('labels_inbox').' '.RARROW),
			'loading' => ucfirst(lang('actions_loading')) .'...',
			'message_preview' => ucwords(lang('labels_message').' '.lang('labels_preview')),
			'no_outbox' => sprintf(lang('error_not_found'), lang('global_privatemessages')),
			'search' => ucfirst(lang('actions_search')),
			'write' => ucwords(lang('actions_write') .' '. lang('status_new') .' '. lang('labels_message')),
		);
		
		$this->_regions['content'] = Location::view('messages_sent', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('messages_sent_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
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
			
			if ( ! $recipients or ( ! is_array($recipients) and count($recipients) == 0))
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
			foreach ($characters->result() as $item)
			{
				if ($item->crew_type == 'active')
				{
					$data['characters'][$item->userid] = $this->char->get_character_name($item->main_char, true);
				}
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
				// how many times does the RE: string appear in the subject?
				$re_count = substr_count($row->privmsgs_subject, lang('abbr_reply'));
				
				// make sure the subject is set right
				$subj = ($re_count == 0) ? lang('abbr_reply').': '.$row->privmsgs_subject : $row->privmsgs_subject;
				
				// set the subject value
				$data['inputs']['subject']['value'] = $subj;
				
				// set the user
				$selected = $row->privmsgs_author_user;
				
				// grab the key for the array
				$key = (array_key_exists($selected, $data['characters'])) ? $selected : 0;
				
				// set the key
				$data['recipient_list'] = $key;
				
				$data['header'] = ucfirst(lang('actions_reply')).' '.lang('labels_to').' '.ucwords(lang('global_privatemessage'));
				
				$date = gmt_to_local($row->privmsgs_date, $this->timezone, $this->dst);
				
				// set the data for the previous PM
				$data['previous'] = array(
					'from' => $this->char->get_character_name($row->privmsgs_author_character, false, false, true),
					'date' => mdate($this->options['date_format'], $date),
					'content' => $row->privmsgs_content
				);
			break;
			
			case 'replyall':
				// add the author to the recipients list
				$recipient_list[] = $row->privmsgs_author_user;
				
				// find if the current user is listed in the recipient list
				$key = array_search($this->session->userdata('userid'), $recipient_list);
				
				// drop the current user off the recipient list
				if ($key !== false)
				{
					unset($recipient_list[$key]);
				}
				
				// set the hidden TO field
				$data['recipient_list'] = $recipient_list;
				
				// how many times does the RE: string appear in the subject?
				$re_count = substr_count($row->privmsgs_subject, lang('abbr_reply'));
				
				// make sure the subject is set right
				$subj = ($re_count == 0) ? lang('abbr_reply').': '.$row->privmsgs_subject : $row->privmsgs_subject;
				
				// set the subject value
				$data['inputs']['subject']['value'] = $subj;
				
				$data['header'] = ucfirst(lang('actions_reply')).' '.lang('labels_to').' '.ucwords(lang('global_privatemessage'));
				
				$date = gmt_to_local($row->privmsgs_date, $this->timezone, $this->dst);
				
				// set the data for the previous PM
				$data['previous'] = array(
					'from' => $this->char->get_character_name($row->privmsgs_author_character, false, false, true),
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
				
				// how many times does the FWD: string appear in the subject?
				$re_count = substr_count($row->privmsgs_subject, lang('abbr_forward'));
				
				// make sure the subject is set right
				$subj = ($re_count == 0) ? lang('abbr_forward').': '.$row->privmsgs_subject : $row->privmsgs_subject;
				
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
		$message = $this->parser->parse_string($em_loc, $email_data, true);
		
		// for use by the email library
		$to = implode(',', $emails);
		
		// set the parameters for sending the email
		$this->email->from(Util::email_sender(), $from_name);
		$this->email->to($to);
		$this->email->reply_to($from_email);
		$this->email->subject($subject);
		$this->email->message($message);
		
		// send the email
		$email = $this->email->send();
		
		return $email;
	}
}
