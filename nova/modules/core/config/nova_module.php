<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Modules self reference
| -------------------------------------------------------------------------
|
| To be able to call a module class (library, model, controller) from
| inside an other module class, you need to know with which class name
| the module was instantiated.
|
| When 'self' is FALSE, the module class name itself is used. This means
| module objects are referenced the same, from outside and inside the
| module. Downside is that you have to hardcode the module name.
|
| If you set 'self' to a string value, this value is used as classname
| inside module objects. This means module classes from the same module
| can be called with a generic name, no matter how the module was loaded
|
| $config['self'] = 'thismodule';
|
| module objects inside the module can be called like
| $this->thismodule->model->modelname->method();
|
*/

$config['self'] = 'self';

/*
| -------------------------------------------------------------------------
| Store module language strings in a multi-dimensional array structure
| -------------------------------------------------------------------------
| The default CodeIgniter behaviour is to store all loaded language strings
| in a single dimension array. This means if two language files define the
| same key, the last one loaded will overwrite the first one.
|
| When you enable this option, language strings will be stored in a multi
| dimensional array structure, using the name of the module from which the
| language file is loaded as key. This way a language file from one module
| can not overwrite a string from another module.
|
| To utilize this feature in your application, a MY_Lang library extension
| is included that adds a module name to $this->lang->line().
|
*/

$config['use_language_array'] = false;
