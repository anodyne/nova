<?php
/**
 * Private messages model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */

abstract class Nova_privmsgs_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}

	public function get_inbox($id = '', $limit, $offset)
	{
		$this->db->from('privmsgs_to');
		$this->db->join('privmsgs', 'privmsgs.privmsgs_id = privmsgs_to.pmto_message');
		$this->db->where('pmto_recipient_user', $id);
		$this->db->where('pmto_display', 'y');
		$this->db->order_by('privmsgs_date', 'desc');
		$this->db->limit($limit, $offset);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_outbox($id = '')
	{
		$this->db->from('privmsgs');
		$this->db->where('privmsgs_author_user', $id);
		$this->db->where('privmsgs_author_display', 'y');
		$this->db->order_by('privmsgs_date', 'desc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_message_recipients($id = '')
	{
		$query = $this->db->get_where('privmsgs_to', array('pmto_message' => $id));
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$array[] = $row->pmto_recipient_user;
			}
			
			return $array;
		}
		
		return false;
	}
	
	public function get_message($id = '')
	{
		$this->db->from('privmsgs_to');
		$this->db->join('privmsgs', 'privmsgs.privmsgs_id = privmsgs_to.pmto_message');
		$this->db->where('privmsgs_id', $id);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_messages_for_id($id = '')
	{
		$query = $this->db->get_where('privmsgs_to', array('pmto_message' => $id));
		
		return $query;
	}
	
	/**
	 * Count private messages
	 *
	 * @access	public
	 * @since	2.0
	 * @param	int		the user ID
	 * @param	string	the inbox, outbox or unread
	 * @return	int		how many results were found
	 */
	public function count_pms($id, $type)
	{
		switch ($type)
		{
			case 'inbox':
				$this->db->from('privmsgs_to');
				$this->db->where('pmto_recipient_user', $id);
				$this->db->where('pmto_display', 'y');
			break;
			
			case 'sent':
				$this->db->from('privmsgs');
				$this->db->where('privmsgs_author_user', $id);
				$this->db->where('privmsgs_author_display', 'y');
			break;
			
			case 'unread':
				$this->db->from('privmsgs_to');
				$this->db->where('pmto_recipient_user', $id);
				$this->db->where('pmto_display', 'y');
				$this->db->where('pmto_unread', 'y');
			break;
		}
		
		return $this->db->count_all_results();
	}
	
	/**
	 * Count unread private messages. This is an alias to count_pms.
	 *
	 * @deprecated
	 * @access	public
	 */
	public function count_unread_pms($id = '')
	{
		return $this->count_pms($id, 'unread');
	}
	
	public function insert_pm_recipients($data = '')
	{
		$query = $this->db->insert('privmsgs_to', $data);
		
		$this->dbutil->optimize_table('privmsgs_to');
		
		return $this->db->affected_rows();
	}
	
	public function insert_private_message($data = '')
	{
		$query = $this->db->insert('privmsgs', $data);
		
		return $this->db->affected_rows();
	}
	
	public function update_message($id = '', $user = '', $data = '')
	{
		$this->db->where('pmto_message', $id);
		$this->db->where('pmto_recipient_user', $user);
		$query = $this->db->update('privmsgs_to', $data);
		
		return $query;
	}
	
	public function update_private_message($id = '', $data = '')
	{
		$this->db->where('privmsgs_id', $id);
		$query = $this->db->update('privmsgs', $data);
		
		return $query;
	}
	
	public function update_to_message($id = '', $user = '', $data = '')
	{
		$this->db->where('pmto_id', $id);
		$this->db->where('pmto_recipient_user', $user);
		$query = $this->db->update('privmsgs_to', $data);
		
		return $query;
	}
}
