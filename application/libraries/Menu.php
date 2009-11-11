<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| MENU LIBRARY
|---------------------------------------------------------------
|
| File: libraries/Menu.php
| System Version: 1.0
|
| Library that handles generating the system menus from the database.
|
*/

/*
TYPE
	main
	sub
	adminsub

CAT
	main
	personnel
	sim
	wiki
	acp
	site
	manage
	reports
	user
	write
	messages
*/

class Menu {
    
	var $type;
	var $cat;
	var $output;
    
	function Menu()
	{
		/* log the debug message */
		log_message('debug', 'Menu Library Initialized');
	}
	
	function build($type = '', $cat = '')
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		$this->type = $type;
		$this->cat = $cat;
		
		switch ($this->type)
		{
			case 'main':
				$this->_build_main();
				break;
				
			case 'sub':
				$this->_build_sub();
				break;
				
			case 'adminsub':
				$this->_build_sub_admin();
				break;
		}
		
		return $this->output;
	}
	
	function _build_main()
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the session library and assign the user id */
		$this->ci->load->library('session');
		$userid = $this->ci->session->userdata('userid');
		
		/* load the menu model */
		$this->ci->load->model('menu_model');
		
		/* get the headers then get the data below the headers */
		$items = $this->ci->menu_model->get_menu_items($this->type, $this->cat);
		
		$segment = array();
		
		if ($items->num_rows() > 0)
		{ /* create an array with the sub menu data */
			foreach ($items->result() as $item)
			{
				$array[$item->menu_order]['name'] = $item->menu_name;
				$array[$item->menu_order]['login'] = $item->menu_need_login;
				$array[$item->menu_order]['link'] = $item->menu_link;
				$array[$item->menu_order]['link_type'] = $item->menu_link_type;
				
				/* get an array of the URI segments */
				$seg = explode('/', $item->menu_link);
				
				/* set the active element */
				$array[$item->menu_order]['active'] = $seg[0];
			}
		}
		
		/* start the output */
		$this->output = '<ul>';
		
		foreach ($array as $k => $v)
		{
			if ($this->ci->session->userdata('userid') !== FALSE)
			{
				/* check access */
				$access = $this->ci->auth->check_access($v['link'], FALSE, TRUE);
			}
			
			if (($v['login'] == 'y' && $this->ci->session->userdata('userid') === FALSE) ||
					($v['login'] == 'y' && $access === FALSE) ||
					($v['login'] == 'n' && $this->ci->session->userdata('userid') !== FALSE))
			{
				/* do nothing */
			}
			else
			{
				$this->output.= '<li>';
			
				$class = array();
			
				if ($v['active'] == $this->ci->uri->rsegment(1))
				{
					$class[] = 'active';
				}
			
				if ($v['link_type'] == 'onsite')
				{
					$target = NULL;
					$url = site_url($v['link']);
				}
				else
				{
					$target = ' target="_blank"';
					$url = $v['link'];
				}
			
				/* create a string from the array of classes */
				$class_string = implode(' ', $class);
			
				$this->output.= '<a href="'. $url .'"'. $target .' class="'. $class_string .'"><span>'. $v['name'] .'</span></a></li>';
			}
		}
			
		$this->output.= '</ul>'; /* close the menu item UL */
	}
	
	function _build_sub()
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the session library and assign the user id */
		$this->ci->load->library('session');
		$userid = $this->ci->session->userdata('userid');
		
		/* load the menu model */
		$this->ci->load->model('menu_model');
		
		/* get the headers then get the data below the headers */
		$menu_items = $this->ci->menu_model->get_menu_items($this->type, $this->cat);
		
		if ($menu_items->num_rows() > 0)
		{
			$this->output = '<ul>'; /* start the output of the menu */
			
			foreach ($menu_items->result() as $item)
			{
				if ($item->menu_group != 0)
				{
					//$this->output.= '<li class="spacer">&nbsp;</li>';
				}
				
				if ($item->menu_link_type == 'offsite')
				{
					$target = ' target="_blank"';
					$link = $item->menu_link;
				}
				else
				{
					$target = NULL;
					$link = site_url($item->menu_link);
				}
				
				if (($item->menu_need_login == 'y' && $userid !== FALSE) ||
						($item->menu_need_login == 'n' && $userid === FALSE) || $item->menu_need_login == 'none')
				{
					$this->output.= '<li><a href="' . $link .'"' . $target . '><span>' . $item->menu_name . '</span></a></li>';
				}
			} /* close the item foreach */
			
			$this->output.= '</ul>'; /* close the menu output */
		} /* close the num_rows check */
	}
	
	function _build_sub_admin()
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the menu model */
		$this->ci->load->model('menu_model');
		
		/* run the methods */
		$menu_upper = $this->ci->menu_model->get_admin_menu_active($this->type, $this->cat);
		$menu_lower = $this->ci->menu_model->get_admin_menu_inactive($this->type, $this->cat);
		
		if ($menu_upper->num_rows() > 0)
		{
			$this->output = '<ul>';
			
			foreach ($menu_upper->result() as $item)
			{
				if (strstr($this->output, 'li') === FALSE)
				{
					$this->output.= '<li class="menu_category">'. $item->menucat_name .'</li>';
				}
				
				if ($item->menu_group != 0 && $item->menu_order == 0)
				{
					$this->output.= '<li class="spacer">&nbsp;</li>';
				}
				
				if ($item->menu_link_type == 'offsite')
				{
					$target = ' target="_blank"';
					$link = $item->menu_link;
				}
				else
				{
					$target = NULL;
					$link = site_url($item->menu_link);
				}
				
				$access = $this->ci->auth->check_access($item->menu_access, FALSE);
				$level = $this->ci->auth->get_access_level($item->menu_access);
				
				if (($item->menu_use_access == 'y' && $access === TRUE && ($item->menu_access_level > 0 && $level >= $item->menu_access_level || $item->menu_access_level == 0)) || $item->menu_use_access == 'n')
				{
					$this->output.= '<li><a href="' . $link .'"' . $target . '><span>' . $item->menu_name . '</span></a></li>';
				}
			}
			
			foreach ($menu_lower->result() as $item)
			{
				if ($item->menu_group != 0 && $item->menu_order == 0)
				{
					$this->output.= '<li class="spacer">&nbsp;</li>';
				}
				
				if ($item->menu_link_type == 'offsite')
				{
					$target = ' target="_blank"';
					$link = $item->menu_link;
				}
				else
				{
					$target = NULL;
					$link = site_url($item->menu_link);
				}
				
				if ($item->menu_group == 0 && $item->menu_order == 0)
				{
					$this->output.= '<li class="spacer">&nbsp;</li>';
					$this->output.= '<li class="menu_category">'. $item->menucat_name .'</li>';
				}
				
				$access = $this->ci->auth->check_access($item->menu_access, FALSE);
				$level = $this->ci->auth->get_access_level($item->menu_access);
				
				if (($item->menu_use_access == 'y' && $access === TRUE && ($item->menu_access_level > 0 && $level >= $item->menu_access_level || $item->menu_access_level == 0)) || $item->menu_use_access == 'n')
				{
					$this->output.= '<li><a href="' . $link .'"' . $target . '><span>' . $item->menu_name . '</span></a></li>';
				}
			}
			
			$this->output.= '</ul>';
		}
	}
}

/* End of file Menu.php */
/* Location: ./application/libraries/Menu.php */