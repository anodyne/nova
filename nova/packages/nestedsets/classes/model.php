<?php
/**
 * NestedSets
 *
 * NestedSets is a FuelPHP ORM Model extension that introduces nested sets
 * functionality to the ORM.
 *
 * @package    Fuel
 * @version    1.0
 * @author     Harro "WanWizard" Verton
 * @license    MIT License
 * @copyright  2011-2012 Exite Development Services
 * @link       http://exite.eu
 */

namespace Nestedsets;

/*
 * Make sure the ORM package is loaded
 */
\Package::load('orm');

/**
 * Model class.
 *
 * @package nestedsets
 */
class Model extends \Orm\Model {

	/* ---------------------------------------------------------------------------
	 * Static usage
	 * --------------------------------------------------------------------------- */

	/*
	 * @var	default nestedset tree configuration
	 */
	protected static $defaults = array(
		'left_field'     => 'left_id',		// name of the tree node left index field
		'right_field'    => 'right_id',		// name of the tree node right index field
		'tree_field'     => null,			// name of the tree node tree index field
		'tree_value'     => null,			// value of the selected tree index
		'title_field'    => null,			// value of the tree node title field
		'symlink_field'  => 'symlink_id',	// name of the tree node tree index field
		'use_symlinks'   => false,			// use tree symlinks?
	);

	/* ---------------------------------------------------------------------------
	 * Dynamic usage
	 * --------------------------------------------------------------------------- */

	/**
	 * flag to log update queries for debugging purposes
	 *
	 * @var    array
	 */
	protected $_debug_queries = false;

	/**
	 * tree configuration for this instance
	 *
	 * @var    array
	 */
	private $configuration = array(
	);

	/**
	 * readonly fields for this model
	 *
	 * @var    array
	 */
	private $readonly_fields = array(
	);

	/**
	 * related objects to include in a query
	 *
	 * @var    array
	 */
	private $relations = array(
	);

	// -------------------------------------------------------------------------

	/*
	 * initialize the nestedset model instance
	 *
	 * @param    array
	 * @param    bool
	 */
	public function __construct(array $data = array(), $new = true)
	{
		// call the ORM model constructor
		parent::__construct($data, $new);

		// process the model's tree properties, set some defaults if needed
		if (isset(static::$tree) and is_array(static::$tree))
		{
			foreach(static::$defaults as $key => $value)
			{
				$this->configuration[$key] = isset(static::$tree[$key]) ? static::$tree[$key] : static::$defaults[$key];
			}
		}
		else
		{
			$this->configuration = array_merge(static::$defaults, $this->configuration);
		}

		// array of read-only column names
		foreach(array('left_field','right_field','tree_field','symlink_field') as $field)
		{
			! empty($this->configuration[$field]) and $this->readonly_fields[] = $this->configuration[$field];
		}

		if (count(static::$_primary_key) > 1)
		{
			throw new \Exception('The NestedSets model doesn\'t support ORM Models with multiple primary key columns.');
		}
	}

	/* -------------------------------------------------------------------------
	 * tree properties
	 * ---------------------------------------------------------------------- */

	/**
	 * Set a tree property
	 *
	 * @param  string
	 * @param  mixed
	 */
	public function tree_set_property($name, $value)
	{
		array_key_exists($name, $this->configuration) and $this->configuration[$name] = $value;
	}

	/**
	 * Get a tree property
	 *
	 * @param  string
	 * @param  mixed
	 */
	public  function tree_get_property($name)
	{
		return array_key_exists($name, $this->configuration) ? $this->configuration[$name] :  null;
	}

	/* -------------------------------------------------------------------------
	 * multi-tree select
	 * ---------------------------------------------------------------------- */

	/**
	 * Select a specific tree if the table contains multiple trees
	 *
	 * @param   mixed	type depends on the field type of the tree_field
	 * @return  object	this object, for chaining
	 */
	public function tree_select($tree = null)
	{
		// set the filter value
		$this->tree_set_property('tree_value', $tree);

		// return the object for chaining
		return $this;
	}

	/* -------------------------------------------------------------------------
	 * tree constructors
	 * ---------------------------------------------------------------------- */

	/**
	 * Creates a new root node
	 *
	 * @return	object	Nestedsets\Model
	 */
	public function tree_new_root()
	{
		if ( ! $this->is_new())
		{
			throw new \Exception('You can only use new_root() on a new model object.');
		}

		// set the left- and right pointers for the new root
		$this->{$this->configuration['left_field']} = 1;
		$this->{$this->configuration['right_field']} = 2;

		// multi-root tree?
		if ( ! is_null($this->configuration['tree_field']))
		{
			// insert the new object with a unique tree id
			$new_tree = $this->max($this->configuration['tree_field']) + 1;
			$max_errors = 5;
			while (true)
			{
				$this->{$this->configuration['tree_field']} = $new_tree++;

				// clumsy hack to hopefully capture a duplicate key error
				try
				{
					$this->save();
					break;
				}
				catch (\Exception $e)
				{
					// if we have more errors, it's likely not to be a duplicate key...
					if (--$max_errors == 0)
					{
						throw $e;
					}
				}
			}
		}
		else
		{
			$this->save();
		}

		// return the ORM Model object
		return $this;
	}

	// -----------------------------------------------------------------

	/**
	 * create a new tree node as first child of object
	 *
	 * @param	object	Nestedsets\Model
	 * @return	mixed
	 */
	public function tree_new_first_child_of(\Nestedsets\Model $object)
	{
		$this->tree_same_model_as($object, __METHOD__);

		// set the tree id
		if ( ! is_null($this->configuration['tree_field']))
		{
			$this->{$this->configuration['tree_field']} = $object->tree_get_tree_id();
		}

		// set the left- and right pointers for the new node
		$this->{$this->configuration['left_field']} = $object->{$this->configuration['left_field']} + 1;
		$this->{$this->configuration['right_field']} = $object->{$this->configuration['left_field']} + 2;

		// create room for this new node
		$this->_tree_shift_rlvalues($this->{$this->configuration['left_field']}, 2);

		// insert the new node and return the result
		return $this->save();
	}

	// -----------------------------------------------------------------

	/**
	 * create a new tree node as last child of object
	 *
	 * @param	object	Nestedsets\Model
	 * @return	mixed
	 */
	public function tree_new_last_child_of(\Nestedsets\Model $object)
	{
		$this->tree_same_model_as($object, __METHOD__);

		// set the tree id
		if ( ! is_null($this->configuration['tree_field']))
		{
			$this->{$this->configuration['tree_field']} = $object->tree_get_tree_id();
		}

		// set the left- and right pointers for the new node
		$this->{$this->configuration['left_field']} = $object->{$this->configuration['right_field']};
		$this->{$this->configuration['right_field']} = $object->{$this->configuration['right_field']} + 1;

		// create room for this new node
		$this->_tree_shift_rlvalues($this->{$this->configuration['left_field']}, 2);

		// insert the new node and return the result
		return $this->save();
	}

	// -----------------------------------------------------------------

	/**
	 * create a new tree node as new previous sibling of object
	 *
	 * @param	object	Nestedsets\Model
	 * @return	mixed
	 */
	public function tree_new_previous_sibling_of(\Nestedsets\Model $object)
	{
		$this->tree_same_model_as($object, __METHOD__);

		// set the tree id
		if ( ! is_null($this->configuration['tree_field']))
		{
			$this->{$this->configuration['tree_field']} = $object->tree_get_tree_id();
		}

		// set the left- and right pointers for the new node
		$this->{$this->configuration['left_field']} = $object->{$this->configuration['left_field']};
		$this->{$this->configuration['right_field']} = $object->{$this->configuration['left_field']} + 1;

		// create room for this new node
		$this->_tree_shift_rlvalues($this->{$this->configuration['left_field']}, 2);

		// insert the new node and return the result
		return $this->save();
	}

	// -----------------------------------------------------------------

	/**
	 * create a new tree node as new next sibling of object
	 *
	 * @param	object	Nestedsets\Model
	 * @return	mixed
	 */
	public function tree_new_next_sibling_of(\Nestedsets\Model $object)
	{
		$this->tree_same_model_as($object, __METHOD__);

		// set the tree id
		if ( ! is_null($this->configuration['tree_field']))
		{
			$this->{$this->configuration['tree_field']} = $object->tree_get_tree_id();
		}

		// set the left- and right pointers for the new node
		$this->{$this->configuration['left_field']} = $object->{$this->configuration['right_field']} + 1;
		$this->{$this->configuration['right_field']} = $object->{$this->configuration['right_field']} + 2;

		// create room for this new node
		$this->_tree_shift_rlvalues($this->{$this->configuration['left_field']}, 2);

		// insert the new node and return the result
		return $this->save();
	}

	/* -------------------------------------------------------------------------
	 * tree queries
	 * ---------------------------------------------------------------------- */

	/**
	 * Returns the root of the (selected) tree
	 *
	 * @return	object	Nestedsets\Model
	 */
	public function tree_get_root()
	{
		$query = $this->find()->where($this->configuration['left_field'], 1);

		if ( ! is_null($this->configuration['tree_field']))
		{
			$query->where($this->configuration['tree_field'], $this->tree_get_tree_id());
		}

		// return the ORM Model object
		return $this->_get_one($query);
	}

	/**
	 * Returns a query object on the selected tree
	 *
	 * @return	object	Nestedsets\Model
	 */
	public function tree_get_query()
	{
		$query = $this->find()->where('id', 1);

		if ( ! is_null($this->configuration['tree_field']))
		{
			$query->where($this->configuration['tree_field'], $this->tree_get_tree_id());
		}

		// return the ORM query object
		return $query;
	}

	// -----------------------------------------------------------------

	/**
	 * returns the parent of the 'object' passed
	 *
	 * @param	object	Nestedsets\Model
	 * @return	object	Nestedsets\Model
	 */
	public function tree_get_parent(\Nestedsets\Model $object = null)
	{
		is_null($object) and $object = $this;

		$this->tree_same_model_as($object, __METHOD__);

		$query = $this->find()
			->where($this->configuration['left_field'], '<', $object->{$this->configuration['left_field']})
			->where($this->configuration['right_field'], '>', $object->{$this->configuration['right_field']})
			->order_by($this->configuration['right_field'], 'ASC');

		if ( ! is_null($this->configuration['tree_field']))
		{
			$query->where($this->configuration['tree_field'], $this->tree_get_tree_id());
		}

		// return the Nestedsets Model object
		return $this->_get_one($query);
	}

	// -----------------------------------------------------------------

	/**
	 * returns the first child of the 'object' passed
	 *
	 * @param	object	Nestedsets\Model
	 * @return	object	Nestedsets\Model
	 */
	public function tree_get_first_child(\Nestedsets\Model $object = null)
	{
		is_null($object) and $object = $this;

		$this->tree_same_model_as($object, __METHOD__);

		$query = $this->find()
			->where($this->configuration['left_field'], $object->{$this->configuration['left_field']} + 1);

		if ( ! is_null($this->configuration['tree_field']))
		{
			$query->where($this->configuration['tree_field'], $this->tree_get_tree_id());
		}

		// return the Nestedsets Model object
		return $this->_get_one($query);
	}

	// -----------------------------------------------------------------

	/**
	 * returns the last child of the 'object' passed
	 *
	 * @param   object Nestedsets\Model
	 * @return	object	Nestedsets\Model
	 */
	public function tree_get_last_child(\Nestedsets\Model $object = null)
	{
		is_null($object) and $object = $this;

		$this->tree_same_model_as($object, __METHOD__);

		$query = $this->find()
			->where($this->configuration['right_field'], $object->{$this->configuration['right_field']} - 1);

		if ( ! is_null($this->configuration['tree_field']))
		{
			$query->where($this->configuration['tree_field'], $this->tree_get_tree_id());
		}

		// return the Nestedsets Model object
		return $this->_get_one($query);
	}

	// -----------------------------------------------------------------

	/**
	 * returns the children of the 'object' passed
	 *
	 * @param   object Nestedsets\Model
	 * @return	object	Nestedsets\Model
	 */
	public function tree_get_children(\Nestedsets\Model $object = null)
	{
		is_null($object) and $object = $this;

		if ($child = $object->tree_get_first_child())
		{
			$result = array($child->id => $child);
			while ($child = $child->tree_get_next_sibling())
			{
				$result[$child->id] = $child;
			}

			// return the array of Nestedsets Model objects
			return $result;
		}
		else
		{
			return null;
		}
	}

	// -----------------------------------------------------------------

	/**
	 * returns the previous sibling of the 'object' passed
	 *
	 * @param   object Nestedsets\Model
	 * @return	object	Nestedsets\Model
	 */
	public function tree_get_previous_sibling(\Nestedsets\Model $object = null)
	{
		is_null($object) and $object = $this;

		$this->tree_same_model_as($object, __METHOD__);

		$query = $this->find()
			->where($this->configuration['right_field'], $object->{$this->configuration['left_field']} - 1);

		if ( ! is_null($this->configuration['tree_field']))
		{
			$query->where($this->configuration['tree_field'], $this->tree_get_tree_id());
		}

		// return the Nestedsets Model object
		return $this->_get_one($query);
	}

	// -----------------------------------------------------------------

	/**
	 * returns the next sibling of the 'object' passed
	 *
	 * @param   object Nestedsets\Model
	 * @return	object	Nestedsets\Model
	 */
	public function tree_get_next_sibling(\Nestedsets\Model $object = null)
	{
		is_null($object) and $object = $this;

		$this->tree_same_model_as($object, __METHOD__);

		$query = $this->find()
			->where($this->configuration['left_field'], $object->{$this->configuration['right_field']} + 1);

		if ( ! is_null($this->configuration['tree_field']))
		{
			$query->where($this->configuration['tree_field'], $this->tree_get_tree_id());
		}

		// return the Nestedsets Model object
		return $this->_get_one($query);
	}

	// -----------------------------------------------------------------

	/**
	 * returns the siblings (includes the node itself!) of the 'object' passed
	 *
	 * @param   object Nestedsets\Model
	 * @return	object	Nestedsets\Model
	 */
	public function tree_get_siblings(\Nestedsets\Model $object = null)
	{
		is_null($object) and $object = $this;

		// fetch the objects parent
		$parent = $object->tree_get_parent();

		if ($parent)
		{
			// get the children of the parent
			return $parent->tree_get_children();
		}
		else
		{
			return null;
		}
	}


	// -----------------------------------------------------------------
	// Boolean tree functions
	// -----------------------------------------------------------------

	/**
	 * Check if the object is a valid tree node
	 *
	 * @return  bool
	 */
	public function tree_is_valid()
	{
		if ( $this->is_new() )
		{
			return false;
		}
		elseif ( ! isset($this->{$this->configuration['left_field']}) or ! is_numeric($this->{$this->configuration['left_field']}) or $this->{$this->configuration['left_field']} <= 0 )
		{
			return false;
		}
		elseif ( ! isset($this->{$this->configuration['right_field']}) or ! is_numeric($this->{$this->configuration['right_field']}) or $this->{$this->configuration['right_field']} <= 0 )
		{
			return false;
		}
		elseif ( $this->{$this->configuration['left_field']} >= $this->{$this->configuration['right_field']} )
		{
			return false;
		}
		elseif ( ! is_null($this->configuration['tree_field']) and ! isset($this->{$this->configuration['tree_field']}) )
		{
			return false;
		}
		elseif ( ! is_null($this->configuration['tree_field']) and ( ! is_numeric($this->{$this->configuration['tree_field']}) or $this->{$this->configuration['tree_field']} <=0  ) )
		{
			return false;
		}

		// all looks well...
		return true;
	}

	// -----------------------------------------------------------------

	/**
	 * Check if the object is a tree root
	 *
	 * @return  bool
	 */
	public function tree_is_root()
	{
		return $this->tree_is_valid($this) and $this->{$this->configuration['left_field']} == 1;
	}

	// -----------------------------------------------------------------

	/**
	 * check if the object is a tree leaf (node with no children)
	 *
	 * @return  bool
	 */
	public function tree_is_leaf()
	{
		return $this->tree_is_valid($this) and $this->{$this->configuration['right_field']} - $this->{$this->configuration['left_field']} == 1;
	}

	// -----------------------------------------------------------------

	/**
	 * check if the object is a child node (not a root node)
	 *
	 * @return  bool
	 */
	public function tree_is_child()
	{
		return $this->tree_is_valid($this) and ! $this->tree_is_root($this);
	}

	// -----------------------------------------------------------------

	/**
	 * check if the object is a child of node
	 *
	 * @param   object Nestedsets\Model of the parent to check
	 * @return  bool
	 */
	public function tree_is_child_of(\Nestedsets\Model $parent)
	{
		return $this->tree_is_valid($this) and
			$this->tree_is_valid($parent) and
			$this->{$this->configuration['left_field']} > $parent->{$this->configuration['left_field']} and
			$this->{$this->configuration['right_field']} < $parent->{$this->configuration['right_field']};
	}

	// -----------------------------------------------------------------

	/**
	 * check if the object is a parent of node
	 *
	 * @param   object Nestedsets\Model of the child to check
	 * @return  bool
	 */
	public function tree_is_parent_of(\Nestedsets\Model $child)
	{
		return $this->tree_is_valid($child) and
			$this->tree_is_valid($this) and
			$child->{$this->configuration['left_field']} > $this->{$this->configuration['left_field']} and
			$child->{$this->configuration['right_field']} < $this->{$this->configuration['right_field']};
	}

	// -----------------------------------------------------------------

	/**
	 * check if the object has a parent
	 *
	 * Note: this is an alias for is_child()
	 *
	 * @return  bool
	 */
	public function tree_has_parent()
	{
		return $this->tree_is_child($this);
	}

	// -----------------------------------------------------------------

	/**
	 * check if the object has children
	 *
	 * @return  bool
	 */
	public function tree_has_children()
	{
		return $this->tree_is_leaf($this) ? false : true;
	}

	// -----------------------------------------------------------------

	/**
	 * Check if the object has a previous sibling
	 *
	 * @return  bool
	 */
	public function tree_has_previous_sibling()
	{
		return ! is_null($this->tree_get_previous_sibling($this));
	}

	// -----------------------------------------------------------------

	/**
	 * Check if the object has a next sibling
	 *
	 * @return  bool
	 */
	public function tree_has_next_sibling()
	{
		return ! is_null($this->tree_get_next_sibling($this));
	}

	// -----------------------------------------------------------------
	// Integer tree functions
	// -----------------------------------------------------------------

	/**
	 * return the count of the objects children
	 *
	 * @return	mixed	integer, of false in case no valid object was passed
	 */
	public function tree_count_children()
	{
		return $this->tree_is_valid($this) ? (($this->{$this->configuration['right_field']} - $this->{$this->configuration['left_field']} - 1) / 2) : false;
	}

	// -----------------------------------------------------------------

	/**
	 * return the depth of the object in the tree, where the root = 0
	 *
	 * @param   object Nestedsets\Model
	 * @return	mixed	integer, of false in case no valid object was found
	 */
	public function tree_depth(\Nestedsets\Model $object = null)
	{
		is_null($object) and $object = $this;

		if ($this->tree_is_valid($object))
		{
			$query = $this->find();

			if ( ! is_null($this->configuration['tree_field']))
			{
				$query->where($this->configuration['tree_field'], $this->tree_get_tree_id());
			}

			$query->where($this->configuration['left_field'], '<', $object->{$this->configuration['left_field']});
			$query->where($this->configuration['right_field'], '>', $object->{$this->configuration['right_field']});

			// return the Nestedsets Model result count
			return $query->count();
		}
		else
		{
			return false;
		}
	}

	/* -------------------------------------------------------------------------
	 * tree reorganisation functions
	 * ---------------------------------------------------------------------- */

	/**
	 * move $object to next silbling of $to
	 *
	 * @param   object Nestedsets\Model
	 * @return  bool
	 */
	public function tree_make_next_sibling_of(\Nestedsets\Model $to)
	{
		$this->tree_same_model_as($to, __METHOD__);

		if ($this->tree_is_valid($this) and $this->tree_is_valid($to))
		{
			if ( ! is_null($this->configuration['tree_field']))
			{
				if ($this->{$this->configuration['tree_field']} !== $to->{$this->configuration['tree_field']})
				{
					throw new \Exception('When moving nodes, nodes must be part of the same tree.');
				}
			}

			return $this->_tree_move_subtree($to->{$this->configuration['right_field']} + 1);
		}
		else
		{
			return false;
		}
	}

	// -----------------------------------------------------------------

	/**
	 * move $object to previous silbling of $to
	 *
	 * @param   object Nestedsets\Model
	 * @return  bool
	 */
	public function tree_make_previous_sibling_of(\Nestedsets\Model $to)
	{
		$this->tree_same_model_as($to, __METHOD__);

		if ($this->tree_is_valid($this) and $this->tree_is_valid($to))
		{
			if ( ! is_null($this->configuration['tree_field']))
			{
				if ($this->{$this->configuration['tree_field']} !== $to->{$this->configuration['tree_field']})
				{
					throw new \Exception('When moving nodes, nodes must be part of the same tree.');
				}
			}

			return $this->_tree_move_subtree($to->{$this->configuration['left_field']});
		}
		else
		{
			return false;
		}
	}

	// -----------------------------------------------------------------

	/**
	 * move $object to first child of $to
	 *
	 * @param   object Nestedsets\Model
	 * @return  bool
	 */
	public function tree_make_first_child_of(\Nestedsets\Model $to)
	{
		$this->tree_same_model_as($to, __METHOD__);

		if ($this->tree_is_valid($this) and $this->tree_is_valid($to))
		{
			if ( ! is_null($this->configuration['tree_field']))
			{
				if ($this->{$this->configuration['tree_field']} !== $to->{$this->configuration['tree_field']})
				{
					throw new \Exception('When moving nodes, nodes must be part of the same tree.');
				}
			}

			return $this->_tree_move_subtree($to->{$this->configuration['left_field']} + 1);
		}
		else
		{
			return false;
		}
	}

	// -----------------------------------------------------------------

	/**
	 * move $object to last child of $to
	 *
	 * @param   object Nestedsets\Model
	 * @return  bool
	 */
	public function tree_make_last_child_of(\Nestedsets\Model $to)
	{
		$this->tree_same_model_as($to, __METHOD__);

		if ($this->tree_is_valid($this) and $this->tree_is_valid($to))
		{
			if ( ! is_null($this->configuration['tree_field']))
			{
				if ($this->{$this->configuration['tree_field']} !== $to->{$this->configuration['tree_field']})
				{
					throw new \Exception('When moving nodes, nodes must be part of the same tree.');
				}
			}

			return $this->_tree_move_subtree($to->{$this->configuration['right_field']});
		}
		else
		{
			return false;
		}
	}

	/* -------------------------------------------------------------------------
	 * tree destructors
	 * ---------------------------------------------------------------------- */

	/**
	 * deletes the entire tree structure including all records
	 *
	 * @param	boolean	if true, delete all trees
	 * @return	bool
	 */
	public function tree_delete_tree($all = false)
	{
		// delete the tree
		$query = \DB::delete(call_user_func(__CLASS__.'::table'));

		// if we have multiple roots
		if ( ! is_null($this->configuration['tree_field']))
		{
			// by default, only delete the current tree
			$all === true or $query->where($this->configuration['tree_field'], $this->{$this->configuration['tree_field']});
		}

		$query->execute(call_user_func(__CLASS__.'::connection'));

		// reset the current object, it's no longer valid
		$this->tree_clear();

		return true;
	}

	// -----------------------------------------------------------------

	/**
	 * deletes the current tree node ( and any child nodes as well ! )
	 *
	 * @return	bool
	 */
	public function tree_delete()
	{
		if ($this->tree_is_valid($this))
		{
			// delete the node(s)
			$query = \DB::delete(call_user_func(__CLASS__.'::table'));

			// if we have multiple roots
			if ( ! is_null($this->configuration['tree_field']))
			{
				$query->where($this->configuration['tree_field'], $this->{$this->configuration['tree_field']});
			}
			$query->where($this->configuration['left_field'], '>=', $this->{$this->configuration['left_field']});
			$query->where($this->configuration['left_field'], '<=', $this->{$this->configuration['right_field']});
			$query->execute(call_user_func(__CLASS__.'::connection'));

			// re-index the tree
			$this->_tree_shift_rlvalues($this->{$this->configuration['right_field']} + 1, $this->{$this->configuration['left_field']} - $this->{$this->configuration['right_field']} - 1);
		}
		else
		{
			return false;
		}

		// reset the current object, it's no longer valid
		$this->tree_clear();

		return true;
	}

	/* -------------------------------------------------------------------------
	 * tree dump functions
	 * ---------------------------------------------------------------------- */

	/**
	 * returns the tree in a key-value format suitable for html dropdowns
	 *
	 */
	public function tree_dump_dropdown($field = null, $skip_root = false, $add_empty = false)
	{
		// set the name field
		empty($field) and $field = $this->configuration['title_field'];

		// we need a name field to generate the tree
		if ( ! is_null($field))
		{
			// fetch the tree into an array
			$result = $this->_tree_dump_as('array', array('id', $field), $skip_root);

			// storage for the dropdown tree
			$tree = $add_empty ? (is_array($add_empty) ? $add_empty : array('0' => $add_empty)) : array();

			// loop trough the tree
			if ($result)
			{
				foreach ($result as $key => $value)
				{
					$tree[$value['_key_']] = str_repeat('&nbsp;', ($value['_level_']) * 3) . ($value['_level_'] ? '&raquo; ' : '') . $value[$field];
				}
			}

			// return the result
			return $tree;
		}
		else
		{
			return false;
		}
	}

	// -----------------------------------------------------------------

	/**
	 * returns the tree with only parents in a key-value format suitable for html dropdowns
	 *
	 */
	public function tree_dump_parent_dropdown($field = null, $skip_root = false)
	{
		// set the name field
		empty($field) and $field = $this->configuration['title_field'];

		// we need a name field to generate the tree
		if ( ! is_null($field))
		{
			// fetch the tree into an array
			$result = $this->_tree_dump_as('array', array('id', $field), $skip_root);

			// storage for the dropdown tree
			$tree = array();

			if ($result)
			{
				// loop trough the tree
				foreach ($result as $key => $value)
				{
					if ($value[$this->tree_get_property('right_field')] - $value[$this->tree_get_property('left_field')] > 1)
					{
						$tree[$value['_key_']] = str_repeat('&nbsp;', ($value['_level_']) * 3) . ($value['_level_'] ? '&raquo; ' : '') . $value[$field];
					}
				}
			}

			// return the result
			return $tree;
		}
		else
		{
			return false;
		}
	}

	// -----------------------------------------------------------------

	public function tree_dump_as_array(Array $attributes = array(), $skip_root = true, $hierarchical = false)
	{
		$result = $this->_tree_dump_as('array', $attributes, $skip_root);

		if ($hierarchical)
		{
			$tree = array();

			// array to track nodes with children
			$tracker = array();

			foreach($result as $node)
			{
				// add an array for possible childeren of this node
				$node['children'] = array();

				// do we already track the parent?
				if (array_key_exists($node['_parent_'], $tracker))
				{
					// add the node as a child of the parent
					$tracker[$node['_parent_']]['children'][$node['id']] = $node;

					// and to the tracker
					$tracker[$node['id']] =& $tracker[$node['_parent_']]['children'][$node['id']];
				}
				else
				{
					// no, add it to the tree
					$tree[$node['id']] = $node;

					// and to the tracker
					$tracker[$node['id']] =& $tree[$node['id']];
				}
			}

			return $tree;
		}
		else
		{
			return $result;
		}
	}

	// -----------------------------------------------------------------

	public function tree_dump_as_html(Array $attributes = array(), $skip_root = true)
	{
		return $this->_tree_dump_as('html', $attributes, $skip_root);
	}

	// -----------------------------------------------------------------

	public function tree_dump_as_csv(Array $attributes = array(), $skip_root = true)
	{
		return $this->_tree_dump_as('csv', $attributes, $skip_root);
	}

	// -----------------------------------------------------------------

	public function tree_dump_as_tab(Array $attributes = array(), $skip_root = true)
	{
		return $this->_tree_dump_as('tab', $attributes, $skip_root);
	}

	// -----------------------------------------------------------------

	/**
	 * Select a specific tree if the table contains multiple trees
	 *
	 * @param   mixed	type depends on the field type of the tree_field
	 * @return  object	this object, for chaining
	 */
	public function tree_get_tree_id()
	{
		// check if the current object is part of a tree
		if ( ! empty($this->{$this->configuration['tree_field']}))
		{
			return $this->{$this->configuration['tree_field']};
		}
		else
		{
			return $this->configuration['tree_value'];
		}
	}

	// -----------------------------------------------------------------

	/**
	 * check if the object passed is an instance of the current model
	 *
	 * @param   object	Nestedsets\Model
	 * @param	string	optional method name to display in the exception
	 * @return  bool
	 * @throws	Exception in case the two objects are not part of the same model
	 */
	public function tree_same_model_as($object, $method = 'unknown')
	{
		if (get_class($object) !== get_class($this))
		{
			throw new \Exception('Model object passed to '.$method.'() is not an instance of '.get_class($this).'.');
		}

		return true;
	}

	// -----------------------------------------------------------------

	/**
	 * check if the object passed is an instance of the current model
	 *
	 * @param   object	Nestedsets\Model
	 * @param	string	optional method name to display in the exception
	 * @return  bool
	 * @throws	Exception in case the two objects are not part of the same model
	 */
	public function tree_same_tree_as($object, $method = 'unknown')
	{
		// make sure they're the same model
		$this->tree_same_model_as($object, $method);

		if ( ! empty($this->{$this->configuration['tree_field']}))
		{
			if ($this->{$this->configuration['tree_field']} !== $object->{$this->configuration['tree_field']})
			{
				return false;
			}
		}

		return true;
	}

	// -----------------------------------------------------------------

	public function related($relation)
	{
		in_array($relation, $this->relations) or $this->relations[] = $relation;

		return $this;
	}

	/* -------------------------------------------------------------------------
	 * protected class functions
	 * ---------------------------------------------------------------------- */

	/**
	 * runs a get() query
	 */
	protected function _get($query)
	{
		// inject defined relations in the query
		foreach ($this->relations as $relation)
		{
			$query->related($relation);
		}
		$this->relations = array();

		// return the query result
		return $query->get();
	}

	// -----------------------------------------------------------------

	/**
	 * runs a get_one() query
	 */
	protected function _get_one($query)
	{
		// inject defined relations in the query
		foreach ($this->relations as $relation)
		{
			$query->related($relation);
		}
		$this->relations = array();

		// return the query result
		return $query->get_one();
	}

	// -----------------------------------------------------------------

	/**
	 * dumps the tree with the object as root in different formats
	 *
	 * @param	string	type of output requested
	 * @param	array	list of columns to include in the dump
	 * @param	boolean	if true, the object itself (root of the dump) will not be included
	 * @return	mixed
	 */
	protected function _tree_dump_as($type, $attributes, $skip_root)
	{
		if ($this->tree_is_valid($this))
		{
			$query = $this->find();

			// if we have multiple roots
			if ( ! is_null($this->configuration['tree_field']))
			{
				$query->where($this->configuration['tree_field'], $this->tree_get_tree_id());
			}

			// create the where clause for this query
			if ($skip_root === true)
			{
				// select only all children
				$query->where($this->configuration['left_field'], '>', $this->{$this->configuration['left_field']});
				$query->where($this->configuration['right_field'], '<', $this->{$this->configuration['right_field']});
				$level = -1;
			}
			else
			{
				// select the node and all children
				$query->where($this->configuration['left_field'], '>=', $this->{$this->configuration['left_field']});
				$query->where($this->configuration['right_field'], '<=', $this->{$this->configuration['right_field']});
				$level = -2;
			}

			$query->order_by($this->configuration['left_field'], 'ASC');

			// fetch the result
			$result = $this->_get($query);

			// create the start of the path
			$path = ( ! is_null($this->configuration['title_field'])) ? array($this->{$this->configuration['title_field']}) : array();

			// store the last left pointer
			$last_left = $this->{$this->configuration['left_field']};

			// parent key's
			$parents = array(-1 => null, 0 => $this->{static::$_primary_key[0]});

			// storage for the tree
			$tree = array();

			$previous_level = -1;
			$first_pointers = $last_pointers = array();

			// add level and path to the result
			foreach ( $result as $record )
			{
				// fetch the column data
				if ( empty($attributes))
				{
					$node = $record->to_array();
				}
				else
				{
					$node = array();
					foreach($record->to_array() as $name => $value)
					{
						if (in_array($name, $attributes) or in_array($name, $this->configuration) or $name == $this->{static::$_primary_key[0]})
						{
							$node[$name] = $value;
						}
					}
				}

				// store the primary key
				$node['_key_'] = $node[static::$_primary_key[0]];

				// calculate the nest level of this node
				$level += $last_left - $node[$this->configuration['left_field']] + 2;
				$last_left = $node[$this->configuration['left_field']];
				$node['_level_'] = $level;
				$node['_parent_'] = $parents[$level - 1];

				// update the parent keys
				$parents[$level] = $node[static::$_primary_key[0]];

				// track first and last level pointers
				$node['_first_'] = false;
				if ( ! isset($first_pointers[$node['_parent_']])) $first_pointers[$node['_parent_']] = $node['_key_'];
				$node['_last_'] = false;
				$last_pointers[$node['_parent_']] = $node['_key_'];

				// create the relative path to this node
				$node['_path_'] = '';
				if ( ! empty($this->configuration['title_field']) )
				{
					$path[$level] = $node[$this->configuration['title_field']];
					for ( $i = 0; $i <= $level; $i++ )
					{
						$node['_path_'] .= '/' . $path[$i];
					}
				}

				// store the node
				$tree[$node['_key_']] = $node;
			}
		}
		else
		{
			return false;
		}

		foreach($first_pointers as $pointer)
		{
			$tree[$pointer]['_first_'] = true;
		}
		foreach($last_pointers as $pointer)
		{
			$tree[$pointer]['_last_'] = true;
		}

		// convert the result to output if needed
		if ( in_array($type, array('tab', 'csv', 'html')) )
		{
			// storage for the result
			$convert = '';

			// loop through the nodes
			foreach ( $tree as $key => $value )
			{
				// prefix based on requested type
				switch ($type)
				{
					case 'tab';
						$convert .= str_repeat("\t", $value['_level_'] * 4 );
						break;
					case 'csv';
						break;
					case 'html';
						$convert .= str_repeat("&nbsp;", $value['_level_'] * 4 );
						break;
				}

				// print the attributes requested
				if ( ! empty($attributes) )
				{
					$att = reset($attributes);
					while($att){
						if ( is_numeric($value[$att]) )
						{
							$convert .= $value[$att];
						}
						else
						{
							$convert .= '"'.$value[$att].'"';
						}
						$att = next($attributes);
						if ($att)
						{
							$convert .= ($type == 'csv' ? "," : " ");
						}
					}
				}

				// postfix based on requested type
				switch ($type)
				{
					case 'tab';
						$convert .= "\n";
						break;
					case 'csv';
						$convert .= "\n";
						break;
					case 'html';
						$convert .= "<br />";
						break;
				}
			}
			return $convert;
		}
		else
		{
			return $tree;
		}



	}

	// -----------------------------------------------------------------

	protected function _tree_shift_rlvalues($first, $delta)
	{
		$query = \DB::update(static::table());

		// if we have multiple roots
		if ( ! is_null($this->configuration['tree_field']))
		{
			$query->where($this->configuration['tree_field'], $this->tree_get_tree_id());
		}

		$query->where($this->configuration['left_field'], '>=', $first);

		// correct the delta
		$sqldelta = ($delta < 0) ? (' - '.abs($delta)) : (' + '.$delta);

		// set clause
		$query->set(array(
			$this->configuration['left_field'] => \DB::expr($this->configuration['left_field'].$sqldelta),
		));

		// update in the correct order to avoid constraint conflicts
		$query->order_by($this->configuration['left_field'], ($delta < 0 ? 'ASC' : 'DESC'));

		// execute it
		$this->_debug_queries and logger('Debug', $query->compile());
		$query->execute();

		$query = \DB::update(static::table());

		// if we have multiple roots
		if ( ! is_null($this->configuration['tree_field']))
		{
			$query->where($this->configuration['tree_field'], $this->tree_get_tree_id());
		}

		$query->where($this->configuration['right_field'], '>=', $first);

		// set clause
		$query->set(array(
			$this->configuration['right_field'] => \DB::expr($this->configuration['right_field'].$sqldelta),
		));

		// update in the correct order to avoid constraint conflicts
		$query->order_by($this->configuration['right_field'], ($delta < 0 ? 'ASC' : 'DESC'));

		// execute it
		$this->_debug_queries and logger('Debug', $query->compile());
		$query->execute();

		// flush cached objects
		$class = get_called_class();
		static::$_cached_objects[$class] = array();
	}

	// -----------------------------------------------------------------

	protected function _tree_shift_rlrange($first, $last, $delta)
	{
		$query = \DB::update(static::table());

		// if we have multiple roots
		if ( ! is_null($this->configuration['tree_field']))
		{
			$query->where($this->configuration['tree_field'], $this->tree_get_tree_id());
		}

		// select the range
		$query->where($this->configuration['left_field'], '>=', $first);
		$query->where($this->configuration['right_field'], '<=', $last);

		// set clause
		$delta = ($delta < 0) ? ('- '.abs($delta)) : ('+ '.$delta);
		$query->set(array(
			$this->configuration['left_field'] => \DB::expr($this->configuration['left_field'].$delta),
			$this->configuration['right_field'] => \DB::expr($this->configuration['right_field'].$delta),
		));

		// update back to front
		$query->order_by($this->configuration['left_field'], 'DESC');

		// execute it
		$this->_debug_queries and logger('Debug', $query->compile());
		$query->execute();

		// flush cached objects
		$class = get_called_class();
		static::$_cached_objects[$class] = array();
	}

	// -----------------------------------------------------------------

	protected function _tree_move_subtree($destination_id)
	{
		// catch a recursive move
		if ( $destination_id >= $this->{$this->configuration['left_field']} and $destination_id <= $this->{$this->configuration['right_field']} )
		{
			// recursive moves would make no change to the tree
			return $this;
		}

		// determine the size of the tree to move
		$treesize = $this->{$this->configuration['right_field']} - $this->{$this->configuration['left_field']} + 1;

		// get the objects left- and right pointers
		$left_id = $this->{$this->configuration['left_field']};
		$right_id = $this->{$this->configuration['right_field']};

		// shift to make some space
		$this->_tree_shift_rlvalues($destination_id, $treesize);

		// correct pointers if there were shifted to
		if ($this->{$this->configuration['left_field']} >= $destination_id)
		{
			$left_id += $treesize;
			$right_id += $treesize;
		}

		// enough room now, start the move
		$this->_tree_shift_rlrange($left_id, $right_id, $destination_id - $left_id);

		// and correct index values after the source
		$this->_tree_shift_rlvalues(++$right_id, (-1 * $treesize));

		// return the moved object
		return $this;
	}

	// -----------------------------------------------------------------

	protected function tree_clear()
	{
		// Perform cleanup:
		// remove from internal object cache, remove PK's, set to non saved object, remove db original values
		if (array_key_exists(get_called_class(), static::$_cached_objects)
			and array_key_exists(static::implode_pk($this), static::$_cached_objects[get_called_class()]))
		{
			unset(static::$_cached_objects[get_called_class()][static::implode_pk($this)]);
		}
		foreach ($this->primary_key() as $pk)
		{
			unset($this->_data[$pk]);
		}
		$this->_is_new = true;
		$this->_original = array();
	}

}

/* End of file model.php */
