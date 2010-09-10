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
	
	public function update_accessroles()
	{
		# roles
		# access groups
		# access pages
	}
	
	public function action_update_applications()
	{
		// get the application data from n1
		$n1Apps = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'applications', TRUE);
		
		// get the counts
		$n1AppsCount = $n1Apps->count();
		
		try {
			// set up the saved array
			$saved = array();
			
			// run through the data
			foreach ($n1Apps as $n)
			{
				$item = Jelly::factory('application')
					->set(array(
						'email' => $n->app_email,
						'user' => $n->app_user,
						'name' => $n->app_user_name,
						'character' => $n->app_character,
						'charname' => $n->app_character_name,
						'position' => $n->app_position,
						'date' => $n->app_date,
						'action' => $n->app_action,
						'message' => $n->app_message,
					))
					->save();
				$saved[] = (int) $item->saved();
			}
			
			if (in_array(FALSE, $saved) && ! in_array(TRUE, $saved))
			{
				$retval = array(
					'code' => 0,
					'message' => __("Your application records could not be updated.")
				);
			}
			elseif (in_array(FALSE, $saved) && in_array(TRUE, $saved))
			{
				// get an array with the counts of the different values
				$unique = array_count_values($saved);
				
				$retval = array(
					'code' => 2,
					'message' => __("Only :success of :total application records could be updated.",
						array(':success' => $unique[1], ':total' => $n1AppsCount))
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
	
	public function action_update_awards()
	{
		// get the awards data from n1
		$n1Awards = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'awards', TRUE);
		$n1AwardsRec = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'awards_received', TRUE);
		$n1AwardsQueue = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'awards_queue', TRUE);
		
		// get the counts
		$n1AwardsCount = $n1Awards->count();
		$n1AwardsRecCount = $n1AwardsRec->count();
		
		try {
			// set up the saved arrays
			$savedAwards = array();
			$savedAwardsRec = array();
			
			// run through the data
			foreach ($n1Awards as $n)
			{
				$item = Jelly::factory('award')
					->set(array(
						'id' => $n->award_id,
						'name' => $n->award_name,
						'image' => $n->award_image,
						'order' => $n->award_order,
						'desc' => $n->award_desc,
						'category' => $n->award_cat,
						'display' => $n->award_display,
					))
					->save();
				$savedAwards[] = (int) $item->saved();
			}
			
			// do the received awards
			foreach ($n1AwardsRec as $r)
			{
				$item = Jelly::factory('awardrec')
					->set(array(
						'user' => $r->awardrec_user,
						'character' => $r->awardrec_character,
						'nominated' => $r->awardrec_nominated_by,
						'award' => $r->awardrec_award,
						'date' => $r->awardrec_date,
						'reason' => $r->awardrec_reason,
					))
					->save();
				$savedAwardsRec[] = (int) $item->saved();
			}
			
			// do the awards queue
			foreach ($n1AwardsQueue as $q)
			{
				$item = Jelly::factory('awardqueue')
					->set(array(
						'user' => $q->queue_receive_user,
						'character' => $q->queue_receive_character,
						'nominated' => $q->queue_nominate,
						'award' => $q->queue_award,
						'date' => $q->queue_date,
						'reason' => $q->queue_reason,
						'status' => $q->queue_status
					))
					->save();
			}
			
			if (count($savedAwards) > 0)
			{
				if ( ! in_array(FALSE, $savedAwards))
				{
					if (count($savedAwardsRec) > 0)
					{
						if ( ! in_array(FALSE, $savedAwardsRec))
						{
							$retval = array(
								'code' => 1,
								'message' => ""
							);
						}
						
						if ( ! in_array(TRUE, $savedAwardsRec))
						{
							$retval = array(
								'code' => 2,
								'message' => __("All of your awards were updated, but none of your received award records could be updated.")
							);
						}
						
						if (in_array(TRUE, $savedAwardsRec) && in_array(FALSE, $savedAwardsRec))
						{
							// get an array with the counts of the different values
							$unique = array_count_values($savedAwardsRec);
							
							$retval = array(
								'code' => 2,
								'message' => __("All of your awards were updated, but only :success of :total received award records could be updated.",
									array(':success' => $unique[1], ':total' => $n1AwardsRecCount))
							);
						}
					}
					else
					{
						$retval = array(
							'code' => 1,
							'message' => ""
						);
					}
				}
				elseif ( ! in_array(TRUE, $savedAwards))
				{
					if (count($savedAwardsRec) > 0)
					{
						if ( ! in_array(FALSE, $savedAwardsRec))
						{
							$retval = array(
								'code' => 2,
								'message' => __("None of your awards could be updated, but all of your received award records were updated.")
							);
						}
						
						if ( ! in_array(TRUE, $savedAwardsRec))
						{
							$retval = array(
								'code' => 0,
								'message' => __("None of your awards or received award records could be updated.")
							);
						}
						
						if (in_array(TRUE, $savedAwardsRec) && in_array(FALSE, $savedAwardsRec))
						{
							// get an array with the counts of the different values
							$unique = array_count_values($savedAwardsRec);
							
							$retval = array(
								'code' => 2,
								'message' => __("None of your awards could be updated and only :success of :total received award records could be updated.",
									array(':success' => $unique[1], ':total' => $n1AwardsRecCount))
							);
						}
					}
					else
					{
						$retval = array(
							'code' => 0,
							'message' => __("None of your awards could be updated.")
						);
					}
				}
				elseif (in_array(TRUE, $savedAwards) && in_array(FALSE, $savedAwards))
				{
					// get an array with the counts of the different values
					$unique = array_count_values($savedAwards);
					
					if (count($savedAwardsRec) > 0)
					{
						if ( ! in_array(FALSE, $savedAwardsRec))
						{
							$retval = array(
								'code' => 2,
								'message' => __("Only :success of :total awards were updated, but all of your received award records were updated.",
									array(':success' => $unique[1], ':total' => $n1AwardsCount))
							);
						}
						
						if ( ! in_array(TRUE, $savedAwardsRec))
						{
							$retval = array(
								'code' => 2,
								'message' => __("Only :success of :total awards were updated and none of your received award records could be updated.",
									array(':success' => $unique[1], ':total' => $n1AwardsCount))
							);
						}
						
						if (in_array(TRUE, $savedAwardsRec) && in_array(FALSE, $savedAwardsRec))
						{
							// get an array with the counts of the different values
							$uniqueRec = array_count_values($savedAwardsRec);
							
							$retval = array(
								'code' => 2,
								'message' => __("Only :success of :total awards and :successRec of :totalRec received award records could be updated.",
									array(':success' => $unique[1], ':total' => $n1AwardsCount, ':successRec' => $uniqueRec[1], ':totalRec' => $n1AwardsRecCount))
							);
						}
					}
					else
					{
						$retval = array(
							'code' => 2,
							'message' => __("Only :success of :total awards could be updated.",
								array(':success' => $unique[1], ':total' => $n1AwardsCount))
						);
					}
				}
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
		
		// get the counts
		$n1CharsCount = $n1Chars->count();
		$n1CharsPromCount = $n1CharsProm->count();
		$n1CharsTabsCount = $n1CharsTabs->count();
		$n1CharsSectionsCount = $n1CharsSections->count();
		$n1CharsFormCount = $n1CharsForm->count();
		$n1CharsValuesCount = $n1CharsValues->count();
		$n1CharsDataCount = $n1CharsData->count();
		$n1CharsCOCCount = $n1CharsCOC->count();
		
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
			
			// get the db prefix
			$dbconfig = Kohana::config('database.default');
			
			// clear out the tables
			$this->db->query(NULL, "TRUNCATE TABLE ".$dbconfig['table_prefix']."characters", TRUE);
			$this->db->query(NULL, "TRUNCATE TABLE ".$dbconfig['table_prefix']."characters_promotions", TRUE);
			$this->db->query(NULL, "TRUNCATE TABLE ".$dbconfig['table_prefix']."forms_tabs", TRUE);
			$this->db->query(NULL, "TRUNCATE TABLE ".$dbconfig['table_prefix']."forms_sections", TRUE);
			$this->db->query(NULL, "TRUNCATE TABLE ".$dbconfig['table_prefix']."forms_fields", TRUE);
			$this->db->query(NULL, "TRUNCATE TABLE ".$dbconfig['table_prefix']."forms_values", TRUE);
			$this->db->query(NULL, "TRUNCATE TABLE ".$dbconfig['table_prefix']."forms_data", TRUE);
			$this->db->query(NULL, "TRUNCATE TABLE ".$dbconfig['table_prefix']."coc", TRUE);
			
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
					if ( ! empty($i))
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
			
			if ( ! in_array(TRUE, $savedChars) && ! in_array(TRUE, $savedCharsProm) && ! in_array(TRUE, $savedFormTabs)
					&& ! in_array(TRUE, $savedFormSections) && ! in_array(TRUE, $savedFormFields) && ! in_array(TRUE, $savedFormValues)
					&& ! in_array(TRUE, $savedFormData) && ! in_array(TRUE, $savedCOC))
			{
				$retval = array(
					'code' => 0,
					'message' => __("None of your character data or bio form could be updated. Due to the high volume of information that needs to be updated, a more detailed description isn't available.")
				);
			}
			elseif ( ! in_array(FALSE, $savedChars) && ! in_array(FALSE, $savedCharsProm) && ! in_array(FALSE, $savedFormTabs)
					&& ! in_array(FALSE, $savedFormSections) && ! in_array(FALSE, $savedFormFields) && ! in_array(FALSE, $savedFormValues)
					&& ! in_array(FALSE, $savedFormData) && ! in_array(FALSE, $savedCOC))
			{
				$retval = array(
					'code' => 1,
					'message' => ""
				);
			}
			else
			{
				$retval = array(
					'code' => 2,
					'message' => __("Only some of your character data and bio form could be updated. Due to the high volume of information that needs to be updated, a more detailed description isn't available.")
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
	
	public function update_docking()
	{
		# docked items
		# docking sections
		# docking form
		# docking form values
		# docking form data
	}
	
	public function action_update_missions()
	{
		// get the data from n1
		$n1Mis = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'missions', TRUE);
		$n1MisGroups = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'mission_groups', TRUE);
		
		// get the counts
		$n1MisCount = $n1Mis->count();
		$n1MisGroupCount = $n1MisGroups->count();
		
		try {
			// set up the saved arrays
			$savedMis = array();
			$savedMisGroups = array();
			
			// run through the data
			foreach ($n1Mis as $n)
			{
				$item = Jelly::factory('mission')
					->set(array(
						'id' => $n->mission_id,
						'title' => $n->mission_title,
						'images' => $n->mission_images,
						'order' => $n->mission_order,
						'desc' => $n->mission_desc,
						'group' => $n->mission_group,
						'status' => $n->mission_status,
						'start' => $n->mission_start,
						'end' => $n->mission_end,
						'summary' => $n->mission_summary,
						'notes' => $n->mission_notes,
						'notes_updated' => $n->mission_notes_updated
					))
					->save();
				$savedMis[] = (int) $item->saved();
			}
			
			// do the mission groups
			foreach ($n1MisGroups as $g)
			{
				$item = Jelly::factory('missiongroup')
					->set(array(
						'id' => $g->misgroup_id,
						'name' => $g->misgroup_name,
						'order' => $g->misgroup_order,
						'desc' => $g->misgroup_desc,
					))
					->save();
				$savedMisGroups[] = (int) $item->saved();
			}
			
			if (count($savedMis) > 0)
			{
				if ( ! in_array(FALSE, $savedMis))
				{
					if (count($savedMisGroups) > 0)
					{
						if ( ! in_array(FALSE, $savedMisGroups))
						{
							$retval = array(
								'code' => 1,
								'message' => ""
							);
						}
						
						if ( ! in_array(TRUE, $savedMisGroups))
						{
							$retval = array(
								'code' => 2,
								'message' => __("All of your missions were updated, but none of your mission groups could be updated.")
							);
						}
						
						if (in_array(TRUE, $savedMisGroups) && in_array(FALSE, $savedMisGroups))
						{
							// get an array with the counts of the different values
							$unique = array_count_values($savedMisGroups);
							
							$retval = array(
								'code' => 2,
								'message' => __("All of your missions were updated, but only :success of :total mission groups could be updated.",
									array(':success' => $unique[1], ':total' => $n1MisGroupsCount))
							);
						}
					}
					else
					{
						$retval = array(
							'code' => 1,
							'message' => ""
						);
					}
				}
				elseif ( ! in_array(TRUE, $savedMis))
				{
					if (count($savedMisGroups) > 0)
					{
						if ( ! in_array(FALSE, $savedMisGroups))
						{
							$retval = array(
								'code' => 2,
								'message' => __("None of your missions could be updated, but all of your mission groups were updated.")
							);
						}
						
						if ( ! in_array(TRUE, $savedMisGroups))
						{
							$retval = array(
								'code' => 0,
								'message' => __("None of your missions or mission groups could be updated.")
							);
						}
						
						if (in_array(TRUE, $savedMisGroups) && in_array(FALSE, $savedMisGroups))
						{
							// get an array with the counts of the different values
							$unique = array_count_values($savedMisGroups);
							
							$retval = array(
								'code' => 2,
								'message' => __("None of your missions could be updated and only :success of :total mission groups could be updated.",
									array(':success' => $unique[1], ':total' => $n1MisGroupsCount))
							);
						}
					}
					else
					{
						$retval = array(
							'code' => 0,
							'message' => __("None of your missions or mission groups could be updated.")
						);
					}
				}
				elseif (in_array(TRUE, $savedMis) && in_array(FALSE, $savedMis))
				{
					// get an array with the counts of the different values
					$unique = array_count_values($savedMis);
					
					if (count($savedMisGroups) > 0)
					{
						if ( ! in_array(FALSE, $savedMisGroups))
						{
							$retval = array(
								'code' => 2,
								'message' => __("Only :success of :total missions were updated, but all of your mission groups were updated.",
									array(':success' => $unique[1], ':total' => $n1MisCount))
							);
						}
						
						if ( ! in_array(TRUE, $savedMisGroups))
						{
							$retval = array(
								'code' => 2,
								'message' => __("Only :success of :total missions were updated and none of your mission groups could be updated.",
									array(':success' => $unique[1], ':total' => $n1MisCount))
							);
						}
						
						if (in_array(TRUE, $savedMisGroups) && in_array(FALSE, $savedMisGroups))
						{
							// get an array with the counts of the different values
							$uniqueGrp = array_count_values($savedMisGroups);
							
							$retval = array(
								'code' => 2,
								'message' => __("Only :success of :total missions and :successGrp of :totalGrp mission groups could be updated.",
									array(':success' => $unique[1], ':total' => $n1MisCount, ':successRec' => $uniqueGrp[1], ':totalRec' => $n1MisGroupsCount))
							);
						}
					}
					else
					{
						$retval = array(
							'code' => 2,
							'message' => __("Only :success of :total missions could be updated.",
								array(':success' => $unique[1], ':total' => $n1MisCount))
						);
					}
				}
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
	
	public function action_update_news()
	{
		// get the data from n1
		$n1News = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'news', TRUE);
		$n1NewsCom = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'news_comments', TRUE);
		$n1NewsCats = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'news_categories', TRUE);
		
		// get the counts
		$n1NewsCount = $n1News->count();
		$n1NewsComCount = $n1NewsCom->count();
		$n1NewsCatsCount = $n1NewsCats->count();
		
		try {
			// set up the saved arrays
			$savedNews = array();
			$savedNewsCom = array();
			
			// get the db prefix
			$dbconfig = Kohana::config('database.default');
			
			// clear out the tables
			$this->db->query(NULL, "TRUNCATE TABLE ".$dbconfig['table_prefix']."news_categories", TRUE);
			
			// run through the data
			foreach ($n1News as $n)
			{
				$item = Jelly::factory('news')
					->set(array(
						'id' => $n->news_id,
						'title' => $n->news_title,
						'date' => $n->news_date,
						'author_user' => $n->news_author_character,
						'author_character' => $n->news_author_user,
						'status' => $n->news_status,
						'content' => $n->news_content,
						'tags' => $n->news_tags,
						'last_update' => $n->news_last_update,
						'category' => $n->news_cat,
						'private' => $n->news_private,
					))
					->save();
				$savedNews[] = (int) $item->saved();
			}
			
			// do the news comments
			foreach ($n1NewsCom as $c)
			{
				$item = Jelly::factory('newscomment')
					->set(array(
						'id' => $c->ncomment_id,
						'author_user' => $c->ncomment_author_user,
						'author_character' => $c->ncomment_author_character,
						'news' => $c->ncomment_news,
						'date' => $c->ncomment_date,
						'status' => $c->ncomment_status,
						'content' => $c->ncomment_content,
					))
					->save();
				$savedNewsCom[] = (int) $item->saved();
			}
			
			// do the news categories
			foreach ($n1NewsCats as $c)
			{
				$item = Jelly::factory('newscategory')
					->set(array(
						'id' => $c->newscat_id,
						'name' => $c->newscat_name,
						'display' => $c->newscat_display,
					))
					->save();
			}
			
			if (count($savedNews) > 0)
			{
				if ( ! in_array(FALSE, $savedNews))
				{
					if (count($savedNewsCom) > 0)
					{
						if ( ! in_array(FALSE, $savedNewsCom))
						{
							$retval = array(
								'code' => 1,
								'message' => ""
							);
						}
						
						if ( ! in_array(TRUE, $savedNewsCom))
						{
							$retval = array(
								'code' => 2,
								'message' => __("All of your news items were updated, but none of your news comments could be updated.")
							);
						}
						
						if (in_array(TRUE, $savedNewsCom) && in_array(FALSE, $savedNewsCom))
						{
							// get an array with the counts of the different values
							$unique = array_count_values($savedNewsCom);
							
							$retval = array(
								'code' => 2,
								'message' => __("All of your news items were updated, but only :success of :total news comments could be updated.",
									array(':success' => $unique[1], ':total' => $n1NewsComCount))
							);
						}
					}
					else
					{
						$retval = array(
							'code' => 1,
							'message' => ""
						);
					}
				}
				elseif ( ! in_array(TRUE, $savedNews))
				{
					if (count($savedNewsCom) > 0)
					{
						if ( ! in_array(FALSE, $savedNewsCom))
						{
							$retval = array(
								'code' => 2,
								'message' => __("None of your news items could be updated, but all of your news comments were updated.")
							);
						}
						
						if ( ! in_array(TRUE, $savedNewsCom))
						{
							$retval = array(
								'code' => 0,
								'message' => __("None of your news items or news comments could be updated.")
							);
						}
						
						if (in_array(TRUE, $savedNewsCom) && in_array(FALSE, $savedNewsCom))
						{
							// get an array with the counts of the different values
							$unique = array_count_values($savedNewsCom);
							
							$retval = array(
								'code' => 2,
								'message' => __("None of your news items could be updated and only :success of :total news comments could be updated.",
									array(':success' => $unique[1], ':total' => $n1NewsComCount))
							);
						}
					}
					else
					{
						$retval = array(
							'code' => 0,
							'message' => __("None of your news items could be updated.")
						);
					}
				}
				elseif (in_array(TRUE, $savedNews) && in_array(FALSE, $savedNews))
				{
					// get an array with the counts of the different values
					$unique = array_count_values($savedNews);
					
					if (count($savedNewsCom) > 0)
					{
						if ( ! in_array(FALSE, $savedNewsCom))
						{
							$retval = array(
								'code' => 2,
								'message' => __("Only :success of :total news items were updated, but all of your news comments were updated.",
									array(':success' => $unique[1], ':total' => $n1NewsCount))
							);
						}
						
						if ( ! in_array(TRUE, $savedNewsCom))
						{
							$retval = array(
								'code' => 2,
								'message' => __("Only :success of :total news items were updated and none of your news comments could be updated.",
									array(':success' => $unique[1], ':total' => $n1NewsCount))
							);
						}
						
						if (in_array(TRUE, $savedNewsCom) && in_array(FALSE, $savedNewsCom))
						{
							// get an array with the counts of the different values
							$uniqueCom = array_count_values($savedNewsCom);
							
							$retval = array(
								'code' => 2,
								'message' => __("Only :success of :total news items and :successCom of :totalCom news comments could be updated.",
									array(':success' => $unique[1], ':total' => $n1NewsCount, ':successRec' => $uniqueCom[1], ':totalRec' => $n1NewsComCount))
							);
						}
					}
					else
					{
						$retval = array(
							'code' => 2,
							'message' => __("Only :success of :total news items could be updated.",
								array(':success' => $unique[1], ':total' => $n1NewsCount))
						);
					}
				}
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
	
	public function action_update_logs()
	{
		// get the data from n1
		$n1Logs = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'personallogs', TRUE);
		$n1LogsCom = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'personallogs_comments', TRUE);
		
		// get the counts
		$n1LogsCount = $n1Logs->count();
		$n1LogsComCount = $n1LogsCom->count();
		
		try {
			// set up the saved arrays
			$savedLogs = array();
			$savedLogsCom = array();
			
			// run through the data
			foreach ($n1Logs as $n)
			{
				$item = Jelly::factory('personallog')
					->set(array(
						'id' => $n->log_id,
						'title' => $n->log_title,
						'date' => $n->log_date,
						'author_user' => $n->log_author_character,
						'author_character' => $n->log_author_user,
						'status' => $n->log_status,
						'content' => $n->log_content,
						'tags' => $n->log_tags,
						'last_update' => $n->log_last_update,
					))
					->save();
				$savedLogs[] = (int) $item->saved();
			}
			
			// do the log comments
			foreach ($n1LogsCom as $c)
			{
				$item = Jelly::factory('personallogcomment')
					->set(array(
						'id' => $c->lcomment_id,
						'author_user' => $c->lcomment_author_user,
						'author_character' => $c->lcomment_author_character,
						'log' => $c->lcomment_log,
						'date' => $c->lcomment_date,
						'status' => $c->lcomment_status,
						'content' => $c->lcomment_content,
					))
					->save();
				$savedLogsCom[] = (int) $item->saved();
			}
			
			if (count($savedLogs) > 0)
			{
				if ( ! in_array(FALSE, $savedLogs))
				{
					if (count($savedLogsCom) > 0)
					{
						if ( ! in_array(FALSE, $savedLogsCom))
						{
							$retval = array(
								'code' => 1,
								'message' => ""
							);
						}
						
						if ( ! in_array(TRUE, $savedLogsCom))
						{
							$retval = array(
								'code' => 2,
								'message' => __("All of your personal logs were updated, but none of your log comments could be updated.")
							);
						}
						
						if (in_array(TRUE, $savedLogsCom) && in_array(FALSE, $savedLogsCom))
						{
							// get an array with the counts of the different values
							$unique = array_count_values($savedLogsCom);
							
							$retval = array(
								'code' => 2,
								'message' => __("All of your personal logs were updated, but only :success of :total log comments could be updated.",
									array(':success' => $unique[1], ':total' => $n1LogsComCount))
							);
						}
					}
					else
					{
						$retval = array(
							'code' => 1,
							'message' => ""
						);
					}
				}
				elseif ( ! in_array(TRUE, $savedLogs))
				{
					if (count($savedLogsCom) > 0)
					{
						if ( ! in_array(FALSE, $savedLogsCom))
						{
							$retval = array(
								'code' => 2,
								'message' => __("None of your personal logs could be updated, but all of your log comments were updated.")
							);
						}
						
						if ( ! in_array(TRUE, $savedLogsCom))
						{
							$retval = array(
								'code' => 0,
								'message' => __("None of your personal logs or log comments could be updated.")
							);
						}
						
						if (in_array(TRUE, $savedLogsCom) && in_array(FALSE, $savedLogsCom))
						{
							// get an array with the counts of the different values
							$unique = array_count_values($savedLogsCom);
							
							$retval = array(
								'code' => 2,
								'message' => __("None of your personal logs could be updated and only :success of :total log comments could be updated.",
									array(':success' => $unique[1], ':total' => $n1LogsComCount))
							);
						}
					}
					else
					{
						$retval = array(
							'code' => 0,
							'message' => __("None of your personal logs could be updated.")
						);
					}
				}
				elseif (in_array(TRUE, $savedLogs) && in_array(FALSE, $savedLogs))
				{
					// get an array with the counts of the different values
					$unique = array_count_values($savedLogs);
					
					if (count($savedLogsCom) > 0)
					{
						if ( ! in_array(FALSE, $savedLogsCom))
						{
							$retval = array(
								'code' => 2,
								'message' => __("Only :success of :total personal logs were updated, but all of your log comments were updated.",
									array(':success' => $unique[1], ':total' => $n1LogsCount))
							);
						}
						
						if ( ! in_array(TRUE, $savedLogsCom))
						{
							$retval = array(
								'code' => 2,
								'message' => __("Only :success of :total personal logs were updated and none of your log comments could be updated.",
									array(':success' => $unique[1], ':total' => $n1LogsCount))
							);
						}
						
						if (in_array(TRUE, $savedLogsCom) && in_array(FALSE, $savedLogsCom))
						{
							// get an array with the counts of the different values
							$uniqueCom = array_count_values($savedLogsCom);
							
							$retval = array(
								'code' => 2,
								'message' => __("Only :success of :total personal logs and :successCom of :totalCom log comments could be updated.",
									array(':success' => $unique[1], ':total' => $n1LogsCount, ':successRec' => $uniqueCom[1], ':totalRec' => $n1LogsComCount))
							);
						}
					}
					else
					{
						$retval = array(
							'code' => 2,
							'message' => __("Only :success of :total personal logs could be updated.",
								array(':success' => $unique[1], ':total' => $n1LogsCount))
						);
					}
				}
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
	
	public function action_update_posts()
	{
		// get the data from n1
		$n1Posts = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'posts', TRUE);
		$n1PostsCom = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'posts_comments', TRUE);
		
		// get the counts
		$n1PostsCount = $n1Posts->count();
		$n1PostsComCount = $n1PostsCom->count();
		
		try {
			// set up the saved arrays
			$savedPosts = array();
			$savedPostsCom = array();
			
			// run through the data
			foreach ($n1Posts as $n)
			{
				$item = Jelly::factory('post')
					->set(array(
						'id' => $n->post_id,
						'title' => $n->post_title,
						'location' => $n->post_location,
						'timeline' => $n->post_timeline,
						'date' => $n->post_date,
						'authors' => $n->post_authors,
						'author_users' => $n->post_authors_users,
						'mission' => $n->post_mission,
						'saved' => $n->post_saved,
						'status' => $n->post_status,
						'content' => $n->post_content,
						'tags' => $n->post_tags,
						'last_update' => $n->post_last_update,
					))
					->save();
				$savedPosts[] = (int) $item->saved();
			}
			
			// do the post comments
			foreach ($n1PostsCom as $c)
			{
				$item = Jelly::factory('postcomment')
					->set(array(
						'id' => $c->pcomment_id,
						'author_user' => $c->pcomment_author_user,
						'author_character' => $c->pcomment_author_character,
						'post' => $c->pcomment_post,
						'date' => $c->pcomment_date,
						'status' => $c->pcomment_status,
						'content' => $c->pcomment_content,
					))
					->save();
				$savedPostsCom[] = (int) $item->saved();
			}
			
			if (count($savedPosts) > 0)
			{
				if ( ! in_array(FALSE, $savedPosts))
				{
					if (count($savedPostsCom) > 0)
					{
						if ( ! in_array(FALSE, $savedPostsCom))
						{
							$retval = array(
								'code' => 1,
								'message' => ""
							);
						}
						if ( ! in_array(TRUE, $savedPostsCom))
						{
							$retval = array(
								'code' => 2,
								'message' => __("All of your posts were updated, but none of your post comments could be updated.")
							);
						}
						if (in_array(TRUE, $savedPostsCom) && in_array(FALSE, $savedPostsCom))
						{
							// get an array with the counts of the different values
							$unique = array_count_values($savedPostsCom);
							
							$retval = array(
								'code' => 2,
								'message' => __("All of your posts were updated, but only :success of :total post comments could be updated.",
									array(':success' => $unique[1], ':total' => $n1PostsComCount))
							);
						}
					}
					else
					{
						$retval = array(
							'code' => 1,
							'message' => ""
						);
					}
				}
				elseif ( ! in_array(TRUE, $savedPosts))
				{
					if (count($savedPostsCom) > 0)
					{
						if ( ! in_array(FALSE, $savedPostsCom))
						{
							$retval = array(
								'code' => 2,
								'message' => __("None of your posts could be updated, but all of your post comments were updated.")
							);
						}
						if ( ! in_array(TRUE, $savedPostsCom))
						{
							$retval = array(
								'code' => 0,
								'message' => __("None of your posts or post comments could be updated.")
							);
						}
						if (in_array(TRUE, $savedPostsCom) && in_array(FALSE, $savedPostsCom))
						{
							// get an array with the counts of the different values
							$unique = array_count_values($savedPostsCom);
							
							$retval = array(
								'code' => 2,
								'message' => __("None of your posts could be updated and only :success of :total post comments could be updated.",
									array(':success' => $unique[1], ':total' => $n1PostsComCount))
							);
						}
					}
					else
					{
						$retval = array(
							'code' => 0,
							'message' => __("None of your posts could be updated.")
						);
					}
				}
				elseif (in_array(TRUE, $savedPosts) && in_array(FALSE, $savedPosts))
				{
					// get an array with the counts of the different values
					$unique = array_count_values($savedPosts);
					
					if (count($savedPostsCom) > 0)
					{
						if ( ! in_array(FALSE, $savedPostsCom))
						{
							$retval = array(
								'code' => 2,
								'message' => __("Only :success of :total posts were updated, but all of your post comments were updated.",
									array(':success' => $unique[1], ':total' => $n1PostsCount))
							);
						}
						if ( ! in_array(TRUE, $savedPostsCom))
						{
							$retval = array(
								'code' => 2,
								'message' => __("Only :success of :total posts were updated and none of your post comments could be updated.",
									array(':success' => $unique[1], ':total' => $n1PostsCount))
							);
						}
						if (in_array(TRUE, $savedPostsCom) && in_array(FALSE, $savedPostsCom))
						{
							// get an array with the counts of the different values
							$uniqueCom = array_count_values($savedPostsCom);
							
							$retval = array(
								'code' => 2,
								'message' => __("Only :success of :total posts and :successCom of :totalCom post comments could be updated.",
									array(':success' => $unique[1], ':total' => $n1PostsCount, ':successRec' => $uniqueCom[1], ':totalRec' => $n1PostsComCount))
							);
						}
					}
					else
					{
						$retval = array(
							'code' => 2,
							'message' => __("Only :success of :total posts could be updated.",
								array(':success' => $unique[1], ':total' => $n1PostsCount))
						);
					}
				}
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
	
	public function action_update_privmsgs()
	{
		// get the data from n1
		$n1PM = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'privmsgs', TRUE);
		$n1PMTo = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'privmsgs_to', TRUE);
		
		// get the counts
		$n1PMCount = $n1PM->count();
		$n1PMToCount = $n1PMTo->count();
		
		try {
			// set up the saved arrays
			$saved = array();
			
			// run through the data
			foreach ($n1PM as $n)
			{
				$item = Jelly::factory('privatemessage')
					->set(array(
						'id' => $n->privmsgs_id,
						'user' => $n->privmsgs_author_user,
						'character' => $n->privmsgs_author_character,
						'date' => $n->privmsgs_date,
						'subject' => $n->privmsgs_subject,
						'content' => $n->privmsgs_content,
						'display' => $n->privmsgs_author_display,
					))
					->save();
				$saved[] = $item->saved();
			}
			
			// do the pm to table
			foreach ($n1PMTo as $p)
			{
				$item = Jelly::factory('privatemessageto')
					->set(array(
						'id' => $p->pmto_id,
						'message' => $p->pmto_message,
						'user' => $p->pmto_recipient_user,
						'character' => $p->pmto_recipient_character,
						'display' => $p->pmto_display,
						'unread' => $p->pmto_unread,
					))
					->save();
				$saved[] = $item->saved();
			}
			
			if (count($saved) > 0)
			{
				if ( ! in_array(FALSE, $saved))
				{
					$retval = array(
						'code' => 1,
						'message' => ""
					);
				}
				elseif ( ! in_array(TRUE, $saved))
				{
					$retval = array(
						'code' => 0,
						'message' => __("None of your private messages could be updated.")
					);
				}
				elseif (in_array(TRUE, $saved) && in_array(FALSE, $saved))
				{
					$retval = array(
						'code' => 2,
						'message' => __("Some of your private messages could not be updated.")
					);
				}
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
	
	public function update_settings()
	{
		# settings
		# messages
	}
	
	public function update_specs()
	{
		# spec items
		# spec sections
		# spec form
		# spec form values
		# spec form data
	}
	
	public function action_update_tour()
	{
		// get the characters from n1
		$n1Tour = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'tour', TRUE);
		$n1TourFields = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'tour_fields', TRUE);
		$n1TourValues = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'tour_values', TRUE);
		$n1TourData = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'tour_data', TRUE);
		$n1TourDecks = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'tour_decks', TRUE);
		
		// get the counts
		$n1TourCount = $n1Tour->count();
		$n1TourFormCount = $n1TourFields->count() + $n1TourValues->count() + $n1TourData->count();
		$n1TourDecksCount = $n1TourDecks->count();
		
		try {
			// set up the saved arrays
			$savedTour = array();
			$savedTourForm = array();
			$savedTourDecks = array();
			
			// run through the data
			foreach ($n1Tour as $n)
			{
				$item = Jelly::factory('tour')
					->set(array(
						'id' => $n->tour_id,
						'name' => $n->tour_name,
						'order' => $n->tour_order,
						'display' => $n->tour_display,
						'images' => $n->tour_images,
						'summary' => $n->tour_summary,
					))
					->save();
				$savedTour[] = (int) $item->saved();
			}
			
			// translation arrays
			$translateFields = array();
			
			// do the form fields
			foreach ($n1TourFields as $f)
			{
				$item = Jelly::factory('formfield')
					->set(array(
						'form' => 'tour',
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
				$savedTourForm[] = (int) $item->saved();
					
				$translateFields[$f->field_id] = $item->id();
			}
			
			// do the form values
			foreach ($n1TourValues as $v)
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
				$savedTourForm[] = (int) $item->saved();
			}
			
			// do the form data
			foreach ($n1TourData as $d)
			{
				$item = Jelly::factory('formdata')
					->set(array(
						'form' => 'tour',
						'field' => $translateFields[$d->data_field],
						'item' => $d->data_item,
						'value' => $d->data_value,
						'last_update' => $d->data_updated
					))
					->save();
				$savedTourForm[] = (int) $item->saved();
			}
			
			// do the decks
			foreach ($n1TourDecks as $d)
			{
				$item = Jelly::factory('tourdeck')
					->set(array(
						'id' => $d->deck_id,
						'name' => $d->deck_name,
						'order' => $d->deck_order,
						'content' => $d->deck_content,
					))
					->save();
				$savedTourDecks[] = (int) $item->saved();
			}
			
			if (count($savedTour) > 0)
			{
				if ( ! in_array(FALSE, $savedTour))
				{
					if ( ! in_array(FALSE, $savedTourForm) && ! in_array(FALSE, $savedTourDecks))
					{
						$retval = array(
							'code' => 1,
							'message' => ""
						);
					}
					if ( ! in_array(FALSE, $savedTourForm) && (in_array(FALSE, $savedTourDecks) && in_array(TRUE, $savedTourDecks)))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your tour items and tour form information were updated, but only some of your decks could be updated.")
						);
					}
					if ( ! in_array(TRUE, $savedTourForm) && (in_array(FALSE, $savedTourDecks) && in_array(TRUE, $savedTourDecks)))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your tour items were updated, but none of your tour form information and only some of your decks could be updated.")
						);
					}
					if ((in_array(FALSE, $savedTourForm) && in_array(TRUE, $savedTourForm)) && ! in_array(FALSE, $savedTourDecks))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your tour items and decks were updated, but only some of your tour form information could be updated.")
						);
					}
					if ((in_array(FALSE, $savedTourForm) && in_array(TRUE, $savedTourForm)) && ! in_array(TRUE, $savedTourDecks))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your tour items were updated, but none of your decks were updated and only some of your tour form information could be updated.")
						);
					}
					if ((in_array(FALSE, $savedTourForm) && in_array(TRUE, $savedTourForm)) && 
							(in_array(FALSE, $savedTourDecks) && in_array(TRUE, $savedTourDecks)))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your tour items were updated, but only some of your decks and tour form information could be updated.")
						);
					}
					if ( ! in_array(FALSE, $savedTourForm) && ! in_array(TRUE, $savedTourDecks))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your tour items and tour form information were updated, but none of your decks could be updated.")
						);
					}
					if ( ! in_array(TRUE, $savedTourForm) && ! in_array(FALSE, $savedTourDecks))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your tour items and decks were updated, but none of your tour form information could be updated.")
						);
					}
					if ( ! in_array(TRUE, $savedTourForm) && ! in_array(TRUE, $savedTourDecks))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your tour items were updated, but none of your tour form information or decks could be updated.")
						);
					}
				}
				elseif ( ! in_array(TRUE, $savedTour))
				{
					if ( ! in_array(FALSE, $savedTourForm) && ! in_array(FALSE, $savedTourDecks))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your tour form information and decks were updated, but none of your tour items could be updated.")
						);
					}
					if ( ! in_array(FALSE, $savedTourForm) && (in_array(FALSE, $savedTourDecks) && in_array(TRUE, $savedTourDecks)))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your tour form information was updated, but none of your tour items and only some of your decks could be updated.")
						);
					}
					if ( ! in_array(TRUE, $savedTourForm) && (in_array(FALSE, $savedTourDecks) && in_array(TRUE, $savedTourDecks)))
					{
						$retval = array(
							'code' => 2,
							'message' => __("None of your tour items or tour form information were updated and only some of your decks could be updated.")
						);
					}
					if ((in_array(FALSE, $savedTourForm) && in_array(TRUE, $savedTourForm)) && ! in_array(FALSE, $savedTourDecks))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your decks were updated, but none of your tour items and only some of your tour form information could be updated.")
						);
					}
					if ((in_array(FALSE, $savedTourForm) && in_array(TRUE, $savedTourForm)) && ! in_array(TRUE, $savedTourDecks))
					{
						$retval = array(
							'code' => 2,
							'message' => __("None of your tour items or decks were updated and only some of your tour form information could be updated.")
						);
					}
					if ((in_array(FALSE, $savedTourForm) && in_array(TRUE, $savedTourForm)) && 
							(in_array(FALSE, $savedTourDecks) && in_array(TRUE, $savedTourDecks)))
					{
						$retval = array(
							'code' => 2,
							'message' => __("None of your tour items were updated and only some of your tour form information and decks could be updated.")
						);
					}
					if ( ! in_array(FALSE, $savedTourForm) && ! in_array(TRUE, $savedTourDecks))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your tour form information was updated, but none of your tour items or decks could be updated.")
						);
					}
					if ( ! in_array(TRUE, $savedTourForm) && ! in_array(FALSE, $savedTourDecks))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your decks were updated, but none of your tour items or tour form information could be updated.")
						);
					}
					if ( ! in_array(TRUE, $savedTourForm) && ! in_array(TRUE, $savedTourDecks))
					{
						$retval = array(
							'code' => 0,
							'message' => __("None of your tour items, tour form information or decks were updated.")
						);
					}
				}
				elseif (in_array(FALSE, $savedTour) && in_array(TRUE, $savedTour))
				{
					if ( ! in_array(FALSE, $savedTourForm) && ! in_array(FALSE, $savedTourDecks))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your tour form information and decks were updated, but only some of your tour items could be updated.")
						);
					}
					if ( ! in_array(FALSE, $savedTourForm) && (in_array(FALSE, $savedTourDecks) && in_array(TRUE, $savedTourDecks)))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your tour form information was updated, but only some of your tour items and decks could be updated.")
						);
					}
					if ( ! in_array(TRUE, $savedTourForm) && (in_array(FALSE, $savedTourDecks) && in_array(TRUE, $savedTourDecks)))
					{
						$retval = array(
							'code' => 2,
							'message' => __("None of your tour form information was updated and only some of your tour items and decks could be updated.")
						);
					}
					if ((in_array(FALSE, $savedTourForm) && in_array(TRUE, $savedTourForm)) && ! in_array(FALSE, $savedTourDecks))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your decks were updated, but only some of your tour items and tour form information could be updated.")
						);
					}
					if ((in_array(FALSE, $savedTourForm) && in_array(TRUE, $savedTourForm)) && ! in_array(TRUE, $savedTourDecks))
					{
						$retval = array(
							'code' => 2,
							'message' => __("None of your decks were updated and only some of your tour items and tour form information could be updated.")
						);
					}
					if ((in_array(FALSE, $savedTourForm) && in_array(TRUE, $savedTourForm)) && 
							(in_array(FALSE, $savedTourDecks) && in_array(TRUE, $savedTourDecks)))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Only some of your tour items, tour form information and decks could be updated.")
						);
					}
					if ( ! in_array(FALSE, $savedTourForm) && ! in_array(TRUE, $savedTourDecks))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your tour form information was updated, but none of your decks and only some of your tour items could be updated.")
						);
					}
					if ( ! in_array(TRUE, $savedTourForm) && ! in_array(FALSE, $savedTourDecks))
					{
						$retval = array(
							'code' => 2,
							'message' => __("Your decks were updated, but none of your tour form information and only some of your tour items could be updated.")
						);
					}
					if ( ! in_array(TRUE, $savedTourForm) && ! in_array(TRUE, $savedTourDecks))
					{
						$retval = array(
							'code' => 0,
							'message' => __("None of your tour form information or decks were updated and only some of your tour items could be updated.")
						);
					}
				}
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
	
	public function update_uploads()
	{
		# uploads
	}
	
	public function action_update_users()
	{
		// get the users from n1
		$n1Users = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'users', TRUE);
		$n1UsersLOA = $this->db->query(Database::SELECT, "SELECT * FROM ".$this->n1pref.'user_loa', TRUE);
		
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
						'password_reset' => $u->password_reset,
						'role' => $this->_translate_roles($u->access_role)
					))
					->save();
				$saved[] = (int) $item->saved();
				
				if ($u->moderate_posts == 'y')
				{
					$item = Jelly::factory('moderation')->set(array('type' => 'posts', 'user' => $u->userid))->save();
				}
				
				if ($u->moderate_logs == 'y')
				{
					$item = Jelly::factory('moderation')->set(array('type' => 'logs', 'user' => $u->userid))->save();
				}
				
				if ($u->moderate_news == 'y')
				{
					$item = Jelly::factory('moderation')->set(array('type' => 'news', 'user' => $u->userid))->save();
				}
				
				if ($u->moderate_post_comments == 'y')
				{
					$item = Jelly::factory('moderation')->set(array('type' => 'post_comments', 'user' => $u->userid))->save();
				}
				
				if ($u->moderate_log_comments == 'y')
				{
					$item = Jelly::factory('moderation')->set(array('type' => 'log_comments', 'user' => $u->userid))->save();
				}
				
				if ($u->moderate_news_comments == 'y')
				{
					$item = Jelly::factory('moderation')->set(array('type' => 'news_comments', 'user' => $u->userid))->save();
				}
				
				if ($u->moderate_wiki_comments == 'y')
				{
					$item = Jelly::factory('moderation')->set(array('type' => 'wiki_comments', 'user' => $u->userid))->save();
				}
			}
			
			// transfer the loa records
			foreach ($n1UsersLOA as $l)
			{
				$item = Jelly::factory('userloa')
					->set(array(
						'user' => $l->loa_user,
						'start' => $l->loa_start_date,
						'end' => $l->loa_end_date,
						'duration' => $l->loa_duration,
						'reason' => $l->loa_reason,
						'type' => $l->loa_type,
					))
					->save();
			}
			
			if (in_array(FALSE, $saved) && ! in_array(TRUE, $saved))
			{
				$retval = array(
					'code' => 0,
					'message' => __("Your users could not be updated.")
				);
			}
			elseif (in_array(FALSE, $saved) && in_array(TRUE, $saved))
			{
				// get an array with the counts of the different values
				$unique = array_count_values($saved);
				
				$retval = array(
					'code' => 2,
					'message' => __("Only :success of :total users could be updated.",
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
	
	public function update_wiki()
	{
		# categories
		# comments
		# drafts
		# pages
	}
	
	private function _translate_roles($old)
	{
		$roles = array(
			1 => 1,
			2 => 2,
			3 => 3,
			4 => 4,
			5 => 5
		);
		
		return $roles[$old];
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