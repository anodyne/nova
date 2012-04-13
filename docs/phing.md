* Remove the old source
* Pull from Github
* Cleanup files
    * Remove the .gitignore file
    * Remove the .git file
    * Remove the genre assets
    * Remove anything in the app/logs directory
    * Remove anything in the app/cache directory
* Run unit tests
    * Stop on fail
    * If unit tests pass, log the result and remove the tests directories
* Run DocBlox
    * Deploy the content to AnodyneDocs
    * Remove the output from the source directory
* Move the config file in to place
    * Make sure the proper environment is set
* Compile the LESS files into the right locations
* Run NovaInit
    * Run the command through oil (php oil refine novainit)
	* Remove the field backups
	* Remove the NovaInit task after the process is finished
* Build the zip files for individual genres
* Deploy the zip files to the server