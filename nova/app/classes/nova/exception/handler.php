<?php
/**
 * Nova's custom exception handler, mainly to handle 404s and other status codes.
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		3.0
 */

class Nova_Exception_Handler {
	
	/**
	 * Method to handle exceptions thrown by Kohana.
	 * 
	 * @access	public
	 * @param	Exception	$e the exception to handle
	 * @return	bool
	 */
	public static function handle(Exception $e)
	{
		switch (get_class($e))
		{
			case 'Http_Exception_404':
				// set up the response object
				$response = new Response;
				$response->status(404);
				
				// set up the view object
				$view = new View('components/error/404');
				$view->message = $e->getMessage();
				$view->title = 'File Not Found';
				
				echo $response->body($view)->send_headers()->body();
				
				return true;
			break;
			
			default:
				return Kohana_Exception::handler($e);
			break;
		}
	}
}
