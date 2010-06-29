# Nova 2 Module: Install

The Nova 2 install module provides functionality to create the database config file on the fly, install Nova 2 into a given database and make changes to the database based on user input. This is a core module that ships with Nova 2 and is enabled by default.

## Version

1.0

## Latest Changes

* updated the data file to reflect the removal of colorbox and addition of fancybox
* updated the controller to pull the system defaults for skin sections and ranks
* created readme file

## TODO

* uncomment the redirects in the _before()_ method after the login controller is completed
* better styling for the progress bar
* clean up the install registration
* test the quick install
* rank image names (and)
* change i18n over to the newer format
* should the install assets go into the nova assets module?

## History

<table>
	<tr>
		<th>Module Version</th><th>Nova Version</th><th>Description</th>
	</tr>
	<tr>
		<td>1.0</td><td>2.0</td><td>Initial release</td>
	</tr>
</table>