# Development Milestones

Starting with Nova 1, Anodyne has taken a milestone-based approach to Nova's development. This allows us to work on specific areas of the system and not worry about other portions. Additionally, it helps testers knowing that when they download a specific milestone, they know exactly what's being worked on and what's finished. Below is the preliminary schedule for Nova 2's milestones.

__Current Milestone:__ M1.1

[!!] As with all development details, these are subject to change over the course of development.

## Milestone 1

Begin the conversion to Kohana 3 and refactor to allow the system to be installed through Kohana 3.

#### Completion Criteria

* Be able to install Nova 2
* Be able to upgrade to Nova 2 from SMS 2
* Be able to update from Nova 1.x to Nova 2
* Be able to update from Nova 2.x to Nova 2.x(+1)

#### Notable Changes

* __Core__
	* Transition over to Kohana 3
	* Transition over to the Jelly ORM
	* All-new layouts system that moves all the system code into layout file and skin files are only the stuff found in the BODY tag
* __Pre-Install__
	* Nova will check for the existence of a database config file, if none exists, it'll kick off a process to help you write the file to your server (like SMS would do)
	* Server verification tool is smarter and can detect problems in advance more accurately than Nova 1
* __Installation__
	* Streamlined the process from 5 steps down to 3
	* Streamlined the information you have to give Nova during installation (now only asks for sim name, your name, your email address password and your character information)
* __Post-Install__
	* The genre panel now lets you install and uninstall genres (though you can't uninstall a genre that's currently set up in the Nova config file)
	* The change database panel now lets you input free-form SQL queries (helpful for installing MODs)
	* Nova 2 requires you to be logged in and the system administrator in order to access the install module and take any actions
* __Upgrade__
	* Streamlined the process from 14 steps down to 4
	* All-new user interface for selecting which items should and shouldn't be upgraded (no more setting the information in a config file)
	* All-new user interface for setting the password for all users (no more setting the password in a config file)
	* All-new user interface for setting the system administrator (no more setting the admin's email address in a config file)
	* The ability to set multiple users as system administrators
	* New dependencies code makes sure you can't upgrade something without everything it needs
	* No more requirement for the DS9 genre
		* _Nova will check to see if any changes have been made to the specs or tour tables in SMS. If there haven't been any changes then regardless of genre, you'll be able to run the upgrade for specs as well as everything else._

## Milestone 2

Continue the conversion to Kohana's architecture. Complete conversion of the main, personnel, sim and search controllers. Convert the Auth library to allow logging in to Nova 2.

#### Completion Criteria

* Main controller
* Personnel controller
* Sim controller
* Search controller
* Login controller

#### Notable Changes

* __Search__
	* All-new user interface for search that provides both a simpler experience and more powerful search options
	* Ability to search through multiple criteria simultaneously

## Milestone 3

#### Completion Criteria

* Admin controller
* Messages controller
* Write controller
* User controller
* Character controller

## Milestone 4

#### Completion Criteria

* Site controller
* Manage controller

## Milestone 5

#### Completion Criteria

* Thresher