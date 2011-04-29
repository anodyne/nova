<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The Menu class handles building and rendering all of the menus found in the
 * system.
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		3.0
 */

abstract class Nova_Menu {
	
	/**
	 * The only entry point into the class. This method will call one of the
	 * private methods to do all the heavy lifting of generating the menus.
	 *
	 *     echo Menu::build('sub', 'personnel');
	 *
	 * @access	public
	 * @uses	Cache::instance
	 * @uses	Cache::get
	 * @param	string	the type of menu to build (main, sub, adminsub)
	 * @param	string	the category of menu to build
	 * @return 	mixed	an unordered list with all the menu items or false if an invalid type is supplied
	 */
	public static function build($type, $cat)
	{
		// get an instance of the cache module
		$cache = Cache::instance();
		
		switch ($type)
		{
			case 'main':
				$menu = ($cache->get('menu_main')) ? $cache->get('menu_main') : self::_build_main();
			break;
				
			case 'sub':
				$menu = ($cache->get('menu_sub')) ? $cache->get('menu_sub') : self::_build_sub($cat);
			break;
				
			case 'adminsub':
				$menu = ($cache->get('menu_adminsub')) ? $cache->get('menu_adminsub') : self::_build_sub_admin($cat);
			break;
			
			default:
				$menu = false;
			break;
		}
		
		return $menu;
	}
	
	/**
	 * Build Nova's main menu.
	 *
	 * @access	private
	 * @uses	Session::instance
	 * @uses	Session::get
	 * @uses	Jelly::query
	 * @uses	Cache::instance
	 * @uses	Cache::get
	 * @uses	Cache::set
	 * @return	mixed	the menu to output or false if there are no menu items
	 */
	private static function _build_main()
	{
		// grab the session
		$session = Session::instance();
		
		// get the user id from the session
		$userid = $session->get('userid');
		
		// get the menu items
		$items = Model_Menu::find()
			->where('type', 'main')
			->where('display', 1)
			->order_by('group', 'asc')
			->order_by('order', 'asc')
			->get();
		
		if ($items)
		{
			foreach ($items as $item)
			{
				$data[$item->order] = $item;
			}
			
			// render the final output
			$final = self::_render('main', $data);
			
			// if the main menu isn't cached, cache it
			if ( ! Cache::instance()->get('menu_main'))
			{
				Cache::instance()->set('menu_main', $final);
			}
			
			return $final;
		}
		
		return false;
	}
	
	/**
	 * Build Nova's sub navigation menu.
	 *
	 * @access	private
	 * @uses	Session::instance
	 * @uses	Session::get
	 * @uses	Jelly::query
	 * @uses	Cache::instance
	 * @uses	Cache::get
	 * @uses	Cache::set
	 * @param	string	the category of sub navigation to pull
	 * @return	mixed	the menu to output or false if there are no menu items
	 */
	private static function _build_sub($cat)
	{
		// grab the session
		$session = Session::instance();
		
		// get the user id from the session
		$userid = $session->get('userid');
		
		// get the menu items
		$items = Model_Menu::find()
			->where('type', 'sub')
			->where('category', $cat)
			->where('display', 1)
			->order_by('group', 'asc')
			->order_by('order', 'asc')
			->get();
		
		if ($items)
		{
			foreach ($items as $item)
			{
				$data[$item->order] = $item;
			}
			
			// render the final output
			$final = self::_render('sub', $data);
			
			// if the sub menu isn't cached, cache it
			if ( ! Cache::instance()->get('menu_sub'))
			{
				Cache::instance()->set('menu_sub', $final);
			}
			
			return $final;
		}
		
		return false;
	}
	
	/**
	 * Build Nova's admin sub navigation menu.
	 *
	 * @access	private
	 * @uses	Session::instance
	 * @uses	Session::get
	 * @uses	Jelly::query
	 * @uses	Cache::instance
	 * @uses	Cache::get
	 * @uses	Cache::set
	 * @param	string	the category admin sub navigation to pull
	 * @return	mixed	the menu to output or false if there are no menu items
	 */
	private static function _build_sub_admin($cat)
	{
		// grab the session
		$session = Session::instance();
		
		// get the user id from the session
		$userid = $session->get('userid');
		
		# FIXME: need to convert this over from the core model (which no longer exists)
		
		// load the core model
		$mCore = new Model_Core;
		
		// build the arguments
		$args = array(
			'where' => array(
				array(
					'field' => 'menucat_type',
					'value' => $type),
			),
			'order_by' => array(
				array('menucat_order', 'asc'),
			)
		);
		$categories = $mCore->get_all('menu_categories', $args);
		
		// clear the arguments array
		$args = array();
		
		// build the arguments
		$args = array(
			'join' => array(
				array('menu_categories', 'menu_categories.menucat_menu_cat', 'menu_items.menu_cat', ''),
			),
			'where' => array(
				array(
					'field' => 'menu_type',
					'value' => $type),
				array(
					'field' => 'menu_display',
					'value' => 'y'),
			),
			'order_by' => array(
				'menu_group' => 'asc',
				'menu_order' => 'asc'
			)
		);
		$items = $mCore->get_all('menu_items', $args);
		
		if ($categories)
		{
			foreach ($categories as $c)
			{
				$data[$c->menucat_menu_cat]['name'] = $c->menucat_name;
				
				if ($items)
				{
					foreach ($items as $item)
					{
						if ($c->menucat_menu_cat == $item->menu_cat)
						{
							$data[$c->menucat_menu_cat]['menu'][] = $item;
						}
					}
				}
			}
			
			return self::_render('adminsub', $data);
		}
		
		return false;
	}
	
	/**
	 * Render the specified menu.
	 *
	 * @access	private
	 * @uses	Auth::check_access
	 * @uses	Auth::get_access_level
	 * @uses	Auth::is_logged_in
	 * @uses	Request::current
	 * @uses	Request::uri
	 * @uses	Url::site
	 * @param	string	the type of menu to render
	 * @param	mixed	the data to use for the menu render
	 * @return	string	the menu output
	 */
	private static function _render($type = '', $data = '')
	{
		$output = '<ul>';
		
		switch ($type)
		{
			case 'adminsub':
				foreach ($data as $key => $value)
				{
					if (isset($value['menu']) and count($value['menu']) > 0)
					{
						$output.= '<li class="menu-category">'. $value['name'] .'</li>';
						
						foreach ($value['menu'] as $item)
						{
							if ($item->group != 0 and $item->menu_order == 0)
							{
								$output.= '<li class="spacer"></li>';
							}
							
							if ($item->url_target == 'offsite')
							{
								$target = ' target="_blank"';
								$link = $item->url;
							}
							else
							{
								$target = null;
								$link = url::site($item->url);
							}
							
							$access = Auth::check_access($item->access, false);
							$level = Auth::get_access_level($item->access);
							
							if (($item->use_access == 'y' and $access === true and 
									($item->level > 0 and $level >= $item->level or $item->level == 0)) 
									or $item->use_access == 'n')
							{
								$output.= '<li><a href="' . $link .'"' . $target . '><span>' . $item->name . '</span></a></li>';
							}
						}
						
						$output.= '<li class="spacer"></li>';
					}
				}
				
			break;
				
			case 'main':
				foreach ($data as $k => $item)
				{
					$display = false;
		
					if (($item->needs_login == 'y' and Auth::is_logged_in()) 
							or ($item->needs_login == 'n' and ! Auth::is_logged_in()) 
							or $item->needs_login == 'none')
					{
						if ($item->needs_login == 'y')
						{
							$access = Auth::check_access($item->access, false);
							$level = Auth::get_access_level($item->access);
		
							if (($item->use_access == 'y' and $access === true and 
									($item->level > 0 and $level >= $item->level or $item->level == 0)) 
									or $item->use_access == 'n')
							{
								$display = true;
							}
						}
						else
						{
							$display = true;
						}
					}
		
					if ($display === true)
					{
						$output.= '<li>';
						
						$class = array();
		
						if ($item->url_target == 'onsite')
						{
							$uri = explode('/', Request::current()->uri());
							$cur = explode('/', $item->url);
							
							if ($uri[0] == $cur[0])
							{
								$class[] = 'active';
							}
							
							$target = null;
							$url = Url::site($item->url);
						}
						else
						{
							$target = ' target="_blank"';
							$url = $item->url;
						}
		
						// create a string from the array of classes
						$class_string = implode(' ', $class);
		
						$output.= '<a href="'. $url .'"'. $target .' class="'. $class_string .'"><span>'. $item->name .'</span></a></li>';
					}
				}
				
			break;
				
			case 'sub':
				foreach ($data as $item)
				{
					$display = false;
	
					if ($item->group != 0 and $item->order == 0)
					{
						$output.= '<li class="spacer"></li>';
					}
	
					if ($item->url_target == 'offsite')
					{
						$target = ' target="_blank"';
						$link = $item->url;
					}
					else
					{
						$target = null;
						$link = Url::site($item->url);
					}
	
					if (($item->needs_login == 'y' and Auth::is_logged_in()) 
							or ($item->needs_login == 'n' and ! Auth::is_logged_in()) 
							or $item->needs_login == 'none')
					{
						if ($item->needs_login == 'y')
						{
							$access = Auth::check_access($item->access, false);
							$level = Auth::get_access_level($item->access);
	
							if (($item->use_access == 'y' and $access === true and 
									($item->level > 0 and $level >= $item->level or $item->level == 0)) 
									or $item->use_access == 'n')
							{
								$display = true;
							}
						}
						else
						{
							$display = true;
						}
					}
	
					if ($display === true)
					{
						$output.= '<li><a href="' . $link .'"' . $target . '><span>' . $item->name . '</span></a></li>';
					}
				}
			
			break;
		}
		
		$output.= '</ul>';
		
		return $output;
	}
}
