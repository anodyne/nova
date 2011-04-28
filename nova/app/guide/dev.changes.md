# Notable Changes

Version 2 is a huge leap forward for Nova and there are a lot of changes. This page highlights some of the major (and some minor) changes to the system to date.

* __Core__
  * Transition over to Kohana 3
  * Transition over to the Jelly ORM
  * All-new layouts system that moves all the system code into layout file and skin files are only the stuff found in the BODY tag
  * Storing code in modules instead of the application directory now
      * Critical modules are loaded from the bootstrap file
      * Non-critical modules (i.e. 3rd party modules) are loaded out of the database
* __Pre-Install__
  * Nova will check for the existence of a database config file, if none exists, it'll kick off a process to help you write the file to your server (like SMS would do)
  * Server verification tool is smarter and can detect problems in advance more accurately than Nova 1
* __Installation__
  * Streamlined the process from 5 steps down to 3
  * Streamlined the information you have to give Nova during installation (now only asks for sim name, your name, your email address password and your character information)
* __Post-Install__
  * The genre panel now lets you install and uninstall genres (though you can't uninstall a genre that's currently set up in the Nova config file)
  * The change database panel now lets you input free-form SQL queries (helpful for installing MODs)
  * Nova 2 requires you to be logged in and the system administrator in order to access the install module and take any actions (besides initially installing the system)
* __Upgrade__
  * Streamlined the process from 14 steps down to 4
  * All-new user interface for selecting which items should and shouldn't be upgraded (no more setting the information in a config file)
  * All-new user interface for setting the password for all users (no more setting the password in a config file)
  * All-new user interface for setting the system administrator (no more setting the admin's email address in a config file)
  * The ability to set multiple users as system administrators
  * New dependencies code makes sure you can't upgrade something without everything it needs
  * No more requirement for the DS9 genre
      * _Nova will check to see if any changes have been made to the specs or tour tables in SMS. If there haven't been any changes then regardless of genre, you'll be able to run the upgrade for specs as well as everything else._
* __Admin Control Panel__
  * When a user logss in after resetting their password, instead of a popup, Nova asks for a new password at the top of the ACP