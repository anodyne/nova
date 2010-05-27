<?php defined('SYSPATH') or die('No direct script access.');

class Field_Timestamp extends Jelly_Field_Timestamp
{
	/**
	 * Automatically creates or updates the time and
	 * converts it, if necessary
	 *
	 * @param   Jelly  $model
	 * @param   mixed  $value
	 * @return  mixed
	 */
	public function save($model, $value, $loaded)
	{
		if (( ! $loaded AND $this->auto_now_create) OR ($loaded AND $this->auto_now_update))
		{
			$value = Date::now();
		}

		// Convert if necessary
		if ($this->format)
		{
			// Does it need converting?
			if (FALSE !== strtotime($value))
			{
				$value = strtotime($value);
			}

			if (is_numeric($value))
			{
				$value = date($this->format, $value);
			}
		}

		return $value;
	}
}

// End of file timestamp.php
// Location: modules/nova/classes/field/timestamp.php