<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Container for accessing the {@see Nova_extension_container} objects
 * instantiated for each loaded extension. These can be accessed such as:
 *
 *    $this->extension['jquery']
 *
 * Objects attached to an extension can then be accessed such as:
 *
 *    $this->extension['jquery']['generator']
 *
 * Other methods such as {@see Nova_extension_container::view()} can also
 * be called this way, such as:
 *
 *    $this->extension['my_extension']
 *         ->location('my_extension_view',$this->skin,'main',$data)
 *
 * This will return the view
 * application/extensions/my_extension/views/main/pages/my_extension_view.php
 *
 * @package		Nova
 * @category	Library
 * @author		Anodyne Productions
 * @copyright	2018 Anodyne Productions
 */

abstract class Nova_extension implements ArrayAccess {
  
  public $facades = [];

  public function offsetSet($offset, $value)
  {
    if(is_null($offset))
    {
      show_error('Extension append by integer not allowed');
    }
    else
    {
      $this->facades[$offset] = $value;
    }
  }

  public function offsetExists($offset)
  {
    return isset($this->facades[$offset]);
  }

  public function offsetUnset($offset)
  {
    unset($this->facades[$offset]);
  }

  public function offsetGet($offset)
  {
    return isset($this->facades[$offset]) ? $this->facades[$offset] : null;
  }
}
