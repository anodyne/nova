Nested Sets
===========

Adds methods to the Fuel ORM model to work with nested tree database structures.

Introduction to nested sets
---------------------------

The nested set model is a particular technique for representing nested sets (also known as trees or hierarchies) in relational databases.
The term was apparently introduced by Joe Celko; others describe the same technique without naming it or using different terms. [Source: Wikipedia](http://en.wikipedia.org/wiki/Nested_set_model "Wikipedia - Nested Sets")

A typical example of a tree structure is an organigram of an organisation. We'll be using this to explain how nested sets work.

![Nested Sets Example](http://datamapper.wanwizard.eu/images/nestedsets.gif "Nested Sets Example")

The above diagram is indicating that each node is aware of all its descendents, and vice versa.
For example, we can see easily enough from the diagram that Ben and Angela are children of Bill.
We can also see that Tim And James are children of Ben.
This ultimately gives us a link between each member of the hierarchy.

For us to represent this we need to store two more values per node, that define the relationship between the nodes of the tree structure.
These are shown on the diagram in blue and red.
We call these Left (Red Values) and Right (Blue Values) pointers.
These values are stored on the table, this is all we need to fully represent a nested sets hierarchy.

Storing multiple tree structures
--------------------------------

You can store multiple tree structures into a single database table.
To make this possible, you can add a tree node index column to the table. The tree node index column is the ID that identifies the tree the node belongs to.

Symlinks
--------

A future version of this package will allow you to symlink (parts of) a tree, so you can make larger trees with parts of existing trees.


Table structure
---------------

	--
	-- Table structure for table `tree`
	--

	CREATE TABLE IF NOT EXISTS `tree` (
	  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
	  `left_id` int(9) unsigned NOT NULL,
	  `right_id` int(9) unsigned NOT NULL,
	  `tree_id` int(9) unsigned NOT NULL,
	  `symlink_id` int(9) unsigned NOT NULL,
	  PRIMARY KEY (`id`),
	  KEY `left_id` (`left_id`),		// optional, might speed up certain lookups
	  KEY `right_id` (`right_id`),		// optional, might speed up certain lookups
	  KEY `symlink_id` (`symlink_id`)	// optional, might speed up certain lookups
	)

Model definition
----------------

	class Model_Tree extends \Nestedsets\Model {

		/*
		 * @var		string	name of the table
		 */
		protected static $_table_name = 'pages';

		/*
		 * @var	custom nestedsets model tree properties
		 */
		public static $tree = array(
			'left_field'     => 'left_id',		// name of the tree node left index field
			'right_field'    => 'right_id',		// name of the tree node right index field
			'tree_field'     => null,			// name of the tree node tree index field
			'tree_value'     => null,			// value of the selected tree index
			'title_field'    => null,			// value of the tree node title field
			'symlink_field'  => 'symlink_id',	// name of the tree node tree index field
			'use_symlinks'   => false,			// use tree symlinks?
		);
	}

Available methods
-----------------

	public function tree_set_property($name, $value)
	public function tree_get_property($name)
	public function tree_select($tree = null)
	public function tree_new_root()
	public function tree_new_first_child_of(\Nestedsets\Model $object)
	public function tree_new_last_child_of(\Nestedsets\Model $object)
	public function tree_new_next_sibling_of(\Nestedsets\Model $object)
	public function tree_new_previous_sibling_of(\Nestedsets\Model $object)
	public function tree_get_root()
	public function tree_get_parent(\Nestedsets\Model $object)
	public function tree_get_first_child(\Nestedsets\Model $object)
	public function tree_get_last_child(\Nestedsets\Model $object)
	public function tree_get_previous_sibling(\Nestedsets\Model $object)
	public function tree_get_next_sibling(\Nestedsets\Model $object)
	public function tree_is_valid()
	public function tree_is_root()
	public function tree_is_leaf()
	public function tree_is_child()
	public function tree_is_child_of(\Nestedsets\Model $parent)
	public function tree_is_parent_of(\Nestedsets\Model $child)
	public function tree_has_parent()
	public function tree_has_children()
	public function tree_has_previous_sibling()
	public function tree_has_next_sibling()
	public function tree_count_children()
	public function tree_depth()
	public function tree_make_next_sibling_of(\Nestedsets\Model $to)
	public function tree_make_previous_sibling_of(\Nestedsets\Model $to)
	public function tree_make_first_child_of(\Nestedsets\Model $to)
	public function tree_make_last_child_of(\Nestedsets\Model $to)
	public function tree_delete_tree($all = false)
	public function tree_delete()
	public function tree_dump_dropdown($field = null, $skip_root = false)
	public function tree_dump_parent_dropdown($field = null, $skip_root = false)
	public function tree_dump_as_array(Array $attributes = array(), $skip_root = true)
	public function tree_dump_as_html(Array $attributes = array(), $skip_root = true)
	public function tree_dump_as_csv(Array $attributes = array(), $skip_root = true)
	public function tree_dump_as_tab(Array $attributes = array(), $skip_root = true)
	public function tree_get_tree_id()

Method documentation
--------------------

Currently, there is no documentation available.

However, the same methods are available in my nested sets extension for Datamapper, an ORM for CodeIgniter.

You can find the documentation for that extension here: http://datamapper.wanwizard.eu/pages/extensions/nestedsets.html
