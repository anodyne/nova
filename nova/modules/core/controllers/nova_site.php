<?php
/**
 * Admin controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		2.0
 */

require_once MODPATH.'core/libraries/Nova_controller_admin'.EXT;

abstract class Nova_site extends Nova_controller_admin {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function roles($action = false, $id = false)
	{
		// check access
		Auth::check_access();
		
		// load the resources
		$this->load->model('access_model', 'access');
		
		// sanity checks
		$values = array('add', 'delete', 'edit', 'duplicate');
		$action = (in_array($action, $values)) ? $action : false;
		$id = (is_numeric($id)) ? $id : false;
		
		if (isset($_POST['submit']))
		{
			switch ($action)
			{
				case 'add':
					$name = $this->input->post('role_name', TRUE);
					$desc = $this->input->post('role_desc', TRUE);
					
					foreach ($_POST as $key => $value)
					{
						if (substr($key, 0, 5) == 'page_')
						{
							$pages[$key] = $value;
						}
					}
					
					$string = implode(',', $pages);
					
					$insert_array = array(
						'role_name' => $name,
						'role_desc' => $desc,
						'role_access' => $string
					);
					
					$insert = $this->access->insert_role($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_role')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('labels_role')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'delete':
					$id = $this->input->post('id', TRUE);
					$new_role = $this->input->post('new_role', TRUE);
				
					/* insert the record */
					$delete = $this->access->delete_role($id);
					
					if ($delete > 0)
					{
						$update_data = array('access_role' => $new_role);
						$where = array('access_role' => $id);
						
						$users = $this->user->update_all_users($update_data, $where);
						
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_role')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('labels_role')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'edit':
					$name = $this->input->post('role_name', TRUE);
					$desc = $this->input->post('role_desc', TRUE);
					
					foreach ($_POST as $key => $value)
					{
						if (substr($key, 0, 5) == 'page_')
						{
							$pages[$key] = $value;
						}
					}
					
					$string = implode(',', $pages);
					
					$update_array = array(
						'role_name' => $name,
						'role_desc' => $desc,
						'role_access' => $string
					);
					
					$update = $this->access->update_role($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_role')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('labels_role')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'duplicate':
					$new_name = $this->input->post('name', TRUE);
					$new_desc = $this->input->post('desc', TRUE);
					$old_role = $this->input->post('role', TRUE);
					
					$role = $this->access->get_role($old_role);
					
					$insert_array = array(
						'role_name' => $new_name,
						'role_desc' => $new_desc,
						'role_access' => $role->role_access
					);
					
					$insert = $this->access->insert_role($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_role')),
							lang('actions_duplicated'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('labels_role')),
							lang('actions_duplicated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		if ($action == 'edit' or $action == 'add')
		{
			$pages = $this->access->get_role_pages();
			
			if ($action == 'edit')
			{
				$role = $this->access->get_role($id);
			}
			
			$page_array = (isset($role)) ? explode(',', $role->role_access) : array();
			
			if ($pages->num_rows() > 0)
			{
				foreach ($pages->result() as $page)
				{
					$data['pages']['group'][$page->page_group]['group'] = $this->access->get_group($page->page_group, 'group_name');
					$data['pages']['group'][$page->page_group]['pages'][$page->page_id]['id'] = $page->page_id;
					$data['pages']['group'][$page->page_group]['pages'][$page->page_id]['name'] = $page->page_name;
					$data['pages']['group'][$page->page_group]['pages'][$page->page_id]['url'] = $page->page_url;
					$data['pages']['group'][$page->page_group]['pages'][$page->page_id]['desc'] = $page->page_desc;
					$data['pages']['group'][$page->page_group]['pages'][$page->page_id]['checked'] = (in_array($page->page_id, $page_array) ? true : false);
				}
				
				$data['inputs'] = array(
					'name' => array(
						'name' => 'role_name',
						'id' => 'role_name',
						'value' => (isset($role)) ? $role->role_name : ''),
					'desc' => array(
						'name' => 'role_desc',
						'id' => 'role_desc',
						'value' => (isset($role)) ? $role->role_desc : '',
						'rows' => 2),
				);
				
				$data['id'] = $id;
				$data['action'] = $action;
				
				$data['button_submit'] = array(
					'type' => 'submit',
					'class' => 'button-main',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit'))
				);
				
				// set the view that's being used
				$view_loc = 'site_roles_action';
			}
		}
		else
		{
			// run the methods
			$roles = $this->access->get_roles();
			
			if ($roles->num_rows() > 0)
			{
				foreach ($roles->result() as $role)
				{
					$data['roles'][$role->role_id]['id'] = $role->role_id;
					$data['roles'][$role->role_id]['name'] = $role->role_name;
					$data['roles'][$role->role_id]['desc'] = $role->role_desc;
				}
			}
			
			// set the view that's being used
			$view_loc = 'site_roles';
		}
		
		switch ($action)
		{
			case 'add':
				$data['header'] = ucwords(lang('actions_add') .' '. lang('labels_role'));
				$data['text'] = lang('text_roles');
			break;
				
			case 'edit':
				$data['header'] = ucwords(lang('actions_edit') .' '. lang('labels_role'));
				$data['text'] = lang('text_roles');
			break;
				
			default:
				$data['header'] = ucfirst(lang('labels_roles'));
				$data['text'] = lang('text_roles');
			break;
		}
		
		$data['images'] = array(
			'add' => array(
				'src' => Location::img('role-add.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image inline_img_left'),
			'edit' => array(
				'src' => Location::img('role-edit.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image'),
			'delete' => array(
				'src' => Location::img('role-delete.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image'),
			'view' => array(
				'src' => Location::img('role-view.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image'),
			'pages' => array(
				'src' => Location::img('page.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image inline_img_left'),
		);
		
		$data['label'] = array(
			'add' => ucwords(lang('actions_add') .' '. lang('labels_role') .' '. RARROW),
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '. 
				ucfirst(lang('labels_roles')),
			'delete' => ucfirst(lang('actions_delete')),
			'desc' => ucfirst(lang('labels_desc')),
			'duplicate' => ucfirst(lang('actions_duplicate')),
			'duplicate_role' => ucwords(lang('actions_duplicate') .' '. lang('labels_role')),
			'edit' => ucfirst(lang('actions_edit')),
			'manage_pages' => ucwords(lang('actions_manage') .' '. lang('labels_role') .' '. 
				lang('labels_pages') .' '. RARROW),
			'name' => ucfirst(lang('labels_name')),
			'pages' => ucfirst(lang('labels_pages')),
			'view' => ucfirst(lang('actions_view')),
		);
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_roles_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
}
