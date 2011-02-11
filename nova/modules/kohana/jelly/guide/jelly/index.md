# Getting Started

This is the documentation for Jelly, an ORM for Kohana 3.1.

[!!] __Please Note:__ this version of Jelly is a community fork, and it's goal is to ensure the compatibility with the newest Kohana version and fix bugs. It was created, because the [official module](http://github.com/jonathangeiger/kohana-jelly) was not updated recently.

First off, if you're already feeling lost feel free to ask a question in [the official forums](http://dev.kohanaframework.org/projects/jelly/boards)—we're all very nice and helpful. If you feel better looking at the source, you can always [view the API documentation](../api/Jelly) or [browse the source on Github](https://github.com/creatoro/kohana-jelly-for-Kohana-3.1).

## Installation

To install Jelly simply [download the latest release](https://github.com/creatoro/kohana-jelly-for-Kohana-3.1) and place it in your modules directory. After that you must edit your `application/bootstrap.php` file and modify the call to `Kohana::modules` to include the Jelly module:

	Kohana::modules(array(
	    ...
	    'database' => MODPATH.'database',
		'jelly'    => MODPATH.'jelly',
	    ...
	));
	
Notice that Jelly depends on Kohana 3.1x's [database module](http://github.com/kohana/database). Make sure you install and configure that as well.

If you are planning to use the included __Auth driver__ you have to set the cookie salt by following [these instructions](../kohana/upgrading#cookie-salts).

## Basic Usage

The basic operations needed to work with Jelly are:

1.  [Defining models](defining-models)
2.  [Loading and listing records](loading-and-listing)
3.  [Creating, updating and deleting records](cud)
4.  [Accessing and managing relationships](relationships)

## More Advanced Use

Jelly is incredibly flexible with almost all aspects of its behavior
being transparently extendable. The guides below give an overview of some more
advanced usage.

1.  [Extending the query builder](extending-builder)
2.  [Defining custom fields](extending-field)