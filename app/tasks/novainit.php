<?php
/**
 * The NovaInit task is used by the build script to generate the database schema
 * document the installation needs to install Nova.
 *
 * @package		Nova
 * @category	Task
 * @author		Anodyne Productions
 */

namespace Fuel\Tasks;

class NovaInit
{	
	/**
	 * Run the task.
	 *
	 * @internal
	 * @param	string	the command to run
	 * @return	void
	 */
	public static function run($command = 'help', $arg = 'y')
	{
		$return = '';

		switch ($command)
		{
			case 'help':
				static::help();
			break;

			case 'fields':
				static::generate_install_fields($arg);
			break;
			
			case 'backup':
				static::backup_install_fields();
			break;
		}
	}
	
	/**
	 * Help for the task.
	 *
	 * @internal
	 * @return	string	a CLI message
	 */
	public static function help()
	{
		$help = <<<HELP
\nUsage:
  php oil refine novainit
  php oil refine novainit fields
  php oil refine novainit backup

Description:
  This task is designed to be used by the build script to generate the database
  schema file necessary for installing Nova. USE EXTREME CAUTION WHEN RUNNING
  THIS TASK AS IT CAN CAUSE NOVA'S INSTALLATION TO BREAK!

Options:
  help          Show help for the task
  
  fields        Run the job that generates the schema file (y/n can be passed
  	            to this as well based on whether you want the job to attempt to
  	            backup the old file first).
  	            
  backup        Run the job that generates a backup of the old schema file.
HELP;

		\Cli::write($help);
	}
	
	/**
	 * Backup the database schema file so that we can track how it's changed
	 * between versions. The backup file will be named with the current version
	 * for the previous version's schema file.
	 *
	 * @internal
	 * @return	string	a CLI message
	 */
	public static function backup_install_fields()
	{
		// set the path
		$path = NOVAPATH.'setup/assets/';
		
		// manually add the nova module to the paths
		\Finder::instance()->add_path(\Module::load('nova'));
		
		// go out and load then merge the nova config files
		\Config::load('nova', true, false, true);
		
		// set the version number
		$version = \Config::get('nova.app_version_full');

		// check to see if the install file exists and if it does, back it up
		if (file_exists($path.'install/fields.php'))
		{
			if (file_exists($path.'backups/fields_'.$version.'.php'))
			{
				// read the file into a string
				$old_contents = md5(file_get_contents($path.'backups/fields_'.$version.'.php'));
				
				// get the contents of the file we're trying to backup
				$new_contents = md5(file_get_contents($path.'install/fields.php'));
				
				// if the two files are the same, delete the old one and put the new one in there
				if ($old_contents == $new_contents)
				{
					// delete the old file since it's the same as the one we're putting in
					unlink($path.'backups/fields_'.$version.'.php');
					
					// move the file to the backups location
					rename($path.'install/fields.php', $path.'backups/fields_'.$version.'.php');
				}
				else
				{
					// move the file to the backups location
					rename($path.'install/fields.php', $path.'backups/fields_'.$version.'_'.time().'.php');
				}
			}
			else
			{
				// move the file to the backups location
				rename($path.'install/fields.php', $path.'backups/fields_'.$version.'.php');
			}
		}
		
		// now check to see if the backup exists and print the appropriate message
		if (file_exists($path.'backups/fields_'.$version.'.php'))
		{
			\Cli::write('Database schema backed up successfully!', 'green');
		}
		else
		{
			\Cli::write('Database schema back up failed!', 'red');
		}
	}
	
	/**
	 * Generate the database schema file used by the install script. This will
	 * also attempt to backup the file unless the first paramter is set to NO.
	 *
	 * @internal
	 * @param	string	should a backup be attempted? (YES/NO)
	 * @return	string	a CLI message
	 */
	public static function generate_install_fields($attempt_backup = 'y')
	{
		if ($attempt_backup == 'y')
		{
			static::backup_install_fields();
		}
		
		// the data variable is used for storing the array of tables
		$data = '$data = array(';
		$data.= "\n";
		
		// the fields variable is used for storing all the field information
		$fields = '';
		
		// get the list of models
		$models = static::_model_list();
		
		foreach ($models as $m => $options)
		{
			// get the table name out of the model
			$_table_name = $m::$_table_name;
			
			// get the properties out of the model
			$_properties = $m::$_properties;
			
			/**
			 * Generate the array that stories information used to figure out
			 * what to pull for fields.
			 */
			if (array_key_exists('table', $options))
			{
				$data.= "\t'".$options['table']." => array(";
			}
			else
			{
				$data.= "\t'$_table_name' => array(";
			}
			
			$data_options = array();
			
			if (array_key_exists('fields', $options))
			{
				$data_options[] = "'fields' => '".$options['fields']."'";
			}
			
			if (array_key_exists('id', $options))
			{
				$data_options[] = "'id' => '".$options['id']."'";
			}
			
			if (array_key_exists('index', $options))
			{
				$data_options[] = "'index' => ".$options['index'];
			}
			
			$data.= implode(', ', $data_options);
			$data.= "),\n";
			
			/**
			 * Generate the array that will be used to build the table with all
			 * its options by the installation process.
			 */
			if (array_key_exists('fields', $options))
			{
				$fields.= '$'.$options['fields'].' = array('."\n";
			}
			else
			{
				$fields.= '$fields_'.$_table_name.' = array('."\n";
			}
			
			foreach ($_properties as $key => $value)
			{
				$type = ($value['type'] == 'string') ? 'VARCHAR' : strtoupper($value['type']);
				
				$fields.= "\t'$key' => array('type' => '".$type."'";
				
				/**
				 * Constraint
				 */
				if (array_key_exists('constraint', $value))
				{
					if (is_numeric($value['constraint']))
					{
						$fields.= ", 'constraint' => ".$value['constraint'];
					}
					else
					{
						if ($type == 'ENUM')
						{
							$fields.= ', \'constraint\' => "'.$value['constraint'].'"';
						}
						else
						{
							$fields.= ", 'constraint' => '".$value['constraint']."'";
						}
					}
				}
				
				/**
				 * Default
				 */
				if (array_key_exists('default', $value))
				{
					if (is_numeric($value['default']))
					{
						$fields.= ", 'default' => ".$value['default'];
					}
					else
					{
						$fields.= ", 'default' => '".$value['default']."'";
					}
				}
				
				/**
				 * Auto-increment
				 *
				 * This should only ever be TRUE if it appears
				 */
				if (isset($value['auto_increment']))
				{
					$fields.= ", 'auto_increment' => true";
				}

				/**
				 * Null
				 */
				if (array_key_exists('null', $value))
				{
					$value_to_put = ($value['null'] === true) ? 'true' : 'false';
					$fields.= ", 'null' => $value_to_put";
				}

				/**
				 * Unsigned
				 */
				if (array_key_exists('unsigned', $value))
				{
					$value_to_put = ($value['unsigned'] === true) ? 'true' : 'false';
					$fields.= ", 'unsigned' => $value_to_put";
				}
				
				$fields.= "),\n";
			}
			
			$fields.=");\n\n";
		}
		
		// close up the data array
		$data.= ");\n\n";
		
		// build the content
		$content = '<?php

$_genre = strtolower(\\Config::get(\'nova.genre\'));

'.$data.'
'.$fields;
		
		// create the new file with the content
		file_put_contents(NOVAPATH.'setup/assets/install/fields.php', $content);
		
		// print out a message to the CLI
		\Cli::write('Database schema file written.');
	}
	
	/**
	 * A list of models and any special options needed for the installation.
	 *
	 * @internal
	 * @return	array 	an array of models and their options
	 */
	private static function _model_list()
	{
		return array(
			'\\Model_Access_Role' => array(),
			'\\Model_Access_RoleTask' => array(),
			'\\Model_Access_Task' => array(),
			'\\Model_Announcement' => array(),
			'\\Model_AnnouncementCategory' => array(),
			'\\Model_Application' => array(),
			'\\Model_Award' => array(),
			'\\Model_Award_Category' => array(),
			'\\Model_Award_Queue' => array(),
			'\\Model_Award_Receive' => array(),
			'\\Model_Ban' => array(),
			'\\Model_Catalog_Module' => array(),
			'\\Model_Catalog_Rank' => array(),
			'\\Model_Catalog_Skin' => array(),
			'\\Model_Catalog_SkinSec' => array(),
			'\\Model_Catalog_Widget' => array(),
			'\\Model_Character' => array(),
			'\\Model_Character_Image' => array(),
			'\\Model_Character_Positions' => array(),
			'\\Model_Character_Promotion' => array(),
			'\\Model_Comment' => array(),
			'\\Model_Department' => array(
				'table' => 'departments_\'.$_genre',
				'fields' => 'fields_departments',
			),
			'\\Model_Form' => array(),
			'\\Model_Form_Data' => array(),
			'\\Model_Form_Field' => array(),
			'\\Model_Form_Section' => array(),
			'\\Model_Form_Tab' => array(),
			'\\Model_Form_Value' => array(),
			'\\Model_Manifest' => array(),
			'\\Model_Media' => array(),
			'\\Model_Message' => array(),
			'\\Model_MessageRecipient' => array(),
			'\\Model_Mission' => array(),
			'\\Model_MissionGroup' => array(),
			'\\Model_Moderation' => array(),
			'\\Model_Nav' => array(),
			'\\Model_PersonalLog' => array(),
			'\\Model_Position' => array(
				'table' => 'positions_\'.$_genre',
				'fields' => 'fields_positions',
			),
			'\\Model_Post' => array(),
			'\\Model_PostAuthor' => array(),
			'\\Model_Rank' => array(
				'table' => 'ranks_\'.$_genre',
				'fields' => 'fields_ranks',
			),
			'\\Model_Session' => array(
				'id' => 'session_id',
				'index' => "array('previous_id')",
			),
			'\\Model_Settings' => array(),
			'\\Model_SimType' => array(),
			'\\Model_SiteContent' => array(),
			'\\Model_Spec' => array(),
			'\\Model_System' => array(),
			'\\Model_SystemEvent' => array(),
			'\\Model_Tour' => array(),
			'\\Model_TourDeck' => array(),
			'\\Model_User' => array(),
			'\\Model_User_Loa' => array(),
			'\\Model_User_Preferences' => array(),
			'\\Model_User_Suspend' => array(),
			
			'\\Model_Wiki_Category' => array(),
			'\\Model_Wiki_Draft' => array(),
			'\\Model_Wiki_Page' => array(),
			'\\Model_Wiki_Restriction' => array(),
			
			// Forum models go here
		);
	}
}
