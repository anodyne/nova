<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Update Ajax Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 */

class Controller_Updateajax extends Controller_Template {
	
	public $db;
	
	public function before()
	{
		parent::before();
		
		// set the shell
		$this->template = View::factory('_common/layouts/ajax');
		
		// set the variables in the template
		$this->template->content = FALSE;
		
		// get an instance of the database
		$this->db = Database::instance();
		
		// get the n1 prefix
		$this->n1pref = Session::instance()->get('n1pref');
	}
	
	public function action_update_characters()
	{
		// get the characters from n1
		$n1Chars = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'characters', TRUE);
		$n1CharsProm = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'characters_promotions', TRUE);
		$n1CharsTabs = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'characters_tabs', TRUE);
		$n1CharsSections = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'characters_sections', TRUE);
		$n1CharsForm = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'characters_fields', TRUE);
		$n1CharsValues = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'characters_values', TRUE);
		$n1CharsData = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'characters_data', TRUE);
		$n1CharsCOC = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'coc', TRUE);
		
		// figure out how many characters we have tos tart
		$n1CharsCount = $n1Chars->count();
		
		try {
			// set up the saved arrays
			$savedChars = array();
			$savedCharsProm = array();
			$savedFormTabs = array();
			$savedFormSections = array();
			$savedFormFields = array();
			$savedFormValues = array();
			$savedFormData = array();
			$savedCOC = array();
			
			// run through the data
			foreach ($n1Chars as $n)
			{
				$item = Jelly::factory('character')
					->set(array(
						'id' => $n->charid,
						'user' => $n->user,
						'fname' => $n->first_name,
						'mname' => $n->middle_name,
						'lname' => $n->last_name,
						'suffix' => $n->suffix,
						'status' => ($n->crew_type == 'npc') ? 'active' : $n->crew_type,
						'activate' => $n->date_activate,
						'deactivate' => $n->date_deactivate,
						'rank' => $n->rank,
						'position1' => $n->position_1,
						'position2' => $n->position_2,
						'last_post' => $n->last_post
					))
					->save();
				$savedChars[] = (int) $item->saved();
				
				// explode the images string
				$images = explode(',', $n->images);
				
				// insert the image records
				foreach ($images as $i)
				{
					if (!empty($i))
					{
						$item = Jelly::factory('characterimage')
							->set(array(
								'user' => $n->user,
								'character' => $n->charid,
								'image' => $i
							))
							->save();
					}
				}
			}
			
			// do the character promotion updates
			foreach ($n1CharsProm as $p)
			{
				$item = Jelly::factory('characterpromotion')
					->set(array(
						'user' => $p->prom_user,
						'character' => $p->prom_char,
						'old_order' => $p->prom_old_order,
						'old_rank' => $p->prom_old_rank,
						'new_order' => $p->prom_new_order,
						'new_rank' => $p->prom_new_rank,
						'date' => $p->prom_date,
					))
					->save();
				$savedCharsProm[] = (int) $item->saved();
			}
			
			// translation arrays
			$translateTabs = array();
			$translateSections = array();
			$translateFields = array();
			
			// do the form tabs
			foreach ($n1CharsTabs as $t)
			{
				$item = Jelly::factory('formtab')
					->set(array(
						'form' => 'bio',
						'name' => $t->tab_name,
						'order' => $t->tab_order,
						'linkid' => $t->tab_link_id,
						'display' => $t->tab_display
					))
					->save();
				$savedFormTabs[] = (int) $item->saved();
					
				$translateTabs[$t->tab_id] = $item->id();
			}
			
			// do the form sections
			foreach ($n1CharsSections as $s)
			{
				$item = Jelly::factory('formsection')
					->set(array(
						'form' => 'bio',
						'tab' => $translateTabs[$s->section_tab],
						'name' => $s->section_name,
						'order' => $s->section_order,
					))
					->save();
				$savedFormSections[] = (int) $item->saved();
					
				$translateSections[$s->section_id] = $item->id();
			}
			
			// do the form fields
			foreach ($n1CharsForm as $f)
			{
				$item = Jelly::factory('formfield')
					->set(array(
						'form' => 'bio',
						'section' => $translateSections[$f->field_section],
						'type' => $f->field_type,
						'html_name' => $f->field_name,
						'html_id' => $f->field_fid,
						'html_class' => $f->field_class,
						'html_rows' => $f->field_rows,
						'value' => $f->field_value,
						'label' => $f->field_label_page,
						'order' => $f->field_order,
						'display' => $f->field_display,
					))
					->save();
				$savedFormFields[] = (int) $item->saved();
					
				$translateFields[$f->field_id] = $item->id();
			}
			
			// do the form values
			foreach ($n1CharsValues as $v)
			{
				$item = Jelly::factory('formvalue')
					->set(array(
						'field' => $translateFields[$v->value_field],
						'html_value' => $v->value_field_value,
						'selected' => $v->value_selected,
						'content' => $v->value_content,
						'order' => $v->value_order,
					))
					->save();
				$savedFormValues[] = (int) $item->saved();
			}
			
			// do the form data
			foreach ($n1CharsData as $d)
			{
				$item = Jelly::factory('formdata')
					->set(array(
						'form' => 'bio',
						'field' => $translateFields[$d->data_field],
						'user' => $d->data_user,
						'character' => $d->data_char,
						'value' => $d->data_value,
						'last_update' => $d->data_updated
					))
					->save();
				$savedFormData[] = (int) $item->saved();
			}
			
			// do the chain of command
			foreach ($n1CharsCOC as $c)
			{
				$item = Jelly::factory('coc')
					->set(array(
						'character' => $c->coc_crew,
						'order' => $c->coc_order,
					))
					->save();
				$savedCOC[] = (int) $item->saved();
			}
			
			/*if (in_array(FALSE, $saved) && !in_array(TRUE, $saved))
			{
				$retval = array(
					'code' => 0,
					'message' => __("Users were not successfully updated")
				);
			}
			elseif (in_array(FALSE, $saved) && in_array(TRUE, $saved))
			{
				// get an array with the counts of the different values
				$unique = array_count_values($saved);
				
				$retval = array(
					'code' => 2,
					'message' => __(":success of :total users were updated, but the remaining records could not be updated",
						array(':success' => $unique[1], ':total' => $n1UsersCount))
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ""
				);
			}*/
			
			$retval = array(
				'code' => 1,
				'message' => ""
			);
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	public function action_update_users()
	{
		// get the users from n1
		$n1Users = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'users', TRUE);
		
		// figure out how many users we have tos tart
		$n1UsersCount = $n1Users->count();
		
		try {
			// set up the saved array
			$saved = array();
			
			// run through the data
			foreach ($n1Users as $u)
			{
				$item = Jelly::factory('user')
					->set(array(
						'id' => $u->userid,
						'status' => $u->status,
						'name' => $u->name,
						'email' => $u->email,
						'password' => $u->password,
						'date_of_birth' => $u->date_of_birth,
						'instant_message' => $u->instant_message,
						'main_char' => $u->main_char,
						'sysadmin' => $u->is_sysadmin,
						'gm' => $u->is_game_master,
						'webmaster' => $u->is_webmaster,
						'timezone' => $this->_translate_timezone($u->timezone),
						'dst' => $u->daylight_savings,
						'language' => $u->language,
						'join' => $u->join_date,
						'leave' => $u->leave_date,
						'last_update' => $u->last_update,
						'last_post' => $u->last_post,
						'last_login' => $u->last_login,
						'loa' => $u->loa,
						'rank' => $u->display_rank,
						'skin_main' => $u->skin_main,
						'skin_wiki' => $u->skin_wiki,
						'skin_admin' => $u->skin_admin,
						'location' => $u->location,
						'bio' => $u->interests."\r\n\r\n".$u->bio,
						'security_question' => $u->security_question,
						'security_answer' => $u->security_answer,
						'password_reset' => $u->password_reset
					))
					->save();
				$saved[] = (int) $item->saved();
				
				# TODO: need to fill in the moderation table once the schema's been built
			}
			
			if (in_array(FALSE, $saved) && !in_array(TRUE, $saved))
			{
				$retval = array(
					'code' => 0,
					'message' => __("Users were not successfully updated")
				);
			}
			elseif (in_array(FALSE, $saved) && in_array(TRUE, $saved))
			{
				// get an array with the counts of the different values
				$unique = array_count_values($saved);
				
				$retval = array(
					'code' => 2,
					'message' => __(":success of :total users were updated, but the remaining records could not be updated",
						array(':success' => $unique[1], ':total' => $n1UsersCount))
				);
			}
			else
			{
				$retval = array(
					'code' => 1,
					'message' => ""
				);
			}
		} catch (Exception $e) {
			$retval = array(
				'code' => 0,
				'message' => 'ERROR: '.$e->getMessage().' - line '.$e->getLine().' of '.$e->getFile()
			);
		}
		
		echo json_encode($retval);
	}
	
	private function _translate_timezone($zone)
	{
		$timezones = array(
			'UM12'		=> 'Pacific/Kiritimati',
			'UM11'		=> 'Pacific/Midway',
			'UM10'		=> 'Pacific/Honolulu',
			'UM95'		=> 'Pacific/Marquesas',
			'UM9'		=> 'America/Juneau',
			'UM8'		=> 'America/Los_Angeles',
			'UM7'		=> 'America/Denver',
			'UM6'		=> 'America/Chicago',
			'UM5'		=> 'America/New_York',
			'UM45'		=> 'America/Caracas',
			'UM4'		=> 'America/Puerto_Rico',
			'UM35'		=> 'America/St_Johns',
			'UM3'		=> 'America/Buenos_Aires',
			'UM2'		=> 'Atlantic/St_Helena',
			'UM1'		=> 'Atlantic/Azores',
			'UTC'		=> 'UTC',
			'UP1'		=> 'Europe/Berlin',
			'UP2'		=> 'Europe/Athens',
			'UP3'		=> 'Europe/Moscow',
			'UP35'		=> 'Asia/Tehran',
			'UP4'		=> 'Asia/Dubai',
			'UP45'		=> 'Asia/Kabul',
			'UP5'		=> 'Asia/Ashgabat',
			'UP55'		=> 'Asia/Kolkata',
			'UP575'		=> 'Asia/Kathmandu',
			'UP6'		=> 'Asia/Karachi',
			'UP65'		=> 'Asia/Rangoon',
			'UP7'		=> 'Asia/Jakarta',
			'UP8'		=> 'Asia/Hong_Kong',
			'UP875'		=> 'Australia/Eucla',
			'UP9'		=> 'Asia/Tokyo',
			'UP95'		=> 'Australia/Adelaide',
			'UP10'		=> 'Australia/Sydney',
			'UP105'		=> 'Australia/Lord_Howe',
			'UP11'		=> 'Pacific/Guadalcanal',
			'UP115'		=> 'Pacific/Norfolk',
			'UP12'		=> 'Pacific/Fiji',
			'UP1275'	=> 'Pacific/Chatham',
			'UP13'		=> 'Pacific/Enderbury',
			'UP14'		=> 'Pacific/Kiritimati'
		);
		
		return $timezones[$zone];
	}
}