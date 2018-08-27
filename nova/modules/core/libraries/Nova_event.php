<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Library for event management. An event is triggered by {@see trigger()} and 
 * callbacks can be attached to trigger during these events via {@see listen()}.
 * This library makes it possible to hook into actions such as
 * {@see Nova_location::view()} and the {@see CI_DB_active_record} mutator
 * functions.
 *
 * @package		Nova
 * @category	Library
 * @author		Anodyne Productions
 * @copyright	2015 Anodyne Productions
 */

abstract class Nova_event {

  public $callbacks = [];

  /**
   * Trigger an event that will invoke callbacks registered via {@see listen()}.
   *
   * @param string[] $event name segmemts (eg: ['location','view','data'])
   * @param mixed[] $eventData sent to listener callbacks, which may include
   *                    pass-by-reference keys to allow listener callbacks to 
   *                    mutate
   */
  public function trigger($event, $eventData)
  {
    // Once we iterate over $this->callbacks, this will be an array of all 
    // callbacks with the first callback specified for the least specific event 
    // route first in the stack and the last callback specified for the most
    // specific event last in the stack. It's thus intended to be executed in
    // reverse order.
    $callbackStack = [];
    
    // Start the pointer at the root segment.
    $ref =& $this->callbacks;
    
    while(true)
    {
      // Add each callback in reverse order, so when reversed again given that 
      // $callbackStack is LIFO, the first one in this array (so the first one 
      // added) will be executed first.
      if(!empty($ref['_callbacks']))
      {
        foreach(array_reverse($ref['_callbacks']) as $callback)
        {
          $callbackStack[] = $callback;
        }
      }
      
      $seg = array_shift($event);
      
      // Terminate the loop if there's no events specified under the next $seg
      // key or if there are no more segments left to traverse.
      if(!$seg || !isset($ref['_children'][$seg]))
      {
        break;
      }
      
      // Change the pointer to the next segment.
      $ref =& $ref['_children'][$seg];
    };
    
    // Send the name of the event with the special key _ci_event in case a 
    // listener is defined across a namespace (as opposed to just a terminating 
    // event) yet still wants to isolate is execution to only some subset of
    // events.
    $eventData['_ci_event'] = $event;
    
    // $callbackStack is arranged in LIFO, so array_reverse for iteration
    foreach(array_reverse($callbackStack) as $callback)
    {
      $callback($eventData);
    }
  }
  
  /**
   * Register a callback for the event segments specified as $event. This 
   * callback will be executed whenever {@see trigger()} is called for an
   * event with all the same segments.
   *
   * A listener may be defined for an $event that is only some of the segments
   * specified in $event from trigger(). If multiple listeners have been 
   * attached, they will execute in order of most-specific to least-specific.
   *
   * Given these callbacks:
   *
   *      $this->event->listen(['location', 'view', 'output'], function($event){
   *        $event['output'] .= 'c';
   *      });
   *      $this->event->listen(['location', 'view', 'output'], function($event){
   *        $event['output'] .= 'd';
   *      });
   *  
   *      $this->event->listen(['location', 'view', 'output', 'main', 'index'], 
   *          function($event){
   *        $event['output'] .= 'a';
   *      });
   *  
   *      $this->event->listen(['location', 'view', 'output', 'main', 'index'], 
   *          function($event){
   *        $event['output'] .= 'b';
   *      });
   * 
   * The following string will be added to the output:
   *
   *      abcd
   *
   * @param string[] $event name segmemts (eg: ['location','view','data'])
   * @param callback $callback to be invoked when matching event is triggered
   */
  public function listen($event, $callback)
  {  
    $ref =& $this->callbacks;
    
    while($seg = array_shift($event))
    {
      if(!isset($ref['_children'][$seg]))
      {
        $ref['_children'][$seg] = [
          '_children' => [],
          '_callbacks' => []
        ];
      }
      
      $ref =& $ref['_children'][$seg];
    }
    
    $ref['_callbacks'][] = $callback;
  }

}
