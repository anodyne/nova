# Filters

Filters are used to format the data before it is inserted to the database. You can define filters just the way you
define [validation rules](../jelly/validation). The only difference is that you do not have the ability to pass the
validation object (`:validation` wildcard) in the parameters as filters are not part of validation.

## Adding filters
To add filters create a `filters` array when defining the field.

	// ...
	'name' => Jelly::field('string', array(
		// Array for filters
		'filters' => array(),
	)),

### An example

	// ...
	'name' => Jelly::field('string', array(
		'filters' => array(
			// Use the existing 'trim' PHP function to remove whitespace
			array('trim'),
			// Use a filter defined in this model and named 'custom_filter' to format the value
			array(array(':model', 'custom_filter')),
			// Use Kohana's built-in function to make every word's first letter uppercase
			array('UTF8::ucwords'),
		),
	)),