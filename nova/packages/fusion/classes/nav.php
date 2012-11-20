<?php
/**
 * The Nav class provides an interface for generating navigation
 * menus out of the database, including managing the caching of
 * the navigation for faster load speeds.
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Fusion;

class Nav
{
	/**
	 * @var	array	An array of nav data.
	 */
	protected $data = array();

	/**
	 * @var	array	An array of user data.
	 */
	protected $userData = array();

	/**
	 * @var	string	The output of the final nav.
	 */
	protected $output;

	/**
	 * @var	string	The output of the final user nav.
	 */
	protected $userOutput;

	/**
	 * @var	string	The nav style.
	 */
	protected $style;

	/**
	 * @var	string	The nav type.
	 */
	protected $type;

	/**
	 * @var	string	The nav category.
	 */
	protected $category;

	/**
	 * @var	string	The nav section.
	 */
	protected $section;

	/**
	 * Create a new Nav.
	 *
	 * @param	string	The style of nav (classic or dropdown)
	 * @param	string	The type of nav (main, sub, admin or adminsub)
	 * @param	string	The category of the nav (main, admin, messages, write, etc.)
	 * @param	string	The section of the nav (main or admin)
	 * @return	void
	 */
	public function __construct($style = 'dropdown', $type = 'main', $category = 'main', $section = 'main')
	{
		$this->style	= $style;
		$this->type		= $type;
		$this->category	= $category;
		$this->section	= $section;

		// Set the nav data
		$this->setData();

		// Set the user data
		$this->setUserDataAndOutput();
	}

	/**
	 * Build the output of the specified nav.
	 *
	 * @return	string
	 */
	public function build()
	{
		switch ($this->style)
		{
			case 'classic':
				if ($this->type == 'main')
				{
					$output = \View::forge(\Location::file('nav/classic', \Utility::getSkin($this->section), 'partial'))
						->set('items', $this->data[$this->type]['items'][$this->category])
						->set('name', \Model_Settings::getItems('sim_name'))
						->render();
				}
				else
				{
					$output = \View::forge(\Location::file('nav/subnav', \Utility::getSkin($this->section), 'partial'))
						->set('items', $this->data[$this->section][$this->category])
						->render();
				}
			break;
			
			case 'dropdown':
			default:
				$output = \View::forge(\Location::file('nav/dropdown', \Utility::getSkin($this->section), 'partial'))
					->set('items', $this->data)
					->set('name', \Model_Settings::getItems('sim_name'))
					->set('userMenu', $this->userOutput)
					->set('section', $this->section)
					->set('category', $this->category)
					->render();
			break;
		}
		
		return $output;
	}

	/**
	 * Get the nav data.
	 *
	 * @return	array
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Set the nav data.
	 *
	 * @internal
	 * @return	void
	 */
	protected function setData()
	{
		$data = \Model_Nav::find('all');

		foreach ($data as $key => $item)
		{
			$type = $item->type;
			$type = ($type == 'sub') ? 'main' : $type;
			$type = ($type == 'adminsub') ? 'admin' : $type;

			$cat = ($item->type == 'main' or $item->type == 'admin') ? 'items' : $item->category;

			// get the sub nav items under this section
			$sub = ($type == 'sub' or $type == 'adminsub') ? \Model_Nav::getItems($type, $item->category) : false;

			$retval[$type][$cat][$item->id] = $item;

			if (($item->needs_login == 'y' and ! \Sentry::check()) or ($item->needs_login == 'n' and \Sentry::check()))
			{
				unset($retval[$type][$cat][$item->id]);
				unset($retval[$type][$cat][$item->category][$item->id]);
			}

			if ( ! empty($item->access))
			{
				// get the access info for the nav item
				$navaccess = explode('|', $item->access);

				// find if the user has access
				$access = \Sentry::user()->hasAccess("$navaccess[0].$navaccess[1]");

				// find if the user has the proper level
				$level = \Sentry::user()->atLeastLevel("$navaccess[0].$navaccess[1]", $navaccess[2]);

				if ( ! $access or ($access and ! $level))
				{
					unset($retval[$type][$cat][$item->id]);
					unset($retval[$type][$cat][$item->category][$item->id]);
				}
			}
		}

		$this->data = $retval;
	}

	/**
	 * Get the user data.
	 *
	 * @return	array
	 */
	public function getUserData()
	{
		return $this->userData;
	}

	/**
	 * Get the user nav output.
	 *
	 * @return	string
	 */
	public function getUserOutput()
	{
		return $this->userOutput;
	}

	/**
	 * Set the user data and output.
	 *
	 * @internal
	 * @return	void
	 */
	protected function setUserDataAndOutput()
	{
		// Start to build the output
		$output = \View::forge(\Location::file('nav/user', \Utility::getSkin($this->section), 'partial'));

		if (\Sentry::check())
		{
			// Get the user
			$user = \Sentry::user();

			// Get the message count
			$messageCount = 0;

			// Get the writing count
			$writingCount = 0;
			
			// Create a total count
			$total = $writingCount + $messageCount;

			// Figure out what the classes should be
			$totalClass = ($total == 0) ? '' : ' label-warning';
			$writingClass = ($writingCount == 0) ? '' : ' label-warning';
			$messageClass = ($messageCount == 0) ? '' : ' label-important';

			// Figure out the outputs
			$writingOutput = ($writingCount > 0) 
				? \View::forge(\Location::file('common/label', \Utility::getSkin($this->section), 'partial'))
					->set('class', $writingClass)->set('value', $writingCount)->render()
				: false;
			$messageOutput = ($messageCount > 0) 
				? \View::forge(\Location::file('common/label', \Utility::getSkin($this->section), 'partial'))
					->set('class', $messageClass)->set('value', $messageCount)->render()
				: false;

			// Build the list of items that should be in the user nav
			$this->userData = array(
				0 => array(
					array(
						'name' => ucwords(__('cp')),
						'url' => 'admin/index',
						'extra' => array(),
						'additional' => ''),
					array(
						'name' => ucfirst(\Inflector::pluralize(__('notification'))),
						'url' => 'admin/notifications',
						'extra' => array(),
						'additional' => ''),
				),
				1 => array(
					array(
						'name' => ucwords(__('my', array('thing' => __('account')))),
						'url' => 'admin/user/edit/'.\Sentry::user()->id,
						'extra' => array(),
						'additional' => ' <span class="icn icn-50 tooltip-left" data-icon="?" title="'.lang('short.help.user_account').'"></span>'),
					array(
						'name' => ucwords(__('my', array('thing' => \Inflector::pluralize(__('character'))))),
						'url' => 'admin/character/edit',
						'extra' => array(),
						'additional' => ''),
				),
				2 => array(
					array(
						'name' => $messageOutput.ucfirst(\Inflector::pluralize(__('message'))),
						'url' => 'admin/messages',
						'extra' => array(),
						'additional' => ''),
					array(
						'name' => $writingOutput.lang('writing', 1),
						'url' => 'admin/writing',
						'extra' => array(),
						'additional' => ''),
				),
				3 => array(
					array(
						'name' => ucfirst(langConcat('action.request loa')),
						'url' => 'admin/user/loa',
						'extra' => array(),
						'additional' => ''),
					array(
						'name' => ucfirst(langConcat('action.nominate for award')),
						'url' => 'admin/user/nominate',
						'extra' => array(),
						'additional' => ''),
				),
				4 => array(
					array(
						'name' => ucfirst(lang('action.logout')),
						'url' => 'login/logout',
						'extra' => array(),
						'additional' => ''),
				),
			);

			// Set the data for the output
			$output->set('data', $this->userData)
				->set('name', \Sentry::user()->get('name'))
				->set('notifyClass', $totalClass)
				->set('notifyTotal', $total)
				->set('loggedIn', true);
		}
		else
		{
			// Set the data for the output
			$output->set('loggedIn', false)
			 ->set('loginText', ucwords(lang('action.login')));
		}

		// Set the output render to the class variable
		$this->userOutput = $output->render();
	}

	/**
	 * Get the nav style.
	 *
	 * @return	string
	 */
	public function getStyle()
	{
		return $this->style;
	}

	/**
	 * Set the nav style.
	 *
	 * @param	string	The style
	 * @return	Nav
	 */
	public function setStyle($value)
	{
		$this->style = $value;

		return $this;
	}

	/**
	 * Get the nav type.
	 *
	 * @return	string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Set the nav type.
	 *
	 * @param	string	The type
	 * @return	Nav
	 */
	public function setType($value)
	{
		$this->type = $value;

		return $this;
	}

	/**
	 * Get the nav category.
	 *
	 * @return	string
	 */
	public function getCategory()
	{
		return $this->category;
	}

	/**
	 * Set the nav category.
	 *
	 * @param	string	The category
	 * @return	Nav
	 */
	public function setCategory($value)
	{
		$this->category = $value;

		return $this;
	}

	/**
	 * Get the nav section.
	 *
	 * @return	string
	 */
	public function getSection()
	{
		return $this->section;
	}

	/**
	 * Set the nav section.
	 *
	 * @param	string	The section
	 * @return	Nav
	 */
	public function setSection($value)
	{
		$this->section = $value;

		return $this;
	}
}
