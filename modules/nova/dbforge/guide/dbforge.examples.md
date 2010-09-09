# Examples

Using DBForge is straightforward, but you should use extreme caution when using the DBForge. If you make changes to the database, there is no way to roll those changes back. Make sure you know what you're doing before you start!

The full DBForge API reference is available in the [API Browser](api/DBForge).

## Creating Tables

Creating a table with the DBForge is easy, but does require three steps in order to do it. For these examples, we're going to be creating a database table that will hold a listing of snacks that we can have after work/school. However, before we do anything in the database, we have to define the fields that'll be in our table. Fortunately, the DBForge accepts multi-dimensional arrays, so you can define all your fields at the same time.

<pre><code>$fields = array(
	'id' => array(
		'type' => 'INT',
		'constraint' => 5,
		'auto_increment' => TRUE),
	'name' => array(
		'type' => 'VARCHAR',
		'constraint' => 100,
		'default' => ''),
	'type' => array(
		'type' => 'ENUM',
		'constraint' => "'fruit', 'vegetable', 'chips', 'cookies'",
		'default' => 'fruit'),
	'description' => array(
		'type' => 'TEXT'),
);

DBForge::add_field($fields);</code></pre>

The above code is important to understand. We'll break it down by each field.

##### ID

The ID will be our primary means of identifying which record we're talking about. When it comes to a table of snacks, we could potentially have several snacks called "Apple" and then use the description to define what kind of apple it is. Because of this, we need some way of knowing exactly which record we want to pull. (Yes, this is more about database design and less about the DBForge, but it's important to understand both.) In this case, the name of our field is ID, it's an integer field that can be no more than 5 characters long. Because this is going to be our primary key, we've also set it to auto increment for us.

In addition to auto_increment, the DBForge also allows other key/value pairs to be used, such as unsigned and null.

##### Name

The name field will be how users know what snack we're talking about. This field is a VARCHAR field that can be no longer than 100 characters and has a blank value for its default. We could also have dropped the default key/value pair and it would've become a null field if there was nothing in it.

##### Type

The type field shows how to create enumerated lists. Instead of an integer constraint, for enumerated fields, our constraint are the available options. Take note that these options all need to be wrapped in single quotes like you would if creating the raw SQL query. Finally, we set the default value.

##### Description

Our last field is the description which we'll make a text field. It's important when using the DBForge to understand the database you're creating. Just because this tool exists isn't an excuse not to understand what you're doing. The text field is a perfect example. You could just as easily copy the VARCHAR field and think you're done with it, but MySQL doesn't actually allow default values for text fields, so your table creation will fail. Make sure you keep an eye out for these types of things!

Now that we've added our fields, we need to define any keys we want to use. At the very least, you'll need to define a primary key for the table which can you do using the _add\_key()_ method's second boolean parameter.

<pre><code>DBForge::add_key('id', TRUE);</code></pre>

The last step is to take all the compiled information and create the table. Running this method will create a table with the name passed to the method and will also prepend the database table prefix to the table name.

<pre><code>DBForge::create_table('snacks');</code></pre>

## Dropping Tables

If we decide at a later date that we don't want our snacks table any more, we can easily remove it.

<pre><code>DBForge::drop_table('snacks');</code></pre>

## Adding Fields to a Table

Now we have our snacks table and we're using it just fine until we realize it'd be awesome to be able to show calorie information about our snack too. Instead of writing a SQL query, we can just use the DBForge to add a field to our table.

<pre><code>$fields = array(
	'calories' => array(
		'type' => 'INT',
		'constraint' => 4),
);

DBForge::add_column('snacks', $fields);</code></pre>

Easy as pie!

## Modifying Fields in a Table

Pie? That's not on our list of snacks. We need pie on our list of snacks. Of course, if we're adding pie, we should probably also be showing more than just calorie information, so let's also change the calories field to nutritional information.

<pre><code>$fields = array(
	'type' => array(
		'name' => 'type',
		'constraint' => "'fruit', 'vegetable', 'chips', 'cookies', 'pie'"),
	'calories' => array(
		'name' => 'nutritional_info',
		'type' => 'TEXT'),
);

DBForge::modify_column('snacks', $fields);</code></pre>

One thing to note here is the name key/pair we've added here. In order to use the _modify\_column()_ method, we have to tell it what field we're targeting and then we have the option to change the name or leave it the same. If we're leaving it the same, the name field will be the same as it is currently.

## Dropping Fields from a Table

After a while though, we're getting a little depressed looking at the nutritional information, so let's drop that off the database because, let's be fair, we really don't want to see that information. Dropping a column is easy.

<pre><code>DBForge::drop_column('snacks', 'nutrional_info');</code></pre>