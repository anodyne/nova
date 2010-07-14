# Nova 2 Module: Upgrade

The Nova 2 upgrade module provides functionality to upgrade SMS 2 (must have at least version 2.6.9 or higher) to Nova 2. This is a core module that ships with Nova 2 and is disabled by default. To enable the module, open application/config/nova.php and uncomment the upgrade module line.

## Version

1.0

## TODO

* uncomment the redirects in the _before()_ method after the login controller is completed
* uncomment the registration code
* clean up the upgrade registration
* change i18n over to the newer format

## History

<table>
	<tr>
		<th>Module Version</th><th>Nova Version</th><th>Description</th>
	</tr>
	<tr>
		<td>1.0</td><td>2.0</td><td>Initial release</td>
	</tr>
</table>