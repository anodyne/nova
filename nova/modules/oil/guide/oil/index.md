# Oil Utility

The Oil utility is a special package command that can be used in several ways to facilitate quick development, help with testing your application and for running Tasks.

Oil is an optional command line utility designed to help speed up development by providing several functions:

* Generate - Build MVC components, migrations and entire scaffolding.
* Refine - Run tasks such as migrate and your own custom ones.
* Package - Install, update and remove packages.
* Console - Test your code in real time using an interactive shell.

Each of these commands works in a different way to achieve different things, but before getting into them it's best to make sure you are in the correct folder and oil is available and running.

```
$ cd Sites/nova
$ php oil -v
Kohana: 3.1.2 (Hirondelle)
```

## Inline help

Oil contains its own basic documentation which can be found by typing the command:

```
$ php oil help

Usage:
  php oil [console|generate|help|test|package]

Runtime options:
  -f, [--force]    # Overwrite files that already exist
  -s, [--skip]     # Skip files that already exist
  -q, [--quiet]    # Suppress status output

Description:
  The 'oil' command can be used in several ways to facilitate quick development, help with
  testing your application and for running Tasks.

Documentation:
  http://fuelphp.com/docs/packages/oil/intro.html
```

Each of these commands has its own help section which can be found by typing:

```
$ php oil generate help
```