# Milestone 1

Begin the conversion to Kohana's architecture. Allow the system to be installed through Kohana 3.

## Completion Criteria

* Be able to install Nova 2
* Be able to upgrade to Nova 2 from SMS 2
* Be able to update from Nova 1.x to Nova 2
* Be able to update from Nova 2.x to Nova 2.x(+1)

## Notable Changes

* The first step of the install process will attempt to write the database configuration file for you like SMS did
* The install process is now only 3 steps instead of 5
* The install process now only asks you for sim name, your name, email address, password (and confirms your password), your character's first and last name, position and rank. Everything else is assumed and can be changed later
* The verification tool can more accurately predict if and when there will be issues
* The genre panel now lets you install and uninstall genres, though you can't uninstall the genre that's current set up in the nova config file

# Milestone 2

Continue the conversion to Kohana's architecture. Complete conversion of the main, personnel, sim and search controllers. Convert the Auth library to allow logging in to Nova 2.

## Completion Criteria

* Main controller
* Personnel controller
* Sim controller
* Search controller
* Login controller

# Milestone 3

## Completion Criteria

* Admin controller
* Messages controller
* Write controller
* User controller
* Character controller

# Milestone 4

## Completion Criteria

* Site controller
* Manage controller

# Milestone 5

## Completion Criteria

* Thresher