<?php
/**
 * Nova's custom exception handler, mainly to handle 404s and other status codes.
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */

class Nova_Exception_Handler {
	
	/**
	 * Handles exceptions
	 * 
	 * @param Exception $e the exception to handle
	 * @return bool
	 */
	public static function handle(Exception $e)
	{
		switch (get_class($e))
		{
			case 'Http_Exception_404':
			case 'ReflectionException':
				// get a new copy of the response
				$response = new Response;
				
				// set the response status
				$response->status(404);
				
				// load the error view
				$view = new View('_common/error/404');
				
				// set the content
				$view->message = $e->getMessage();
				$view->title = 'File Not Found';
				
				// echo out the response body
				echo $response->body($view)->send_headers()->body();
				
				return true;
			break;
			
			default:
				return Kohana_Exception::handler($e);
			break;
		}
	}
}
