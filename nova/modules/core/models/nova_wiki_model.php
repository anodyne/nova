<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Wiki model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_wiki_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}
	
	public function get_all_contributors($id = '')
	{
		$this->db->from('wiki_drafts');
		$this->db->where('draft_page', $id);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $q)
			{
				$array[] = $q->draft_author_user;
			}
			
			$retval = array_unique($array);
			
			return $retval;
		}
		
		return false;
	}
	
	public function get_categories()
	{
		$query = $this->db->get('wiki_categories');
		
		return $query;
	}
	
	public function get_category($id = '', $return = '')
	{
		$query = $this->db->get_where('wiki_categories', array('wikicat_id' => $id));
		
		$row = ($query->num_rows() > 0) ? $query->row() : false;
		
		if ( ! empty($return) && $row !== false)
		{
			if ( ! is_array($return))
			{
				return $row->$return;
			}
			else
			{
				$array = array();
				
				foreach ($return as $r)
				{
					$array[$r] = $row->$r;
				}
				
				return $array;
			}
		}
		
		return $row;
	}
	
	public function get_comment($id = '', $return = '')
	{
		$query = $this->db->get_where('wiki_comments', array('wcomment_id' => $id));
		
		$row = ($query->num_rows() > 0) ? $query->row() : false;
		
		if ( ! empty($return) && $row !== false)
		{
			if ( ! is_array($return))
			{
				return $row->$return;
			}
			else
			{
				$array = array();
				
				foreach ($return as $r)
				{
					$array[$r] = $row->$r;
				}
				
				return $array;
			}
		}
		
		return $row;
	}
	
	public function get_comments($id = '', $status = 'activated')
	{
		$this->db->from('wiki_comments');
		
		if ( ! empty($id))
		{
			$this->db->where('wcomment_page', $id);
		}
		
		if ( ! empty($status))
		{
			$this->db->where('wcomment_status', $status);
		}
		
		$this->db->order_by('wcomment_date', 'desc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_draft($id = '')
	{
		$query = $this->db->get_where('wiki_drafts', array('draft_id' => $id));
		
		return $query;
	}
	
	/**
	 * Get all the drafts for a specific page or all the drafts in the database.
	 *
	 * @param	mixed	the ID of the page to pull the drafts for
	 * @return	object
	 */
	public function get_drafts($id = '')
	{
		$this->db->from('wiki_drafts');
		
		if ( ! empty($id))
		{
			$this->db->where('draft_page', $id);
		}
		
		$this->db->order_by('draft_created_at', 'desc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_page($id = '')
	{
		$this->db->from('wiki_pages');
		$this->db->join('wiki_drafts', 'wiki_drafts.draft_id = wiki_pages.page_draft');
		$this->db->where('page_id', $id);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_pages($category = null, $order = 'wiki_drafts.draft_title', $sort = 'asc')
	{
		$this->db->from('wiki_pages');
		$this->db->join('wiki_drafts', 'wiki_drafts.draft_id = wiki_pages.page_draft');
		
		if ($category !== null)
		{
			if ($category == 0)
			{
				$this->db->where('wiki_drafts.draft_categories', '');
				$this->db->or_where('wiki_drafts.draft_categories', '0');
			}
			else
			{
				$table = $this->db->dbprefix('wiki_drafts');
				
				$string = "(". $table .".draft_categories LIKE '%,$category' OR ". $table .".draft_categories LIKE '$category,%' OR ". $table .".draft_categories = $category)";
			
				$this->db->where("($string)", null);
			}
		}
		
		$this->db->order_by($order, $sort);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Pull back the page restrictions for a specific page or for all pages.
	 *
	 * @since	2.0
	 * @param	integer	the page id
	 * @return	object
	 */
	public function get_page_restrictions($id = null)
	{
		$this->db->from('wiki_restrictions');
		
		if ($id !== null)
		{
			$this->db->where('restr_page', $id);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_recently_created($limit = 10)
	{
		$this->db->from('wiki_pages');
		$this->db->join('wiki_drafts', 'wiki_drafts.draft_id = wiki_pages.page_draft');
		$this->db->where('page_created_at >', '');
		$this->db->order_by('page_created_at', 'desc');
		
		if ($limit > 0)
		{
			$this->db->limit($limit);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_recently_updated($limit = 10)
	{
		$this->db->from('wiki_pages');
		$this->db->join('wiki_drafts', 'wiki_drafts.draft_id = wiki_pages.page_draft');
		$this->db->where('page_updated_at >', '');
		$this->db->order_by('page_updated_at', 'desc');
		
		if ($limit > 0)
		{
			$this->db->limit($limit);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Get a system page by its key
	 *
	 * @since	2.0
	 * @param	string	the key of the system page to pull
	 * @return	object
	 */
	public function get_system_page($key)
	{
		$this->db->from('wiki_pages');
		$this->db->join('wiki_drafts', 'wiki_drafts.draft_id = wiki_pages.page_draft');
		$this->db->where('page_key', $key);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		
		return false;
	}
	
	public function count_all_comments($status = 'activated', $id = '')
	{
		$this->db->from('wiki_comments');
		$this->db->where('wcomment_status', $status);
		
		if ( ! empty($id))
		{
			$this->db->where('wcomment_page', $id);
		}
		
		return $this->db->count_all_results();
	}
	
	/**
	  * Run through the wiki pages and execute a search on a component to find
	  * a given string.
	  *
	  * @param	string	the field to search (title or content)
	  * @param	string	the string to search for
	  * @return	object	query object
	  */
	public function search_pages($component = '', $input = '')
	{
		// get all the pages
		$pages = $this->get_pages();
		
		if ($pages->num_rows() > 0)
		{
			foreach ($pages->result() as $p)
			{
				if ($p->page_type == 'standard')
				{
					$allpages[] = $p->page_draft;
				}
			}
			
			// make a string of latest drafts
			$drafts = implode(', ', $allpages);
		}
		
		switch ($component)
		{
			case 'title':
				// set the table name
				$table = $this->db->dbprefix('wiki_drafts');
				
				if (isset($drafts))
				{
					$sql = "SELECT * FROM $table WHERE draft_title LIKE '%$input%' AND draft_id IN ($drafts)";
				}
				else
				{
					$sql = "SELECT * FROM $table WHERE draft_title LIKE '%$input%'";
				}
				
				$query = $this->db->query($sql);
			break;
				
			case 'content':
				// set the table name
				$table = $this->db->dbprefix('wiki_drafts');
				
				if (isset($drafts))
				{
					$sql = "SELECT * FROM $table WHERE draft_content LIKE '%$input%' AND draft_id IN ($drafts)";
				}
				else
				{
					$sql = "SELECT * FROM $table WHERE draft_content LIKE '%$input%'";
				}
				
				$query = $this->db->query($sql);
			break;
		}
		
		return $query;
	}
	
	public function create_category($data = '')
	{
		$query = $this->db->insert('wiki_categories', $data);
		
		return $query;
	}
	
	public function create_comment($data = '')
	{
		$query = $this->db->insert('wiki_comments', $data);
		
		$this->dbutil->optimize_table('wiki_comments');
		
		return $query;
	}
	
	public function create_draft($data = '')
	{
		$query = $this->db->insert('wiki_drafts', $data);
		
		return $query;
	}
	
	public function create_page($data = '')
	{
		$query = $this->db->insert('wiki_pages', $data);
		
		return $query;
	}
	
	/**
	 * Create a page restriction record.
	 *
	 * @since	2.0
	 * @param	mixed	an array or object of information to go into the database
	 * @return	integer
	 */
	public function create_page_restriction($data = '')
	{
		$query = $this->db->insert('wiki_restrictions', $data);
		
		return $query;
	}
	
	public function update_category($id = '', $data = '')
	{
		$this->db->where('wikicat_id', $id);
		$query = $this->db->update('wiki_categories', $data);
		
		$this->dbutil->optimize_table('wiki_categories');
		
		return $query;
	}
	
	public function update_comment($id = '', $data = '')
	{
		$this->db->where('wcomment_id', $id);
		$query = $this->db->update('wiki_comments', $data);
		
		$this->dbutil->optimize_table('wiki_comments');
		
		return $query;
	}
	
	public function update_page($id = '', $data = '')
	{
		$this->db->where('page_id', $id);
		$query = $this->db->update('wiki_pages', $data);
		
		$this->dbutil->optimize_table('wiki_pages');
		
		return $query;
	}
	
	/**
	 * Update a page restriction record.
	 *
	 * @since	2.0
	 * @param	integer the page ID to update
	 * @param	mixed	the array/object of data to update with
	 * @return	integer
	 */
	public function update_page_restriction($id, $data)
	{
		$this->db->where('restr_page', $id);
		$query = $this->db->update('wiki_restrictions', $data);
		
		$this->dbutil->optimize_table('wiki_restrictions');
		
		return $query;
	}
	
	public function delete_category($id = '')
	{
		$query = $this->db->delete('wiki_categories', array('wikicat_id' => $id));
		
		$this->dbutil->optimize_table('wiki_categories');
		
		return $query;
	}
	
	public function delete_comment($id = '', $type = 'comment')
	{
		switch ($type)
		{
			case 'comment':
				$this->db->where('wcomment_id', $id);
			break;
				
			case 'page':
				$this->db->where('wcomment_page', $id);
			break;
		}
		
		$query = $this->db->delete('wiki_comments');
		
		$this->dbutil->optimize_table('wiki_comments');
		
		return $query;
	}
	
	public function delete_draft($id = '', $type = 'draft')
	{
		switch ($type)
		{
			case 'array_draft':
				if (is_array($id))
				{
					foreach ($id as $i)
					{
						$this->db->or_where('draft_id', $i);
					}
				}
			break;
				
			case 'array_page':
				if (is_array($id))
				{
					foreach ($id as $i)
					{
						$this->db->or_where('draft_page', $i);
					}
				}
			break;
				
			case 'draft':
				$this->db->where('draft_id', $id);
			break;
				
			case 'page':
				$this->db->where('draft_page', $id);
			break;
		}
		
		$query = $this->db->delete('wiki_drafts');
		
		$this->dbutil->optimize_table('wiki_drafts');
		
		return $query;
	}
	
	public function delete_page($id = '')
	{
		$drafts = $this->delete_comment($id, 'page');
		
		$drafts = $this->delete_draft($id, 'page');
		
		$query = $this->db->delete('wiki_pages', array('page_id' => $id));
		
		$this->dbutil->optimize_table('wiki_pages');
		
		return $query;
	}
	
	/**
	 * Delete a page restriction.
	 *
	 * @since	2.0
	 * @param	integer	the page ID to remove
	 * @return	integer
	 */
	public function delete_page_restriction($id)
	{
		$query = $this->db->delete('wiki_restrictions', array('restr_page' => $id));
		
		$this->dbutil->optimize_table('wiki_restrictions');
		
		return $query;
	}
}
