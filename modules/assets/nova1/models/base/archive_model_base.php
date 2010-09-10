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
	
	function get_all_db_entries()
	{
		$query = $this->db->query('SELECT * FROM sms_database');
		
		return $query;
	}
	
	function get_characters($type = '')
	{
		$array = array();
		
		$dStatement = "SELECT deptid, deptName FROM sms_departments WHERE deptDisplay = 'y' ORDER BY deptOrder ASC";
		
		$pStatement = "SELECT positionid, positionName, positionDept FROM sms_positions WHERE positionDept = ? AND ";
		$pStatement.= "positionDisplay = 'y' ORDER BY positionOrder ASC";
		
		$cStatement = "SELECT c.*, r.* FROM sms_crew AS c, sms_ranks AS r WHERE c.crewType = ? AND (c.positionid = ? OR c.positionid2 = ?) ";
		$cStatement.= "AND c.rankid = r.rankid ORDER BY c.rankid ASC";
		
		$dQuery = $this->db->query($dStatement);
		
		if ($dQuery->num_rows() > 0)
		{
			foreach ($dQuery->result() as $d)
			{
				$array[$d->deptid]['dept'] = $d->deptName;
				
				$pQuery = $this->db->query($pStatement, array($d->deptid));
				
				if ($pQuery->num_rows() > 0)
				{
					foreach ($pQuery->result() as $p)
					{
						$array[$d->deptid]['positions'][$p->positionid]['position'] = $p->positionName;
						
						$cQuery = $this->db->query($cStatement, array($type, $p->positionid, $p->positionid));
						
						if ($cQuery->num_rows() > 0)
						{
							foreach ($cQuery->result() as $c)
							{
								$array[$d->deptid]['positions'][$p->positionid]['characters'][$c->crewid]['name'] = $c->rankName .' '. $c->firstName .' '. $c->lastName;
							}
						}
					}
				}
			}
		}
		
		return $array;
	}
	
	function get_db_entry($id = '')
	{
		$query = $this->db->query("SELECT * FROM sms_database WHERE dbid = '$id' LIMIT 1");
		
		return $query;
	}
	
	function get_deck_listing()
	{
		$query = $this->db->query('SELECT * FROM sms_tour_decks');
		
		return $query;
	}
	
	function get_departments()
	{
		$query = $this->db->query('SELECT * FROM sms_departments ORDER BY deptOrder ASC');
		
		return $query;
	}
	
	function get_positions($dept = '1')
	{
		$query = $this->db->query('SELECT * FROM sms_positions WHERE positionDept = ? ORDER BY positionOrder ASC', array($dept));
		
		return $query;
	}
	
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