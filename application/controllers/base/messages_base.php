<?php
/*
|---------------------------------------------------------------
| ADMIN - MESSAGES CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/messages_base.php
| System Version: 1.2
|
| Changes: fixed bug where the email sent out didn't contain the
|	content of the private message; fixed bug where pending users
|	would appear in the dropdown for potential recipients of a PM
|
*/

class Messages_base extends Controller {

	/* set the variables */
	var $options;
	var $skin;
	var $rank;
	var $timezone;
	var $dst;

	function Messages_base()
	{
		parent::Controller();
		
		/* load the system model */
		$this->load->model('system_model', 'sys');
		$installed = $this->sys->check_install_status();
		
		if ($installed === FALSE)
		{ /* check whether the system is installed */
			redirect('install/index', 'refresh');
		}
		
		/* load the session library */
		$this->load->library('session');
		
		/* load the models */
		$this->load->model('characters_model', 'char');
		$this->load->model('users_model', 'user');
		
		/* check to see if they are logged in */
		$this->auth->is_logged_in(TRUE);
		
		/* an array of the global we want to retrieve */
		$settings_array = array(
			'skin_admin',
			'display_rank',
			'timezone',
			'daylight_savings',
			'sim_name',
			'date_format',
			'email_subject',
			'system_email'
		);
		
		/* grab the settings */
		$this->options = $this->settings->get_settings($settings_array);
		
		/* set the variables */
		$this->skin = $this->options['skin_admin'];
		$this->rank = $this->options['display_rank'];
		$this->timezone = $this->options['timezone'];
		$this->dst = (bool) $this->options['daylight_savings'];
		
		if ($this->auth->is_logged_in())
		{
			$this->skin = (file_exists(APPPATH .'views/'.$this->session->userdata('skin_admin').'/template_admin'.EXT))
				? $this->session->userdata('skin_admin')
				: $this->skin;
			$this->rank = $this->session->userdata('display_rank');
			$this->timezone = $this->session->userdata('timezone');
			$this->dst = (bool) $this->session->userdata('dst');
		}
		
		/* set and load the language file needed */
		$this->lang->load('app', $this->session->userdata('language'));
		
		/* set the template */
		$this->template->set_template('admin');
		$this->template->set_master_template($this->skin .'/template_admin.php');
		
		/* write the common elements to the template */
		$this->template->write('nav_main', $this->menu->build('main', 'main'), TRUE);
		$this->template->write('nav_sub', $this->menu->build('adminsub', 'messages'), TRUE);
		$this->template->write('panel_1', $this->user_panel->panel_1(), TRUE);
		$this->template->write('panel_2', $this->user_panel->panel_2(), TRUE);
		$this->template->write('panel_3', $this->user_panel->panel_3(), TRUE);
		$this->template->write('panel_workflow', $this->user_panel->panel_workflow(), TRUE);
		$this->template->write('title', $this->options['sim_name'] . ' :: ');
	}

	function index()
	{
		/* check access */
		$this->auth->check_access();
		
		/* load the helpers */
		$this->load->helper('text');
		
		/* load the models */
		$this->load->model('privmsgs_model', 'pm');
		
		if (isset($_POST['inbox']) || isset($_POST['outbox']))
		{
			if (isset($_POST['inbox']))
			{
				$update_count = 0;
				
				foreach ($_POST as $k => $v)
				{
					if (substr($k, 0, 6) == 'inbox_')
					{
						/* build the update array */
						$update_array = array(
							'pmto_display' => 'n',
							'pmto_unread' => 'n'
						);
						
						/* do the update */
						$update = $this->pm->update_to_message($v, $this->session->userdata('userid'), $update_array);
						
						if ($update > 0)
						{
							/* increment the update count */
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
				
				/* write everything to the template */
				$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
			}
			
			if (isset($_POST['outbox']))
			{
				$update_count = 0;
				
				foreach ($_POST as $k => $v)
				{
					if (substr($k, 0, 7) == 'outbox_')
					{
						/* build the update array */
						$update_array = array('privmsgs_author_display' => 'n');
						
						/* do the update */
						$update = $this->pm->update_private_message($v, $update_array);
						
						if ($update > 0)
						{
							/* increment the update count */
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
				
				/* write everything to the template */
				$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
			}
		}
		
		/* run the methods */
		$inbox = $this->pm->get_inbox($this->session->userdata('userid'));
		$outbox = $this->pm->get_outbox($this->session->userdata('userid'));
		
		/* set the data used by the view */
		$data['header'] = ucwords(lang('global_privatemessages'));
		
		/* set the images */
		$data['images'] = array(
			'write' => array(
				'src' => img_location('mail-message-new.png', $this->skin, 'admin'),
				'alt' => lang('actions_write'),
				'class' => 'image inline_img_left'),
			'unread' => array(
				'src' => img_location('mail-unread.png', $this->skin, 'admin'),
				'alt' => '*',
				'class' => 'image')
		);
		
		/* set the buttons */
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
				$data['inbox'][$item->pmto_id]['author'] = $this->char->get_character_name($item->privmsgs_author_character, TRUE);
				$data['inbox'][$item->pmto_id]['subject'] = $item->privmsgs_subject;
				$data['inbox'][$item->pmto_id]['blurb'] = word_limiter($item->privmsgs_content, 15);
				$data['inbox'][$item->pmto_id]['date'] = mdate($datestring, $date);
				$data['inbox'][$item->pmto_id]['unread'] = ($item->pmto_unread == 'y') ? img($data['images']['unread']) : FALSE;
				$data['inbox'][$item->pmto_id]['checkbox'] = array(
					'name' => 'inbox_'. $item->pmto_id,
					'value' => $item->pmto_id,
					'class' => 'inbox'
				);
			}
		}
		
		if ($outbox->num_rows() > 0)
		{
			/* set the date format */
			$datestring = $this->options['date_format'];
			$data['outbox_check_all'] = array(
				'name' => 'outbox_check_all',
				'id' => 'outbox_check_all'
			);
			
			foreach ($outbox->result() as $item)
			{
				/* get the messages */
				$messages = $this->pm->get_messages_for_id($item->privmsgs_id);
				
				if ($messages->num_rows() > 0)
				{
					$array = array();
					
					foreach ($messages->result() as $msg)
					{
						$array[] = $this->char->get_character_name($msg->pmto_recipient_character, TRUE);
					}
				}
				
				$to = implode(' &amp; ', $array);
				
				/* start to the build the date */
				$date = gmt_to_local($item->privmsgs_date, $this->timezone, $this->dst);
				
				/* build the data used */
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
		
		/* set the js data */
		$js_data['tab'] = ($this->uri->segment(3) == 'sent') ? 1 : 0;
		
		$data['loader'] = array(
			'src' => img_location('loading-bar.gif', $this->skin, 'admin'),
			'alt' => lang('actions_loading'),
		);
		
		$data['label'] = array(
			'from' => ucfirst(lang('time_from')),
			'inbox' => ucwords(lang('labels_inbox')),
			'loading' => ucfirst(lang('actions_loading')) .'...',
			'no_inbox' => lang('error_no_inbox'),
			'no_outbox' => lang('error_no_outbox'),
			'sent' => ucwords(lang('actions_sent') .' '. lang('labels_messages')),			
			'subject' => ucfirst(lang('labels_subject')),
			'to' => ucfirst(lang('labels_to')),
			'write' => ucwords(lang('actions_write') .' '. lang('status_new') .' '. lang('labels_message')),
		);
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('messages_index', $this->skin, 'admin');
		$js_loc = js_location('messages_index_js', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc, $js_data);
		
		/* render the template */
		$this->template->render();
	}
	
	function read()
	{
		/* check access */
		$this->auth->check_access('messages/index');
		
		/* set the variables */
		$id = $this->uri->segment(3, FALSE, TRUE);
		
		/* load the resources */
		$this->load->model('privmsgs_model', 'pm');
		
		/* run the methods */
		$message = $this->pm->get_message($id);
		
		if ($message->num_rows() > 0)
		{
			/* get the data */
			$row = $message->row();
			
			/* get the recipients array */
			$recips = $this->pm->get_message_recipients($row->privmsgs_id);
			
			/* set the date format */
			$datestring = $this->options['date_format'];
			
			/* the person trying to view must either be the author or a recipient of the PM */
			if ($row->privmsgs_author_user == $this->session->userdata('userid') ||
					in_array($this->session->userdata('userid'), $recips))
			{
				/* start to the build the date */
				$date = gmt_to_local($row->privmsgs_date, $this->timezone, $this->dst);
				
				$data['id'] = $row->privmsgs_id;
				$data['header'] = text_output($row->privmsgs_subject, 'h1', 'page-head');
				$data['content'] = $row->privmsgs_content;
				$data['date'] = mdate($datestring, $date);
				$data['author'] = $this->char->get_character_name($row->privmsgs_author_character, TRUE);
				
				foreach ($recips as $rec)
				{
					$array[] = $this->char->get_character_name($this->user->get_main_character($rec), TRUE);
				}
				
				$to = implode(' &amp; ', $array);
				
				/* set the TO variable */
				$data['to'] = $to;
				
				/* images */
				$data['images'] = array(
					'reply' => array(
						'src' => img_location('mail-reply-sender.png', $this->skin, 'admin'),
						'alt' => '',
						'class' => 'image inline_img_left'),
					'reply_all' => array(
						'src' => img_location('mail-reply-all.png', $this->skin, 'admin'),
						'alt' => '',
						'class' => 'image inline_img_left'),
					'forward' => array(
						'src' => img_location('mail-forward.png', $this->skin, 'admin'),
						'alt' => '',
						'class' => 'image inline_img_left')
				);
				
				if (in_array($this->session->userdata('userid'), $recips))
				{
					$update_array = array('pmto_unread' => 'n');
					$update = $this->pm->update_message($id, $this->session->userdata('userid'), $update_array);
				}
			
				/* write the data to the template */
				$this->template->write('title', ucwords(lang('global_privatemessage')) .' - '.  $row->privmsgs_subject);
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
			
			/* write the data to the template */
			$this->template->write('title', lang('error_pagetitle'));
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
		
		/* figure out where the view JS files should be coming from */
		$view_loc = view_location('messages_read', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function write()
	{
		/* check access */
		$this->auth->check_access('messages/index');
		
		/* load the models */
		$this->load->model('privmsgs_model', 'pm');
		
		if ($this->options['system_email'] == 'off')
		{
			$flash['status'] = 'info';
			$flash['message'] = lang_output('flash_system_email_off');
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
		}
		
		/* set the action array */
		$action_array = array('reply', 'replyall', 'forward');
		
		/* set the variables */
		$action = (in_array($this->uri->segment(3), $action_array)) ? $this->uri->segment(3) : FALSE;
		$id = $this->uri->segment(4, FALSE, TRUE);
		$data['key'] = '';
		$message = FALSE;
		$subject = FALSE;
		
		if (isset($_POST['submit']))
		{
			/* define the POST variables */
			$subject = $this->input->post('subject', TRUE);
			$message = $this->input->post('message', TRUE);
			$author = $this->input->post('recipients', TRUE);
			$authors = $this->input->post('to', TRUE);
			
			if ($author == 0 && $authors == 0)
			{
				$flash['status'] = 'error';
				$flash['message'] = lang_output('flash_privmsgs_no_recipient');
				
				/* write everything to the template */
				$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
			}
			else
			{
				/* put the authors into an array */
				$authors_array = explode(',', $authors);
				
				foreach ($authors_array as $key => $value)
				{ /* make sure there aren't any empty values */
					if (!is_numeric($value) || $value < 1)
					{
						unset($authors_array[$key]);
					}
				}
				
				/* count the authors */
				$authors_count = count($authors_array);
				
				/* see which author set to use */
				$to = ($authors_count == 0) ? $author : implode(',', $authors_array);
				
				/* build the insert array */
				$insert_array = array(
					'privmsgs_author_user' => $this->session->userdata('userid'),
					'privmsgs_author_character' => $this->session->userdata('main_char'),
					'privmsgs_date' => now(),
					'privmsgs_subject' => $subject,
					'privmsgs_content' => $message
				);
				
				/* do the insert */
				$insert = $this->pm->insert_private_message($insert_array);
				
				/* get the message ID */
				$msgid = $this->db->insert_id();
				
				/* optimize the table */
				$this->sys->optimize_table('privmsgs');
				
				/* create an array of who the PM is going to */
				$recipients = explode(',', $to);
				
				foreach ($recipients as $value)
				{ /* go through and add records for every recipient */
					$insert_array = array(
						'pmto_message' => $msgid,
						'pmto_recipient_user' => $value,
						'pmto_recipient_character' => $this->user->get_main_character($value)
					);
					
					/* do the insert */
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
					
					/* set the array of data for the email */
					$email_data = array(
						'author' => $this->session->userdata('main_char'),
						'subject' => $subject,
						'to' => $to,
						'message' => $message
					);
					
					/* send the email */
					$email = ($this->options['system_email'] == 'on') ? $this->_email($email_data) : FALSE;
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
				
				/* write everything to the template */
				$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
			}
			
			/* reset the message and subject variables */
			$message = FALSE;
			$subject = FALSE;
		}
		
		/* run the methods */
		$characters = $this->user->get_main_characters();
		
		if ($characters->num_rows() > 0)
		{
			$data['characters'][0] = ucfirst(lang('actions_select')) .' '. lang('labels_a') .' '. ucfirst(lang('labels_recipient'));
			
			/* we do this to make sure active characters are on top */
			$data['characters'][ucwords(lang('status_active') .' '. lang('global_characters'))] = array();
			$data['characters'][ucwords(lang('status_inactive') .' '. lang('global_characters'))] = array();
			
			foreach ($characters->result() as $item)
			{
				if ($item->status != 'pending')
				{
					$type = ($item->status == 'active')
						? ucwords(lang('status_active') .' '. lang('global_characters')) 
						: ucwords(lang('status_inactive') .' '. lang('global_characters'));
						
					$data['characters'][$type][$item->userid] = $this->char->get_character_name($item->main_char, TRUE);
				}
			}
			
			/* make sure there's something in the inactive section */
			if (count($data['characters'][ucwords(lang('status_inactive') .' '. lang('global_characters'))]) == 0)
			{
				unset($data['characters'][ucwords(lang('status_inactive') .' '. lang('global_characters'))]);
			}
		}
		
		/* set the data used by the view */
		$data['inputs'] = array(
			'subject' => array(
				'name' => 'subject',
				'id' => 'subject',
				'value' => $subject),
			'message' => array(
				'name' => 'message',
				'id' => 'message',
				'rows' => 20,
				'value' => $message),
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* build the remove image */
		$remove = array(
			'src' => img_location('minus-circle.png', $this->skin, 'admin'),
			'class' => 'image fontSmall inline_img_left',
			'alt' => ucfirst(lang('actions_remove'))
		);
		
		/* prep the data for sending to the js view */
		$js_data['remove'] = img($remove);
		
		/* get the data if it is not a new PM */
		$info = ($action !== FALSE) ? $this->pm->get_message($id) : FALSE;
		$row = ($info !== FALSE && $info->num_rows() > 0) ? $info->row() : FALSE;
		$recipient_list = ($action == 'reply' || $action == 'replyall') ? $this->pm->get_message_recipients($id) : FALSE;
		
		/* make sure the person is allowed to be replying */
		if ($recipient_list !== FALSE)
		{
			if (!in_array($this->session->userdata('userid'), $recipient_list) &&
					!($this->session->userdata('userid') == $row->privmsgs_author_user))
			{
				redirect('admin/error/3');
			}
		}
		
		switch ($action)
		{
			case 'reply':
				/* set the hidden TO field */
				$data['to'] = 0;
				
				/* set the subject value */
				$data['inputs']['subject']['value'] = lang('abbr_reply') .': '. $row->privmsgs_subject;
				
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
				$data['key'] = $key;
					
				$this->load->helper('debug');
				
				/* set the header */
				$data['header'] = ucfirst(lang('actions_reply')) .' '. lang('labels_to') 
					.' '. ucwords(lang('global_privatemessage'));
				
				/* set the date */
				$date = gmt_to_local($row->privmsgs_date, $this->timezone, $this->dst);
				
				/* set the data for the previous PM */
				$data['previous'] = array(
					'from' => $this->char->get_character_name($row->privmsgs_author_character),
					'date' => mdate($this->options['date_format'], $date),
					'content' => $row->privmsgs_content
				);
				
				break;
			
			case 'replyall':
				/* set the hidden TO field */
				$data['to'] = implode(',', $recipient_list) .','. $row->privmsgs_author_user;
				
				/* send an array to the js view for disabling items in the list */
				$js_data['replyall'] = explode(',', $data['to']);
				
				/* set the recipients list */
				$to_array = explode(',', $data['to']);
				
				$i = 1;
				foreach ($to_array as $value)
				{
					$to_name = $this->char->get_character_name($this->user->get_main_character($value), TRUE);
					
					$data['recipient_list'][$i] = '<span class="'. $value .'">';
					$data['recipient_list'][$i].= '<a href="#" id="remove_recipient" class="image" myID="'. $value .'" myName="'.  $to_name .'">';
					$data['recipient_list'][$i].= img($remove) .'</a>';
					$data['recipient_list'][$i].= $to_name .'<br /></span>';
					
					++$i;
				}
				
				/* set the subject value */
				$data['inputs']['subject']['value'] = lang('abbr_reply') .': '. $row->privmsgs_subject;
				
				/* set the header */
				$data['header'] = ucfirst(lang('actions_reply')) .' '. lang('labels_to') 
					.' '. ucwords(lang('global_privatemessage'));
				
				/* set the date */
				$date = gmt_to_local($row->privmsgs_date, $this->timezone, $this->dst);
				
				/* set the data for the previous PM */
				$data['previous'] = array(
					'from' => $this->char->get_character_name($row->privmsgs_author_character),
					'date' => mdate($this->options['date_format'], $date),
					'content' => $row->privmsgs_content
				);
				
				break;
				
			case 'forward':
				/* set the hidden TO field */
				$data['to'] = 0;
				
				/* build an array to hold the recipients */
				$to_array = $this->pm->get_message_recipients($id);
				
				foreach ($to_array as $rec)
				{
					$array[] = $this->char->get_character_name($this->user->get_main_character($rec), TRUE);
				}
				
				/* create a string of character names */
				$to = implode(' &amp; ', $array);
				
				/* set the date */
				$date = gmt_to_local($row->privmsgs_date, $this->timezone, $this->dst);
				
				/* set the textarea value */
				$data['inputs']['message']['value'] = "\r\n\r\n\r\n==========\r\n\r\n";
				$data['inputs']['message']['value'].= ucfirst(lang('time_from')) .': ';
				$data['inputs']['message']['value'].= $this->char->get_character_name($row->privmsgs_author_character, TRUE);
				$data['inputs']['message']['value'].= "\r\n". ucfirst(lang('labels_to')) .': '. $to;
				$data['inputs']['message']['value'].= "\r\n". ucfirst(lang('labels_on')) .' ';
				$data['inputs']['message']['value'].= mdate($this->options['date_format'], $date);
				$data['inputs']['message']['value'].= "\r\n\r\n". $row->privmsgs_content;
				
				/* set the subject value */
				$data['inputs']['subject']['value'] = lang('abbr_forward') .': '. $row->privmsgs_subject;
				
				/* set the header */
				$data['header'] = ucfirst(lang('actions_forward')) .' '. ucwords(lang('global_privatemessage'));
				
				break;
				
			default:
				$data['to'] = 0;
				$data['header'] = ucwords(lang('actions_write') .' '. lang('global_privatemessage'));
		}
		
		$data['label'] = array(
			'add' => ucwords(lang('actions_add') .' '. lang('labels_recipient')),
			'inbox' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '.
				ucfirst(lang('labels_inbox')),
			'message' => ucfirst(lang('labels_message')),
			'on' => ucfirst(lang('labels_on')),
			'subject' => ucfirst(lang('labels_subject')),
			'to' => ucfirst(lang('labels_to')),
			'wrote' => lang('actions_wrote') .':',
		);
		
		/* figure out where the view JS files should be coming from */
		$view_loc = view_location('messages_write', $this->skin, 'admin');
		$js_loc = js_location('messages_write_js', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc, $js_data);
		$this->template->write('title', $data['header']);
		
		/* render the template */
		$this->template->render();
	}
	
	function _email($data = '')
	{
		/* load the libraries */
		$this->load->library('email');
		$this->load->library('parser');
		
		/* define the variables */
		$email = FALSE;
		
		/* load the models */
		$this->load->model('users_model', 'user');
		$this->load->model('characters_model', 'char');
		
		/* create an array from the data TO var and prep the emails array */
		$email_start = explode(',', $data['to']);
		$emails = array();
		
		/* set the temp array */
		$array = array();
		
		foreach ($email_start as $em)
		{ /* get the emails */
			$emails[$em] = $this->user->get_email_address('user', $em);
		}
		
		foreach ($emails as $key => $email)
		{ /* get the character names and narrow the email array based on prefs */
			$array[] = $this->char->get_character_name($this->user->get_main_character($key), TRUE, TRUE);
			
			/* get their prefs */
			$pref = $this->user->get_pref('email_private_message', $key);
			
			if ($pref == 'y')
			{
				/* don't do anything */
			}
			else
			{
				unset($emails[$key]);
			}
		}
		
		/* set some variables */
		$from_name = $this->char->get_character_name($data['author'], TRUE, TRUE);
		$from_email = $this->user->get_email_address('character', $data['author']);
		$subject = $this->options['email_subject'] .' '. lang('email_subject_private_message') .' - '. $data['subject'];
		$to_names = implode(', ', $array);
		
		/* set the content */
		$content = sprintf(
			lang('email_content_private_message'),
			$from_name,
			$data['message'],
			site_url('login/index')
		);
		
		/* set the email data */
		$email_data = array(
			'email_subject' => $data['subject'],
			'email_from' => ucfirst(lang('time_from')) .': '. $from_name,
			'email_to' => ucfirst(lang('labels_to')) .': '. $to_names,
			'email_content' => nl2br($content)
		);
		
		/* where should the email be coming from */
		$em_loc = email_location('messages_new', $this->email->mailtype);
		
		/* parse the message */
		$message = $this->parser->parse($em_loc, $email_data, TRUE);
		
		/* for use by the email library */
		$to = implode(',', $emails);
		
		/* set the parameters for sending the email */
		$this->email->from($from_email, $from_name);
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		
		/* send the email */
		$email = $this->email->send();
		
		/* return the email variable */
		return $email;
	}
}

/* End of file messages_base.php */
/* Location: ./application/controllers/messages_base.php */