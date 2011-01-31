<?php defined('SYSPATH') or die('No direct script access.');

class Kodoc_Class extends Kohana_Kodoc_Class {
	
	/**
	 * Gets a list of the class properties as [Kodoc_Method] objects.
	 *
	 * @return  array
	 */
	public function methods()
	{
		$methods = $this->class->getMethods();

		usort($methods, array($this,'_method_sort'));

		foreach ($methods as $key => $method)
		{
			if ($method->isPublic())
			{
				$methods[$key] = new Kodoc_Method($this->class->name, $method->name);
			}
			else
			{
				unset($methods[$key]);
			}
		}

		return $methods;
	}
}
