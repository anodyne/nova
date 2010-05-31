# Milestone 1

## Goal
Begin the conversion to Kohana's architecture. Allow the system to be installed through Kohana 3.

## Completion Criteria
The ability to install Nova 2, upgrade from SMS 2, update from Nova 1 and update within the 2.x line. By the time M1 closes, the install, upgrade and update modules should be complete.

## Notable Changes
* The first step of the install process will attempt to write the database configuration file for you like SMS did
* The install process is now only 3 steps instead of 5
* The install process now only asks you for sim name, your name, email address, password (and confirms your password), your character's first and last name, position and rank. Everything else is assumed and can be changed later
* The verification tool can more accurately predict if and when there will be issues

# Milestone 2

## Goal
Continue the conversion to Kohana's architecture. Complete conversion of the main, personnel, sim and search controllers. Convert the Auth library to allow logging in to Nova 2.

## Completion Criteria
Finish the main, personnel, sim and search controllers. The ability to login to the system.