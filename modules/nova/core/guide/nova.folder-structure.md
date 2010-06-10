# Nova 2 Folder Structure

## The Application

The application directory is specific to your installation of Nova. We've worked hard to remove as much Nova core code from the application directory as possible. In fact, if you look through the application folder, you'll find that it's pretty bare. If you want to make quick and dirty changes to the system, like overriding a specific page, or adding new skins, that'll all be done through the application folder. Below is a rundown of the directories found in the application directory.

* __assets__ - stores system backups, common items (like genre assets), images and Javascript files
* __cache__ - stores any cache files created for the application by Kohana
* __classes__ - stores all PHP classes used in the system (this includes controllers, libraries, helpers and models ... Kohana makes little distinction between them)
* __config__ - stores configuration files used throughout the system
* __i18n__ - known in Nova 1 as <code>languages</code>, the i18n is the internationalization directory where translations of the system are stored (i18n is an acronym derived from the first and last letters of the word internationalization as well as a count of the characters between the first and last letters)
* __logs__ - stores any logs created by Kohana if an error is encountered (if error logging is turned on)
* __views__ - stores all of the skins used by Nova
* _bootstrap.php_ - the bootstrap file is used by Kohana to get the system rolling and setup the necessary components used through the system without any type of user interaction or instructions

## The Core

Kohana's core is stored in the system directory and contains all of the necessary files for Kohana to run. You should __never__ touch anything inside the system directory. Changes to that directory can cause Kohana (and by extension Nova) to stop working altogether. Below is a rundown of the directories found in the system directory.

* __classes__ - stores all PHP classes used in the system (this includes controllers, libraries, helpers and models ... Kohana makes little distinction between them)
* __config__ - stores configuration files used throughout the system
* __i18n__ - the i18n is the internationalization directory where translations of the system are stored (i18n is an acronym derived from the first and last letters of the word internationalization as well as a count of the characters between the first and last letters)
* messages
* utf8
* __views__ - stores the view files used by various components throughout the system
* _base.php_ - called by the system along with the bootstrap file to get the system rolling

## The Modules

Modules are a new feature to Nova that allow code to spread out across multiple modules. You'll find this comes in really handy when updating the system. You don't need to work around files you've modified, you just need to update a single directory. The modules directory is broken down in to 4 directories.

#### Kohana Modules

Stored in the <code>modules/kohana</code> directory, Kohana modules are the core modules that ship with Kohana. These modules include cache, codebench, database, image, pagination and userguide. Any future Kohana modules will be stored in here. Like the system core, you should __never__ touch files in the <code>modules/kohana</code> directory.

#### Nova Modules

Stored in the <code>modules/nova</code> directory, Nova modules are the core Nova system modules that Anodyne has developed. These modules include the core, the database forge, installation, the Jelly ORM, Thresher, the update module and the upgrade module. Like the system code and Kohana modules, you should __never__ touch files in the <code>modules/nova</code> directory.

#### Override Module

Unlike the Kohana and Nova modules, the override module is a standalone module that isn't nested inside another directory. The override module is a key component in seamless substitution that allows you to "override" the base view files for the entire system. More information about how to use the override module can be found in the tutorials.

#### Third Party Module

The third party module, located at <code>modules/third\_party</code> is designed for your own modules to extend the system and add functionality. Any module that you create or download should be stored in the third party module. This allows you to keep your own code separate from everything else and further separates the Nova core from your own code. More information about third party module development can be found on AnodyneDocs.