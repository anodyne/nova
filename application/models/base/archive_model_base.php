<?php
/*
|---------------------------------------------------------------
| ARCHIVE MODEL
|---------------------------------------------------------------
|
| File: models/base/archive_model_base.php
| System Version: 1.0
|
| Model used to access the old SMS installation
|
*/

class Archive_model_base extends Model {

	function Archive_model_base()
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
	
	function get_sms_version()
	{
		$query = $this->db->query('SELECT * FROM sms_system WHERE sysid = 1');
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
		
			return $row->sysVersion;
		}
		
		return FALSE;
	}
}

/* End of file archive_model.php */
/* Location: ./application/models/base/archive_model_base.php */