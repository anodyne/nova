# Validation

Validation will take care of checking the data submitted to the database. It is a near direct port of Kohana ORM's
validation with a few small differences. To have your data validated you'll have to add rules to fields when defining
models.

There are three different type of rules you can use when validating:

-   the built-in [Kohana validation rules](../kohana/security/validation#default-rules)
-   any existing PHP function
-   custom callback

## Adding rules
To add rules create a `rules` array when defining the field.

	// ...
	'name' => Jelly::field('string', array(
		// Array for rules
		'rules' => array(),
	)),

### Defining built-in rules
When adding built-in rules that only accept the field's value all you have to do is to set the name of the rule:
`array('name_of_the_rule')`

	// ...
	'name' => Jelly::field('string', array(
		'rules' => array(
			// Add rule that only accepts the field value
			array('not_empty'),
		),
	)),

This is the same like calling the function like this: `Valid::not_empty('value_of_the_field')`

Adding built-in rules that accept parameters as well requires you to define rules like this:
`array('name_of_the_rule', array('value_of_the_field', 'parameter_for_the_rule'))`

	// ...
	'name' => Jelly::field('string', array(
		'rules' => array(
			// Add rule that accepts parameters as well
			array('max_length', array(':value', 32)),
		),
	)),

This is the same like calling the function like this: `Valid::max_length('value_of_the_field', 32)`

[!!] Note: the `:value` wildcard will be automatically replaced with the field's value, that is the way you pass it to
different methods, in this case to `Valid::max_length`.

### Defining existing PHP functions as rules
You can use existing PHP functions to validate your data. When adding a rule like this do just like in the example above for built-in functions.
Functions that only need the field value are defined like this:
`array('name_of_the_function')`

	// ...
	'name' => Jelly::field('string', array(
		'rules' => array(
			// Add rule that only accepts the field value
			array('is_writable'),
		),
	))

This is the same like calling the function like this: `is_writable('value_of_the_field')`

Functions that accept parameters are defined this way:
`array('name_of_the_function', array('value_of_the_field', 'parameter_for_the_function'))`

	// ...
	'name' => Jelly::field('string', array(
		'rules' => array(
			// Add rule that accepts parameters as well
			array('mb-check-encoding', array(':value', 'UTF-8')),
		),
	)),

This is the same like calling the function like this: `is_writable('mb-check-encoding', 'UTF-8')`

### Defining custom callbacks as rules
You can use any kind of custom defined callback as a rule. When defining custom callbacks as rules think about them like this:

`array('the_method_to_call', ('parameters_for_the_method'))`

__'the_method_to_call' can be set in the following ways:__

 -   `'Class::static_method'`
 -   `array('Class::static_method', 'dynamic_method_name')`
 -   `array(':model', 'method_name')`
 -   `array(':field', 'method_name')`


[!!] Using the `:model` wildcard when defining the `'the_function_to_call'` part of the rule would mean that the function
is defined within the model. The `:field` wildcard is replaced with the field object, which is useful when you define a
custom field and define your callback inside it.

__In the 'parameters_for_the_method' part you can pass these values:__

 -   the actual value for the parameter
 -   `:value`
 -   `:field`
 -   `:model`
 -   `:validation`

[!!] As you already know the `:value` wildcard is replaced with the value of the field. The `:field` wildcard is exchanged
with the name of the field, while the `:model` is replaced with the model object, and the `:validation` wildcard with the
validation object.

An example would be the validation of file uploads. `Jelly_Field_File` has a callback named `_upload`:

	public function _upload(Validation $validation, $model, $field)
	{
		if ($validation->errors())
		{
			// There are already errors, don't continue
			return FALSE;
		}

		// Get the image from the validation object
		$file = $validation[$field];

		if ( ! is_array($file) OR ! Upload::valid($file) OR ! Upload::not_empty($file))
		{
			return FALSE;
		}

		// Check to see if it is a valid type
		if ($this->types AND ! Upload::type($file, $this->types))
		{
			// Add an error with the name of the field
			$validation->error($field, 'Upload::type');
			return FALSE;
		}

		// Etc...
	}

To get this callback working the field defines a rule this way:
`array(array(':field', '_upload'), array(':validation', ':model', ':field'))`

This translates to: "look for a method in this field's object called '_upload' and pass the validation and model
objects, and the name of the field".

[!!] Note the part that adds an error when running into problems. This is the way you can add your own errors and this
is required when using custom callbacks.

## Checking if the model is valid

Validation is done automatically when calling `save()`. You should expect a [Jelly_Validation_Exception](../api/Jelly_Validation_Exception)
thrown:

	try
    {
        $user = Jelly::factory('user');
        $user->username = 'invalid username';
        $user->save();
    }
    catch (Jelly_Validation_Exception $e)
    {
        // Get the error messages
        $errors = $e->errors();
    }

### Error messages

When getting the error messages like in the example above (`$e->errors()`) you can pass two parameters just like you can
with `Validation::errors()`. The only difference is the first parameter is not the file name, it is a directory name that
will be appended to the model's name for creating a directory path to the error messages.

So, using the example above you pass `jelly-validation` as the directory name like this: `$e->errors('jelly-validation')`.
That means you defined this path: `application/messages/jelly-validation/user.php`, and you should create that file in
order to retrieve the error messages.

The second parameter you can pass to this method is identical to the `Validation::errors()` second parameter and it
deals with the translation of the error messages.

### External validation

Certain forms contain information that should not be validated by the model, but by the controller. Information such as
a [CSRF](http://en.wikipedia.org/wiki/Cross-site_request_forgery) token, password verification, or a
[CAPTCHA](http://en.wikipedia.org/wiki/CAPTCHA) should never be validated by a model. However, validating information
in multiple places and combining the errors to provide the user with a good experience is often quite tedius.
For this reason, the [Jelly_Validation_Exception] is built to handle multiple Validation objects and namespaces the
array of errors automatically for you. `Jelly::save()` all take an optional first parameter which is a [Validation]
object to validate along with the model.

	public function action_create()
	{
		try
		{
			$user = Jelly::factory('user');
			$user->username = $_POST['username'];
			$user->password = $_POST['password'];

			$extra_rules = Validation::factory($_POST)
				->rule('password_confirm', 'matches', array(
					':validation', ':field', 'password'
				));

			// Pass the extra rules to be validated with the model
			$user->save($extra_rules);
		}
		catch (Jelly_Validation_Exception $e)
		{
			$errors = $e->errors('models');
		}
	}

Because the validation object was passed as a parameter to the model, any errors found in that check will be namespaced
into a sub-array called `_external`. The array of errors would look something like this:

	array(
		'username'  => 'This field cannot be empty.',
		'_external' => array(
			'password_confirm' => 'The values you entered in the password fields did not match.',
		),
	);

This ensures that errors from multiple validation objects and models will never overwrite each other.

### Ignoring validation

In certain situations - such as saving a new user in the database with partial information after signing-up via an
OAuth provider - you might need to ignore the validation rules in defined in the model.

To achieve this pass `FALSE` to `Jelly::save()` which will skip the validation process and saves the model whatever data
is submitted.

If you have defined any [filters](filters) in the model they will still run. Do not forget to validate the data using
Kohana's validation if you need to.

	public function action_create_twitter()
	{
		$user = Jelly::factory('user');
		$user->username = $_POST['twitter_id'];

		$user->save(FALSE);
	}