<?php
/**
 * Admin/Forms Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */

class Controller_Nova_Manage_Forms extends Controller_Nova_Admin_Manage {
	
	public function before()
	{
		parent::before();
		
		// access check
		//Auth::check_access('manage/forms');
	}
	
	/**
	 * The forms index displays a full list of all the forms available in
	 * the database. Selecting one of those forms will take you to a page
	 * where you can edit the form.
	 */
	public function action_index()
	{
		// create a new content view
		$this->_data = View::factory(Location::view('admin/manage/forms/index', $this->skin, 'pages'));
		
		// pull all of the forms
		$this->_data->forms = Model_Form::find('all');
		
		// title, header and message content
		$this->_data->title = (array_key_exists($this->request->action(), $this->_titles)) 
			? $this->_titles[$this->request->action()] 
			: ucwords(___("manage forms"));
			
		$this->_data->header = (array_key_exists($this->request->action(), $this->_headers)) 
			? $this->_headers[$this->request->action()] 
			: ucwords(___("manage forms"));
			
		$this->_data->message = (array_key_exists($this->request->action(), $this->_messages)) 
			? $this->_messages[$this->request->action()] 
			: null;
	}
	
	/**
	 * The edit form page displays the form passed in through the URL and
	 * gives admins the ability to add, delete, move, and edit fields on
	 * the form.
	 */
	public function action_edit()
	{
		// the form we're dealing with
		$form = $this->request->param('id');
		
		// get the form fields
		$fields = Model_FormField::get_fields($form);
		
		// create a new content view
		$this->_data = View::factory(Location::view('admin/manage/forms/index', $this->skin, 'pages'));
		
		// title, header and message content
		$this->_data->title = (array_key_exists($this->request->action(), $this->_titles)) 
			? $this->_titles[$this->request->action()] 
			: ucwords(___("manage forms"));
			
		$this->_data->header = (array_key_exists($this->request->action(), $this->_headers)) 
			? $this->_headers[$this->request->action()] 
			: ucwords(___("manage forms"));
			
		$this->_data->message = (array_key_exists($this->request->action(), $this->_messages)) 
			? $this->_messages[$this->request->action()] 
			: null;
	}
	
	/**
	 * The field page displays the selected field (passed in through the
	 * URL) and gives admins the ability to edit the properties of the
	 * field.
	 */
	public function action_field()
	{
		// create a new content view
		$this->_data = View::factory(Location::view('admin/manage/forms/field', $this->skin, 'pages'));
		
		// what field are we editing?
		$id = (is_numeric($this->request->param('id'))) ? $this->request->param('id') : false;
		
		// get the field
		$this->_data->field = Model_FormField::find($id);
		
		// title, header and message content
		$this->_data->title = (array_key_exists($this->request->action(), $this->_titles)) 
			? $this->_titles[$this->request->action()] 
			: ucwords(___("manage forms"));
			
		$this->_data->header = (array_key_exists($this->request->action(), $this->_headers)) 
			? $this->_headers[$this->request->action()] 
			: ucwords(___("manage forms"));
			
		$this->_data->message = (array_key_exists($this->request->action(), $this->_messages)) 
			? $this->_messages[$this->request->action()] 
			: null;
	}
}
