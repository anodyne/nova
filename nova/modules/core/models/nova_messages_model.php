<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Messages model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_messages_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}
	
	public function get_message($message_key = '')
	{
		$query = $this->db->get_where('messages', array('message_key' => $message_key));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->message_content;
		}
		
		return false;
	}
	
	public function get_message_label($message_id = '')
	{
		$query = $this->db->get_where('messages', array('message_id' => $message_id));
		$row = $query->row();
		
		return $row->message_label;
	}
	
	public function get_message_details($identifier = '', $type = 'key')
	{
		switch ($type)
		{
			case 'key':
				$field = 'message_key';
			break;
				
			case 'id':
				$field = 'message_id';
			break;
				
			case 'label':
				$field = 'message_label';
			break;
		}
		
		$this->db->from('messages');
		$this->db->where($field, $identifier);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_all_messages()
	{
		$query = $this->db->get_where('messages', array('message_protected' => 'n'));
		
		return $query;
	}
	
	public function insert_new_message($data = '')
	{
		$query = $this->db->insert('messages', $data);
		
		$this->dbutil->optimize_table('messages');
		
		return $this->db->affected_rows();
	}
	
	/**
	 * Update a single message
	 *
	 * @access	public
	 * @param	array	an array of data to use in updating the record
	 * @param	mixed	the record to update
	 * @param	string	the name of the identifer to use
	 * @return	integer	the number of affected rows (1 = success, 0 = failure)
	 */
	public function update_message($data = '', $id = '', $type = 'key')
	{
		switch ($type)
		{
			case 'key':
				$field = 'message_key';
			break;
				
			case 'id':
				$field = 'message_id';
			break;
				
			case 'label':
				$field = 'message_label';
			break;
		}
		
		$this->db->where($field, $id);
		$query = $this->db->update('messages', $data);
		
		$this->dbutil->optimize_table('messages');
		
		return $this->db->affected_rows();
	}
	
	public function delete_message($id = '')
	{
		$query = $this->db->delete('messages', array('message_id' => $id)); 
		
		$this->dbutil->optimize_table('messages');
		
		return $this->db->affected_rows();
	}
}
