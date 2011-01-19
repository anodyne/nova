<?php defined('SYSPATH') or die('No direct script access.');
/**
 *	Document   : meta.php
 *	Created on : 1 mai 2009, 13:03:03
 *	@author Cedric de Saint Leger <c.desaintleger@gmail.com>
 *
 *	Description:
 *      XML_Meta_Core class. This class contains XML drivers metadata
 */

 class XML_Meta_Core
 {
	/**
	 * @var array assoc array alias => $node_name
	 * This is used to abstract the node names
	 */
	protected $nodes = array();
	
	/**
	 * @var array whole node configuration array
	 * array("node_name" => array(
	 * 								// Effective node name in the XML document. 
	 * 								// This name is abstracted and "node_name" is always used when dealing with the object.
	 * 								"node" => "effective_node_name",
	 * 								// Defines a namespace URI for this node
	 * 								"namespace" => "http://www.namespace.uri", 
	 * 								// Defines a prefix for the namespace above. If not defined, namespace is interpreted as a default namespace
	 * 								"prefix" => "ns",
	 * 								// Defines a callback function to filter/normalize the value
	 * 								"filter" => "filter_function_name",
	 * 								// Array of attributes
	 * 								"attributes" => array("default_attribute1" => "value")
	 * 							),
	 * 		"alias"		=> "node_name",
	 * 		)
	 */
	protected $nodes_config = array();
	
	/**
	 * @var string content type for HTML headers
	 */
	protected $content_type;
	
	/**
	 * @var boolean whether the object is initialized
	 */
	protected $_initialized = FALSE;



	/**
	 * Returns the name of a node, sort out aliases
	 * @param string $name
	 * @return string $node_name
	 */
	public function alias($name)
	{
		if (isset($this->nodes_config[$name]))
		{
			if ( ! is_array($this->nodes_config[$name]))
			{
				$name = $this->nodes_config[$name];
			}
		}
		
		return Arr::get($this->nodes, $name, $name);
	}

	
	/**
	 * Return namespace config for a given node
	 * @param string $name
	 * @return mixed array(uri, prefix) or NULL
	 */
	public function ns($name)
	{
		$name = $this->alias($name);

		if (isset($this->nodes_config[$name]) AND is_array($this->nodes_config[$name]) AND array_key_exists("namespace", $this->nodes_config[$name]))
		{
			return array($this->nodes_config[$name]["namespace"], Arr::get($this->nodes_config[$name], "prefix", NULL));
		}
		return NULL;
	}
	
	
	/**
	 * Return default attributes for a given node
	 * @param string $name
	 * @return mixed attributes assoc array() or NULL
	 */
	public function attributes($name)
	{
		$name = $this->alias($name);
		
		if (isset($this->nodes_config[$name]) AND is_array($this->nodes_config[$name]) AND array_key_exists("attributes", $this->nodes_config[$name]))
		{
			return $this->nodes_config[$name]["attributes"];
		}
		return NULL;
	}


	/**
	 * Return user-defined value filter function for a given node
	 * @param string $name
	 * @return mixed function name or NULL
	 */
	public function filter($name)
	{
		$name = $this->alias($name);
		
		if (isset($this->nodes_config[$name]) AND is_array($this->nodes_config[$name]) AND array_key_exists("filter", $this->nodes_config[$name]))
		{
			return $this->nodes_config[$name]["filter"];
		}
		return NULL;
	}


	/**
	 * Set nodes config attribute
	 * Use it this way :
	 * nodes(array("node_name" => array("namespace" => "http://www.namespace.uri", "prefix" => "ns", "filter" => "filter_function_name", "attributes" => array("default_attribute1" => "value")))),
	 * OR to set up node alias names :
	 * nodes(array("alias" => "node_name"));
	 * 
	 * @param array $nodes array formatted as mentionned above
	 * @param bool $overwrite [optional] Overwrite current values if they are set ?
	 * @return object $this
	 */
	public function nodes(Array $nodes)
	{
		$this->nodes_config = $this->_initialized ?
									array_merge($nodes, $this->nodes_config) : 
									array_merge($this->nodes_config, $nodes);
									
		$this->generate_nodes_map();
		
		return $this;
	}


	/**
	 * Sets the content type for headers
	 * @param string $type 
	 * @return object $this
	 */
	public function content_type($type = NULL)
	{
		if ($type)
		{
			$this->content_type = $this->_initialized ?
									$type :
									$this->content_type ? 
											$this->content_type : 
											$type;
		}
		else
		{
			return $this->content_type;
		}

		return $this;
	}
	
	
	/**
	 * Returns the key name corresponding to a node name
	 * This is used when using as_array(), to return array keys corresponding to the node names
	 * @param object $node_name
	 * @return 
	 */
	public function key($node_name)
	{
		// Extract the name if it is prefixed
		$expl = explode(":", $node_name);
		$node_name = count($expl) > 1 ? end($expl) : current($expl);
		
		if (in_array($node_name, $this->nodes))
		{
			return current(array_keys($this->nodes, $node_name));
		}
		return $node_name;
	}

	
	/**
	 * Generates - or re-generates the node map
	 * @return object $this
	 */
	public function generate_nodes_map()
	{
		$map = array();
		foreach ($this->nodes_config as $key => $config)
		{
			if (is_array($config))
			{
				if (isset ($config["node"]))
				{
					$map[$key] = $config["node"];
				}
			}
		}
		$this->nodes = $map;
		return $this;
	}
	
	/**
	 * Reports the Meta as initialized.
	 * This basically allows Meta methods to overwrite existing value, if they are called explicitely
	 * @return object $this
	 */
	public function set_initialized()
	{
		$this->_initialized = TRUE;
		return $this;
	}
	
}