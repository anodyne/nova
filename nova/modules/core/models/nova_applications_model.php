<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Applications model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_applications_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}
	
	public function get_application($id = '')
	{
		$query = $this->db->get_where('applications', array('app_id' => $id));
		
		return $query;
	}
	
	public function get_applications()
	{
		$this->db->from('applications');
		$this->db->order_by('app_date', 'desc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function count_applications()
	{
		$this->db->from('applications');
		
		return $this->db->count_all_results();
	}
	
	public function insert_application($data = '')
	{
		$query = $this->db->insert('applications', $data);
		
		$this->dbutil->optimize_table('applications');
		
		return $query;
	}
	
	public function update_application($id = '', $data = '', $identifier = 'app_character')
	{
		$this->db->where($identifier, $id);
		$query = $this->db->update('applications', $data);
		
		$this->dbutil->optimize_table('applications');
		
		return $query;
	}
}
