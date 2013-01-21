<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Upload controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

require_once MODPATH.'core/libraries/Nova_controller_admin.php';

abstract class Nova_upload extends Nova_controller_admin {
	
	public function __construct()
	{
		parent::__construct();
		
		// load the resources
		$this->load->library('upload');
		$this->config->load('upload');
	}
	
	public function index()
	{
		Auth::check_access();
		
		if (isset($_POST['submit']))
		{
			// images can't have _, - or = because of the way jquery serializes data for the sortable plugin
			$_FILES['userfile']['name'] = str_replace('_', '', $_FILES['userfile']['name']);
			$_FILES['userfile']['name'] = str_replace('-', '', $_FILES['userfile']['name']);
			$_FILES['userfile']['name'] = str_replace('=', '', $_FILES['userfile']['name']);
			
			$upload_data = array(
				'type' => $this->input->post('type', true),
				'field' => 'userfile',
			);
			
			$upload = $this->_do_upload($upload_data);
			
			if ( ! is_array($upload))
			{
				$message = sprintf(
					lang('flash_failure'),
					ucfirst(lang('labels_file')),
					lang('actions_uploaded'),
					' '. $upload
				);

				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			else
			{
				$upload_array = array(
					'upload_filename' => $upload['file_name'],
					'upload_mime_type' => $upload['file_type'],
					'upload_resource_type' => $upload_data['type'],
					'upload_user' => $this->session->userdata('userid'),
					'upload_ip' => $this->input->ip_address(),
					'upload_date' => now()
				);
				
				$uploadrec = $this->sys->add_upload_record($upload_array);
				
				$message = sprintf(
					lang('flash_success'),
					ucfirst(lang('labels_file')),
					lang('actions_uploaded'),
					''
				);

				$flash['status'] = 'success';
				$flash['message'] = text_output($message);
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		$data['button'] = array(
			'upload' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_upload'))),
		);
		
		$data['inputs'] = array(
			'file' => array(
				'name' => 'userfile',
				'id' => 'userfile',
				'class' => 'file'),
		);
		
		$data['header'] = ucwords(lang('actions_upload') .' '. lang('labels_image'));
		
		$data['text'] = sprintf(
			lang('text_upload_image'),
			$this->config->item('max_size'),
			$this->config->item('max_width'),
			$this->config->item('max_height'),
			(Auth::check_access('upload/manage', false)) ? sprintf(lang('text_upload_admin'), APPFOLDER) : ''
		);
		
		$data['label'] = array(
			'img_awards' => ucwords(lang('global_award') .' '. lang('labels_image')),
			'img_char' => ucwords(lang('global_character') .' '. lang('labels_image')),
			'img_mission' => ucwords(lang('global_mission') .' '. lang('labels_image')),
			'img_specs' => ucwords(lang('global_specification') .' '. lang('labels_image')),
			'img_tour' => ucwords(lang('global_tour') .' '. lang('labels_image')),
			'name' => ucwords(lang('labels_file') .' '. lang('labels_name')),
			'type' => ucwords(lang('labels_image') .' '. lang('labels_type')),
		);
		
		$data['values']['type'] = array();
		
		if (Auth::check_access('manage/awards', false))
		{
			$data['values']['type']['award'] = $data['label']['img_awards'];
		}
		
		if (Auth::check_access('characters/bio', false))
		{
			$data['values']['type']['bio'] = $data['label']['img_char'];
		}
		
		if (Auth::check_access('manage/missions', false))
		{
			$data['values']['type']['mission'] = $data['label']['img_mission'];
		}
		
		if (Auth::check_access('manage/specs', false))
		{
			$data['values']['type']['specs'] = $data['label']['img_specs'];
		}
		
		if (Auth::check_access('manage/tour', false))
		{
			$data['values']['type']['tour'] = $data['label']['img_tour'];
		}
		
		$this->_regions['content'] = Location::view('upload_index', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('upload_index_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function manage()
	{
		Auth::check_access();
		
		if (isset($_POST['submit']))
		{
			$remove = (isset($_POST['delete'])) ? $_POST['delete'] : array();
			
			$delete = 0;
			$delete_file = 0;
			
			// load the resources
			$this->load->library('ftp');
			
			if ($this->ftp->hostname != 'ftp.example.com')
			{
				// start the ftp connection
				$this->ftp->connect();
			}
			
			foreach ($remove as $r)
			{
				$info = $this->sys->get_item('uploads', 'upload_id', $r);
				
				switch ($info->upload_resource_type)
				{
					case 'bio':
						$location = 'images/characters';
					break;
						
					case 'award':
						$location = 'images/awards';
					break;
						
					case 'mission':
						$location = 'images/missions';
					break;
						
					case 'specs':
						$location = 'images/specs';
					break;
						
					case 'tour':
						$location = 'images/tour';
					break;
				}
				
				$delete += $this->sys->delete_upload_record($r);
				
				if ($this->ftp->hostname != 'ftp.example.com' && $this->config->item('attempt_delete') === true)
				{
					$path = APPPATH .'assets/'. $location .'/'. $info->upload_filename;
					$delete_file += $this->ftp->delete_file($path);
				}
			}
			
			if ($this->ftp->hostname != 'ftp.example.com')
			{
				// close the ftp connection
				$this->ftp->close();
			}
			
			if (count($remove) > 0 && $delete > 0)
			{
				$message = sprintf(
					lang('flash_success_plural'),
					ucfirst(lang('labels_images')),
					lang('actions_removed'),
					($delete_file == 0) ? ' '. lang('text_file_not_deleted') : ''
				);

				$flash['status'] = 'success';
				$flash['message'] = text_output($message);
			}
			elseif (count($remove) > 0 && $delete < 1)
			{
				$message = sprintf(
					lang('flash_failure_plural'),
					ucfirst(lang('labels_images')),
					lang('actions_removed'),
					''
				);

				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			else
			{
				$flash['status'] = '';
				$flash['message'] = '';
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		$data['directory'] = array();
		
		$dir = $this->sys->get_uploaded_images();
		
		if ($dir->num_rows() > 0)
		{
			foreach ($dir->result() as $d)
			{
				switch ($d->upload_resource_type)
				{
					case 'bio':
						$location = 'images/characters';
					break;
						
					case 'award':
						$location = 'images/awards';
					break;
						
					case 'mission':
						$location = 'images/missions';
					break;
						
					case 'specs':
						$location = 'images/specs';
					break;
						
					case 'tour':
						$location = 'images/tour';
					break;
				}
				
				$user = $this->user->get_user($d->upload_user, array('name', 'email'));
				
				$date = gmt_to_local($d->upload_date, $this->timezone, $this->dst);
				
				$data['directory'][$d->upload_resource_type][$d->upload_id] = array(
					'image' => array(
						'src' => Location::asset($location, $d->upload_filename),
						'alt' => $d->upload_filename,
						'class' => 'image image-height-100'),
					'check' => array(
						'name' => 'delete[]',
						'id' => $d->upload_id .'_id',
						'value' => $d->upload_id),
					'filename' => $d->upload_filename,
					'id' => $d->upload_id,
					'is_file' => (!is_file(APPPATH .'assets/'. $location .'/'. $d->upload_filename)) ? FALSE : TRUE,
					'user' => (empty($user['name'])) ? $user['email'] : $user['name'],
					'date' => mdate($this->options['date_format'], $date),
				);
			}
		}
		
		$data['header'] = ucwords(lang('actions_manage') .' '. lang('labels_uploads'));
		
		$data['text'] = lang('text_manage_uploads');
		
		$js_data['tab'] = 0;
		
		switch ($this->uri->segment(3))
		{
			case 'bio':
			default:
				$js_data['tab'] = 0;
			break;
				
			case 'awards':
				$js_data['tab'] = 1;
			break;
				
			case 'missions':
				$js_data['tab'] = 2;
			break;
				
			case 'specs':
				$js_data['tab'] = 3;
			break;
				
			case 'tour':
				$js_data['tab'] = 4;
			break;
		}
		
		$data['access'] = array(
			'awards' => (Auth::check_access('manage/awards', FALSE)) ? TRUE : FALSE,
			'bio' => (Auth::check_access('characters/bio', FALSE)) ? TRUE : FALSE,
			'missions' => (Auth::check_access('manage/missions', FALSE)) ? TRUE : FALSE,
			'specs' => (Auth::check_access('manage/specs', FALSE)) ? TRUE : FALSE,
			'tour' => (Auth::check_access('manage/tour', FALSE)) ? TRUE : FALSE,
		);
		
		$data['button'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))),
		);
		
		$data['label'] = array(
			'awardimages' => ucwords(lang('global_award') .' '. lang('labels_images')),
			'bioimages' => ucwords(lang('labels_bio') .' '. lang('labels_images')),
			'delete' => ucfirst(lang('actions_delete') .'?'),
			'filename' => ucwords(lang('labels_file') .' '. lang('labels_name')),
			'missionimages' => ucwords(lang('global_mission') .' '. lang('labels_images')),
			'noaward' => sprintf(lang('error_not_found'), lang('global_award') .' '. lang('labels_images')),
			'nobio' => sprintf(lang('error_not_found'), lang('labels_bio') .' '. lang('labels_images')),
			'nomission' => sprintf(lang('error_not_found'), lang('global_mission') .' '. lang('labels_images')),
			'nospecs' => sprintf(lang('error_not_found'), lang('global_specification') .' '. lang('labels_images')),
			'notour' => sprintf(lang('error_not_found'), lang('global_tour') .' '. lang('labels_images')),
			'on' => lang('labels_on'),
			'preview' => ucfirst(lang('labels_preview')),
			'specsimages' => ucwords(lang('global_specs') .' '. lang('labels_images')),
			'tourimages' => ucwords(lang('global_tour') .' '. lang('labels_images')),
			'uploadedby' => ucfirst(lang('actions_uploaded') .' '. lang('labels_by')),
			'upload' => ucwords(lang('actions_upload') .' '. lang('labels_images') .' '. RARROW),
		);
		
		$this->_regions['content'] = Location::view('upload_manage', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('upload_manage_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	protected function _do_upload($data)
	{
		switch ($data['type'])
		{
			case 'award':
				$path = APPPATH.'assets/images/awards/';
			break;
				
			case 'bio':
				$path = APPPATH.'assets/images/characters/';
			break;
				
			case 'mission':
				$path = APPPATH.'assets/images/missions/';
			break;
				
			case 'specs':
				$path = APPPATH.'assets/images/specs/';
			break;
				
			case 'tour':
				$path = APPPATH.'assets/images/tour/';
			break;
		}
		
		$this->upload->upload_path = $path;
		
		// do the upload
		$upload = $this->upload->do_upload($data['field']);
		
		// figure out what gets returned
		$retval = ( ! $upload) ? $this->upload->display_errors('', '') : $this->upload->data();
	
		return $retval;
	}
}
