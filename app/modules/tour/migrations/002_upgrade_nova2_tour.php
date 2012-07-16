<?php
/**
 * Attempts to upgrade the Nova 2 docking feature to Nova 3 if the necessary
 * items are in place. If they aren't, nothing will happen.
 *
 * @package		Nova
 * @subpackage	Tour
 * @category	Migration
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Fuel\Migrations;

class Upgrade_nova2_tour
{
	public function up()
	{
		try
		{
			// get the number of docking items in the nova 2 table
			$c = \DB::query("SELECT docking_id FROM `nova2_docking`")->execute();
			$count = count($c);
			
			if ($count > 0)
			{
				/**
				 * Docking Items
				 */
				
				// drop the table installed with the system
				\DBUtil::drop_table('docking');
				
				// create a new table from the old data
				\DB::query('CREATE TABLE '.\DB::table_prefix().'docking SELECT * FROM `nova2_docking`')->execute();

				// change the columns
				\DB::query("ALTER TABLE ".\DB::table_prefix()."docking CHANGE `docking_id` `id` INT(11) NOT NULL")->execute();
				\DB::query("ALTER TABLE ".\DB::table_prefix()."docking CHANGE `docking_sim_name` `sim_name` VARCHAR(255) NULL")->execute();
				\DB::query("ALTER TABLE ".\DB::table_prefix()."docking CHANGE `docking_sim_url` `sim_url` TEXT NULL")->execute();
				\DB::query("ALTER TABLE ".\DB::table_prefix()."docking CHANGE `docking_gm_name` `gm_name` VARCHAR(255) NULL")->execute();
				\DB::query("ALTER TABLE ".\DB::table_prefix()."docking CHANGE `docking_gm_email` `gm_email` VARCHAR(255) NULL")->execute();
				\DB::query("ALTER TABLE ".\DB::table_prefix()."docking CHANGE `docking_status` `status` ENUM('active', 'inactive', 'pending') DEFAULT 'pending' NOT NULL")->execute();
				\DB::query("ALTER TABLE ".\DB::table_prefix()."docking CHANGE `docking_date` `date` BIGINT(20) NOT NULL")->execute();
				
				// make sure the primary key is set up properly
				\DB::query('ALTER TABLE '.\DB::table_prefix().'docking MODIFY COLUMN `id` INT(11) auto_increment primary key')->execute();
				
				/**
				 * Docking Sections
				 */
				
				// clear out the existing sections
				\DB::query("DELETE FROM `".\DB::table_prefix()."form_sections` WHERE `form_key` = 'docking'")->execute();
				
				// pull the sections
				$result = \DB::query("SELECT * FROM `nova2_docking_sections`")->execute();
				
				if (count($result) > 0)
				{
					$sections = array();
					
					foreach ($result as $r)
					{
						$data = array(
							'form_key' 	=> 'docking',
							'name' 		=> $r['section_name'],
							'order' 	=> $r['section_order']
						);
						
						// create the section record
						$item = \Model_Form_Section::create_item($data);
						
						// track the old and new IDs
						$sections[$r['section_id']] = $item->id;
					}
				}
				
				/**
				 * Docking Fields
				 */
				
				// clear out the existing fields
				\DB::query("DELETE FROM `".\DB::table_prefix()."form_fields` WHERE `form_key` = 'docking'")->execute();
				
				// pull the fields
				$result = \DB::query("SELECT * FROM `nova2_docking_fields`")->execute();
				
				if (count($result) > 0)
				{
					$fields = array();
					
					foreach ($result as $r)
					{
						$data = array(
							'form_key' 		=> 'docking',
							'section_id' 	=> $sections[$r['field_section']],
							'type' 			=> $r['field_type'],
							'html_name' 	=> $r['field_name'],
							'html_id' 		=> $r['field_fid'],
							'html_class' 	=> $r['field_class'],
							'html_rows' 	=> $r['field_rows'],
							'selected' 		=> '',
							'value' 		=> $r['field_value'],
							'label' 		=> $r['field_label_page'],
							'placeholder' 	=> '',
							'order' 		=> $r['field_order'],
							'display' 		=> ($r['field_display'] == 'y') ? (int) true : (int) false,
							'updated_at' 	=> time(),
						);
						
						// create the field record
						$item = \Model_Form_Field::create_item($data);
						
						// track the old and new IDs
						$fields[$r['field_id']] = $item->id;
					}
				}
				
				/**
				 * Docking Field Values
				 */
				
				// pull the values
				$result = \DB::query("SELECT * FROM `nova2_docking_values`")->execute();
				
				if (count($result) > 0)
				{
					$values = array();
					
					foreach ($result as $r)
					{
						$data = array(
							'field_id' 		=> $fields[$r['value_field']],
							'content' 		=> $r['value_content'],
							'order' 		=> $r['value_order'],
						);
						
						// create the value record
						$item = \Model_Form_Value::create_item($data);
						
						// track the old and new IDs
						$values[$r['value_id']] = $item->id;
					}
				}
				
				/**
				 * Docking Field Data
				 */
				
				// clear out the existing data
				\DB::query("DELETE FROM `".\DB::table_prefix()."form_data` WHERE `form_key` = 'docking'")->execute();
				
				// pull the data
				$result = \DB::query("SELECT * FROM `nova2_docking_data`")->execute();
				
				if (count($result) > 0)
				{
					foreach ($result as $r)
					{
						$data = array(
							'form_key' 		=> 'docking',
							'field_id' 		=> $fields[$r['data_field']],
							'user_id' 		=> 0,
							'character_id' 	=> 0,
							'item_id' 		=> $r['data_docking_item'],
							'value' 		=> $r['data_value'],
							'updated_at' 	=> time(),
						);
						
						// create the data record
						\Model_Form_Data::create_item($data);
					}
				}
			}
		}
		catch (\Database_Exception $e)
		{
			// nova 2 doesn't exist so we don't have anything to do
		}
	}

	public function down()
	{
		//\DBUtil::drop_table('docking');
	}
}
