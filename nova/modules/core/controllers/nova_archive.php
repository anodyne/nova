<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Archive controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

require_once MODPATH.'core/libraries/Nova_controller_main.php';

abstract class Nova_archive extends Nova_controller_main {
	
	public function __construct()
	{
		parent::__construct();
		
		// load the resources
		$this->load->model('archive_model', 'arc');
		
		// get the sms version
		$sms = $this->arc->get_sms_version();
		
		if ( ! $sms)
		{
			show_error('SMS is not installed in this database and the archive feature cannot be used!');
		}
		
		$this->_regions['nav_sub'] = Menu::build('sub', 'main');
	}

	public function index()
	{
		$data['message'] = "Please select what you would like to view:\r\n\r\n";
		$data['message'].= anchor('archive/characters', 'Characters') ."\r\n";
		$data['message'].= anchor('archive/database', 'Database Entries') ."\r\n";
		$data['message'].= anchor('archive/decks', 'Deck Listing') ."\r\n";
		$data['message'].= anchor('archive/departments', 'Departments') ."\r\n";
		$data['message'].= anchor('archive/positions', 'Positions');
		
		$data['header'] = 'SMS Archives';
		
		$this->_regions['content'] = Location::view('archive_index', $this->skin, 'main', $data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function characters($type = 'active')
	{
		$data['data'] = $this->arc->get_characters($type);
		
		$data['header'] = 'Archives - '. ucfirst($type) .' Characters';
		
		$this->_regions['content'] = Location::view('archive_characters', $this->skin, 'main', $data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function database($id = false)
	{
		// sanity check
		$id = (is_numeric($id)) ? $id : false;
		
		if ( ! $id)
		{
			// run the methods
			$entries = $this->arc->get_all_db_entries();
			
			if ($entries->num_rows() > 0)
			{
				foreach ($entries->result() as $e)
				{
					$data['entries'][$e->dbid] = array(
						'title' => $e->dbTitle,
						'desc' => $e->dbDesc,
						'type' => $e->dbType
					);
				}
			}
			
			$data['header'] = 'Archives - Database Entries';
		}
		else
		{
			// run the methods
			$entry = $this->arc->get_db_entry($id);
			
			if ($entry->num_rows() > 0)
			{
				$e = $entry->row();
				
				$data['entry'] = array(
					'title' => $e->dbTitle,
					'desc' => $e->dbDesc,
					'content' => $e->dbContent
				);
			}
			
			$data['header'] = 'Archives - Database Entry - '. $e->dbTitle;
		}
		
		$this->_regions['content'] = Location::view('archive_database', $this->skin, 'main', $data);
		$this->_regions['javascript'] = Location::js('archive_database_js', $this->skin, 'main');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function decks()
	{
		// run the methods
		$decks = $this->arc->get_deck_listing();
		
		if ($decks->num_rows() > 0)
		{
			foreach ($decks->result() as $d)
			{
				$data['decks'][$d->deckid] = $d->deckContent;
			}
		}
		
		$data['header'] = 'Archives - Deck Listing';
		
		$this->_regions['content'] = Location::view('archive_decks', $this->skin, 'main', $data);
		$this->_regions['javascript'] = Location::js('archive_decks_js', $this->skin, 'main');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function departments()
	{
		// run the methods
		$depts = $this->arc->get_departments();
		
		if ($depts->num_rows() > 0)
		{
			foreach ($depts->result() as $d)
			{
				$data['depts'][$d->deptid] = array(
					'name' => $d->deptName,
					'desc' => $d->deptDesc
				);
			}
		}
		
		$data['header'] = 'Archives - Departments';
		
		$this->_regions['content'] = Location::view('archive_depts', $this->skin, 'main', $data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function positions($dept = 1)
	{
		// sanity check
		$dept = (is_numeric($dept)) ? $dept : false;
		
		// run the methods
		$positions = $this->arc->get_positions($dept);
		$depts = $this->arc->get_departments();
		
		if ($depts->num_rows() > 0)
		{
			foreach ($depts->result() as $d)
			{
				$deptArray[] = anchor('archive/positions/'. $d->deptid, $d->deptName);
			}
			
			$data['depts'] = implode(' &middot; ', $deptArray);
		}
		
		if ($positions->num_rows() > 0)
		{
			foreach ($positions->result() as $p)
			{
				$data['positions'][$p->positionid] = array(
					'name' => $p->positionName,
					'desc' => $p->positionDesc,
					'open' => $p->positionOpen
				);
			}
		}
		
		$data['header'] = 'Archives - Positions';
		
		$this->_regions['content'] = Location::view('archive_positions', $this->skin, 'main', $data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
}
