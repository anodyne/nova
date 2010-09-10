<?php
/*
|---------------------------------------------------------------
| MESSAGES MODEL
|---------------------------------------------------------------
|
| File: models/messages_model_base.php
| System Version: 1.0
|
| Model used to access the messages table to retrieve and update
| messages used by the system.
|
*/

class Messages_model_base extends Model {

	function Messages_model_base()
	{
		parent::Model();
		
		/* load the db utility library */
		$this->load->dbutil();
	}
	
	/*
	|---------------------------------------------------------------
	| RETRIEVE METHODS
	|---------------------------------------------------------------
	*/

	function get_message($message_key = '')
	{
		$query = $this->db->get_where('messages', array('message_key' => $message_key));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->message_content;
		}
		
		return FALSE;
	}
	
	function get_message_label($message_id = '')
	{
		$query = $this->db->get_where('messages', array('message_id' => $message_id));
		$row = $query->row();
		
		return $row->message_label;
	}
	
	function get_message_details($identifier = '', $type = 'key')
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
	
	function get_all_messages()
	{
		$query = $this->db->get_where('messages', array('message_protected' => 'n'));
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| CREATE METHODS
	|---------------------------------------------------------------
	*/

	function insert_new_message($data = '')
	{
		$query = $this->db->insert('messages', $data);
		
		$this->dbutil->optimize_table('messages');
		
		return $this->db->affected_rows();
	}
	
	/*
	|---------------------------------------------------------------
	| UPDATE METHODS
	|---------------------------------------------------------------
	*/

	function update_message($data = '', $id = '', $type = 'key')
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
	
	/*
	|---------------------------------------------------------------
	| DELETE METHODS
	|---------------------------------------------------------------
	*/

	function delete_message($id = '')
	{
		$query = $this->db->delete('messages', array('message_id' => $id)); 
		
		$this->dbutil->optimize_table('messages');
		
		return $this->db->affected_rows();
	}
}

/* End of file messages_model_base.php */
/* Location: ./application/models/base/messages_model_base.php */