* Remove the old source
* Pull from Github
* Cleanup files
    * Remove the .gitignore file
    * Remove the .git file
    * Remove the genre assets
    * Remove anything in the app/logs directory
    * Remove anything in the app/cache directory
    * Remove the app/config/development directory
    * Remove the NovaInit task
* Run unit tests
    * Stop on fail
    * If unit tests pass, log the result and remove the tests directories
* Run phpDocumentor
    * Deploy the content to AnodyneDocs
    * Remove the output from the source directory
* Move the config file in to place
    * Make sure the proper environment is set
* Compile the LESS files into the right locations
    * Make sure we have both a minified version as well as a development version
* Build the zip files for individual genres
* Deploy the zip files to the server