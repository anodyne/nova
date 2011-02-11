# Creating, Updating, and Deleting Records

To illustrate the various methods used in manipulating records, we'll create,
save and delete a record.

### Creating and Updating

Both creation and updating is achieved with the `save()` method. Keep in mind
that `save()` may throw a `Validate_Exception` if your model doesn't validate
according to the rules you specify, so you should always test for this. Having
said that, we won't here just for clarity.

##### Example - Creating a new record

You can pass an array of values to set() or you can set the object members directly.

	Jelly::factory('post')
		 ->set(array(
			 'name'      => 'A new post',
			 'published' => TRUE,
			 'body'      => $body,
			 'author'    => $author,
			 'tags'      => $some_tags,
		 ))->save();

##### Example - Updating a record

Because the model is loaded, Jelly knows that you want to update, rather than insert.

	$post = Jelly::query('post', 1)->select();
	$post->name = 'A new name!';
	$post->save();

##### Example - Saving a record from $_POST data

One must take care to only insert the keys that are wanted, otherwise
there are significant security implications. For example, inserting the POST
data directly would allow an attacker to update fields that weren't
necessarily in the form.

	// Create emptymodel
	$model = Jelly::factory('post');

	// Extract the useful keys
	$model->set(Arr::extract($_POST, array('keys', 'to', 'use')));

	// Save model
	$model->save();

### Delete

Deleting is also quite simple with Jelly. You simply call the `delete()`
method on a model. The number of affected rows (1 or 0) will be returned.

##### Example - Deleting the currently loaded record

	$post = Jelly::query('post', 1)->select();
	$post->delete();