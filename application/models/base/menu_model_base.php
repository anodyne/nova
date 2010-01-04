<?php
/*
|---------------------------------------------------------------
| MENU MODEL
|---------------------------------------------------------------
|
| File: models/menu_model_base.php
| System Version: 1.0
|
| Model used to access the menu table.
|
*/

class Menu_model_base extends Model {

	function Menu_model_base()
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
	
	function get_menu_items($type = '', $cat = '', $display = 'y')
	{
		$this->db->from('menu_items');
		
		if (!empty($type))
		{
			$this->db->where('menu_type', $type);
		}
		
		if (!empty($cat))
		{
			$this->db->where('menu_cat', $cat);
		}
		
		if (!empty($display))
		{
			$this->db->where('menu_display', 'y');
		}
		
		$this->db->order_by('menu_group', 'asc');
		$this->db->order_by('menu_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_menu_item($id = '')
	{
		$query = $this->db->get_where('menu_items', array('menu_id' => $id));
		
		return $query;
	}
	
	function get_menu_categories($type = '')
	{
		$this->db->from('menu_categories');
		
		if (!empty($type))
		{
			$this->db->where('menucat_type', $type);
		}
		
		$this->db->order_by('menucat_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_menu_category($cat_data = '', $cat_field = 'menucat_menu_cat')
	{
		$query = $this->db->get_where('menu_categories', array($cat_field => $cat_data));
		
		$row = ($query->num_rows() > 0) ? $query->row() : FALSE;
		
		return $row;
	}
	
	function get_all_item_categories()
	{
		$this->db->select('menu_cat');
		$this->db->from('menu_items');
		$this->db->group_by('menu_cat');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_admin_menu($type = '')
	{
		$this->db->from('menu_items');
		$this->db->join('menu_categories', 'menu_categories.menucat_menu_cat = menu_items.menu_cat');
		$this->db->where('menu_type', $type);
		$this->db->where('menu_display', 'y');
		$this->db->order_by('menu_group', 'asc');
		$this->db->order_by('menu_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| CREATE METHODS
	|---------------------------------------------------------------
	*/
	
	function add_menu_item($data = '')
	{
		$query = $this->db->insert('menu_items', $data);
		
		$this->dbutil->optimize_table('menu_items');
		
		return $query;
	}
	
	function add_menu_category($data = '')
	{
		$query = $this->db->insert('menu_categories', $data);
		
		$this->dbutil->optimize_table('menu_categories');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| UPDATE METHODS
	|---------------------------------------------------------------
	*/
	
	function update_menu_item($data = '', $where_data = '', $where_field = 'menu_id')
	{
		$this->db->where($where_field, $where_data);
		$query = $this->db->update('menu_items', $data);
		
		$this->dbutil->optimize_table('menu_items');
		
		return $query;
	}
	
	function update_menu_category($data = '', $id = '')
	{
		$this->db->where('menucat_id', $id);
		$query = $this->db->update('menu_categories', $data);
		
		$this->dbutil->optimize_table('menu_categories');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| DELETE METHODS
	|---------------------------------------------------------------
	*/
	
	function delete_menu_item($id = '')
	{
		$query = $this->db->delete('menu_items', array('menu_id' => $id));
		
		$this->dbutil->optimize_table('menu_items');
		
		return $query;
	}
	
	function delete_menu_category($id = '')
	{
		$query = $this->db->delete('menu_categories', array('menucat_id' => $id));
		
		$this->dbutil->optimize_table('menu_categories');
		
		return $query;
	}
}

/* End of file menu_model_base.php */
/* Location: ./application/models/base/menu_model_base.php */