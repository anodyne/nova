<?php
/**
 * The NovaInit task is used by the build script to generate the database schema
 * document the installation needs to install Nova.
 *
 * @package		Nova
 * @category	Tasks
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */

class NovaInit {
	
	/**
	 * Run the task.
	 *
	 * @access	public
	 * @param	string	the command to run
	 * @return	void
	 */
	public static function run($command = 'help')
	{
		$return = '';
		
		switch ($command)
		{
			case 'help':
				static::help();
			break;

			case 'fields':
				static::generate_install_fields();
			break;
			
			case 'backup':
				static::backup_install_fields();
			break;
		}
	}
	
	/**
	 * Help for the task.
	 *
	 * @access	public
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
  
  fields        Run the job that generates the schema file (YES/NO can be passed
  	            to this as well based on whether you want the job to attempt to
  	            backup the old file first).
  	            
  backup        Run the job that generates a backup of the old schema file.
HELP;

		Cli::write($help);
	}
	
	/**
	 * Backup the database schema file so that we can track how it's changed
	 * between versions. The backup file will be named with the current version
	 * for the previous version's schema file.
	 *
	 * @access	public
	 * @return	string	a CLI message
	 */
	public static function backup_install_fields()
	{
		// set the path
		$path = MODPATH.'app/modules/setup/assets/install/';
		
		// set the version number
		$version = Kohana::config('nova.app_version_full');
		
		// check to see if the install file exists and if it does, back it up
		if (file_exists($path.'fields.php'))
		{
			if (file_exists($path.'backups/fields_'.$version.'.php'))
			{
				// read the file into a string
				$old_contents = md5(file_get_contents($path.'backups/fields_'.$version.'.php'));
				
				// get the contents of the file we're trying to backup
				$new_contents = md5(file_get_contents($path.'fields.php'));
				
				// if the two files are the same, delete the old one and put the new one in there
				if ($old_contents == $new_contents)
				{
					// delete the old file since it's the same as the one we're putting in
					unlink($path.'backups/fields_'.$version.'.php');
					
					// move the file to the backups location
					rename($path.'fields.php', $path.'backups/fields_'.$version.'.php');
				}
				else
				{
					// move the file to the backups location
					rename($path.'fields.php', $path.'backups/fields_'.$version.'_'.time().'.php');
				}
			}
			else
			{
				// move the file to the backups location
				rename($path.'fields.php', $path.'backups/fields_'.$version.'.php');
			}
		}
		
		// now check to see if the backup exists and print the appropriate message
		if (file_exists($path.'backups/fields_'.$version.'.php'))
		{
			Cli::write('Database schema backed up successfully!', 'green');
		}
		else
		{
			Cli::write('Database schema back up failed!', 'red');
		}
	}
	
	/**
	 * Generate the database schema file used by the install script. This will
	 * also attempt to backup the file unless the first paramter is set to NO.
	 *
	 * @access	public
	 * @param	string	should a backup be attempted? (YES/NO)
	 * @return	string	a CLI message
	 */
	public static function generate_install_fields($attempt_backup = 'YES')
	{
		if ($attempt_backup == 'YES')
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
			if (isset($options['table']))
			{
				$data.= "\t'".$options['table']." => array(";
			}
			else
			{
				$data.= "\t'$_table_name' => array(";
			}
			
			$data_options = array();
			
			if (isset($options['fields']))
			{
				$data_options[] = "'fields' => '".$options['fields']."'";
			}
			
			if (isset($options['id']))
			{
				$data_options[] = "'id' => '".$options['id']."'";
			}
			
			if (isset($options['index']))
			{
				$data_options[] = "'index' => ".$options['index'];
			}
			
			$data.= implode(', ', $data_options);
			$data.= "),\n";
			
			/**
			 * Generate the array that will be used to build the table with all
			 * its options by the installation process.
			 */
			if (isset($options['fields']))
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
				
				if (isset($value['constraint']))
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
				
				if (isset($value['default']))
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
				
				// the only time this should show up is when it's true
				if (isset($value['auto_increment']))
				{
					$fields.= ", 'auto_increment' => true";
				}
				
				$fields.= "),\n";
			}
			
			$fields.=");\n\n";
		}
		
		// close up the data array
		$data.= ");\n\n";
		
		// build the content
		$content = '<?php

$_genre = strtolower(Kohana::config(\'nova.genre\'));

'.$data.'
'.$fields;
		
		// create the new file with the content
		file_put_contents(MODPATH.'app/modules/setup/assets/install/fields.php', $content);
		
		// print out a message to the CLI
		Cli::write('Database schema file written.');
	}
	
	/**
	 * A list of models and any special options needed for the installation.
	 *
	 * @access	private
	 * @return	array 	an array of models and their options
	 */
	private static function _model_list()
	{
		return array(
			'Model_AccessGroup' => array(),
			'Model_AccessPage' => array(),
			'Model_AccessRole' => array(),
			'Model_Application' => array(),
			'Model_Award' => array(),
			'Model_AwardQueue' => array(),
			'Model_AwardRec' => array(),
			'Model_CatalogueModule' => array(),
			'Model_CatalogueRank' => array(),
			'Model_CatalogueSkin' => array(),
			'Model_CatalogueSkinSec' => array(),
			'Model_CatalogueWidget' => array(),
			'Model_Character' => array(),
			'Model_CharacterImage' => array(),
			'Model_CharacterPromotion' => array(),
			'Model_Coc' => array(),
			'Model_Comment' => array(),
			'Model_Department' => array(
				'table' => 'departments_\'.$_genre',
				'fields' => 'fields_departments',
			),
			'Model_Docking' => array(),
			'Model_Form' => array(),
			'Model_FormData' => array(),
			'Model_FormField' => array(),
			'Model_FormSection' => array(),
			'Model_FormTab' => array(),
			'Model_FormValue' => array(),
			'Model_LoginAttempts' => array(),
			'Model_Manifest' => array(),
			'Model_Menu' => array(),
			'Model_MenuCat' => array(),
			'Model_Message' => array(),
			'Model_MessageRecipient' => array(),
			'Model_Mission' => array(),
			'Model_MissionGroup' => array(),
			'Model_Moderation' => array(),
			'Model_News' => array(),
			'Model_NewsCategory' => array(),
			'Model_PersonalLog' => array(),
			'Model_Position' => array(
				'table' => 'positions_\'.$_genre',
				'fields' => 'fields_positions',
			),
			'Model_Post' => array(),
			'Model_PostAuthor' => array(),
			'Model_Rank' => array(
				'table' => 'ranks_\'.$_genre',
				'fields' => 'fields_ranks',
			),
			'Model_SecurityQuestion' => array(),
			'Model_Session' => array(
				'id' => 'session_id',
				'index' => "array('last_active')",
			),
			'Model_Settings' => array(),
			'Model_SimType' => array(),
			'Model_SiteContent' => array(),
			'Model_Spec' => array(),
			'Model_System' => array(),
			'Model_SystemComponent' => array(),
			'Model_SystemVersion' => array(),
			'Model_Tour' => array(),
			'Model_TourDeck' => array(),
			'Model_Upload' => array(),
			'Model_User' => array(),
			'Model_UserLoa' => array(),
			'Model_UserPref' => array(),
			'Model_UserPrefValue' => array(),
			
			'Model_WikiCategory' => array(),
			'Model_WikiDraft' => array(),
			'Model_WikiPage' => array(),
			
			/*
			Forum models go here
			*/
		);
	}
}
