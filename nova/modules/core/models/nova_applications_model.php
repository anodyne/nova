<?php
/**
 * Applications model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		1.0
 */

abstract class Nova_applications_model extends Model {

	public function __construct()
	{
		parent::Model();
		
		$this->load->dbutil();
	}
	
	/**
	 * Retrieve methods
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
	
	/**
	 * Count methods
	 */
	
	function count_applications()
	{
		$this->db->from('applications');
		
		return $this->db->count_all_results();
	}
	
	/**
	 * Create methods
	 */

	function insert_application($data = '')
	{
		$query = $this->db->insert('applications', $data);
		
		$this->dbutil->optimize_table('applications');
		
		return $query;
	}
	
	/**
	 * Update methods
	 */

	function update_application($id = '', $data = '', $identifier = 'app_character')
	{
		$this->db->where($identifier, $id);
		$query = $this->db->update('applications', $data);
		
		$this->dbutil->optimize_table('applications');
		
		return $query;
	}
}
