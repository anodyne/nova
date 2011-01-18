<?php
/*
|---------------------------------------------------------------
| APPLICATIONS MODEL
|---------------------------------------------------------------
|
| File: models/base/applications_model_base.php
| System Version: 1.0
|
| Model used to access the applications tables
|
*/

class Applications_model_base extends Model {

	function Applications_model_base()
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

	function get_application($id = '')
	{
		$query = $this->db->get_where('applications', array('app_id' => $id));
		
		return $query;
	}
	
	function get_applications()
	{
		$this->db->from('applications');
		$this->db->order_by('app_date', 'desc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| COUNT METHODS
	|---------------------------------------------------------------
	*/
	
	function count_applications()
	{
		$this->db->from('applications');
		
		return $this->db->count_all_results();
	}
	
	/*
	|---------------------------------------------------------------
	| CREATE METHODS
	|---------------------------------------------------------------
	*/

	function insert_application($data = '')
	{
		$query = $this->db->insert('applications', $data);
		
		$this->dbutil->optimize_table('applications');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| UPDATE METHODS
	|---------------------------------------------------------------
	*/

	function update_application($id = '', $data = '', $identifier = 'app_character')
	{
		$this->db->where($identifier, $id);
		$query = $this->db->update('applications', $data);
		
		$this->dbutil->optimize_table('applications');
		
		return $query;
	}
}

/* End of file applications_model_base.php */
/* Location: ./application/models/base/applications_model_base.php */