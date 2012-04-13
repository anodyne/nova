<?php
/**
 * The NovaForm class handles building some of the more complex select
 * menus found throughout Nova.
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Class
 * @author 		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Fusion;

class NovaForm
{
	/**
	 * Builds a select menu that includes all of the positions from
	 * the database based on the parameters passed to the method.
	 *
	 * <code>
	 * echo NovaForm::position('positions', 8, array('id' => 'positions', 'open'));
	 * </code>
	 *
	 * @api
	 * @uses	Form::select
	 * @param	string	the name of the select menu
	 * @param	array 	an array of selected items
	 * @param	array	any extra attributes to be added to the select menu
	 * @param	string	which positions to pull (all, open, or a department ID)
	 * @param	string	whether to pull displayed positions or not (y,n)
	 * @param	string	the department type to pull
	 * @return	string	a select menu output from Form::select
	 */
	public static function position($name, $selected = array(), $extra = null, $type = 'all', $display = 'y', $dept_type = '')
	{
		// grab the positions
		if ($type == 'open')
		{
			$positions = \Model_Position::get_positions('open');
		}
		elseif (is_numeric($type))
		{
			$positions = \Model_Position::get_positions('all', $type);
		}
		else
		{
			$positions = \Model_Position::get_positions();
		}

		if (count($positions) > 0)
		{
			$options[0] = '';
			
			$valid = false;
			
			foreach ($positions as $p)
			{
				if (($dept_type == 'playing' and $p->dept->type == 'playing') or
						($dept_type == 'nonplaying' and $p->dept->type == 'nonplaying') or
						(bool) $p->dept->display === true)
				{
					if ($type == 'all' or $type == 'open')
					{
						$options[$p->dept->name][$p->id] = $p->name;
					}
					else
					{
						$options[$p->id] = $p->name;
					}
				}
			}

			return \Form::select($name, $selected, $options, (array) $extra);
		}
		
		return false;
	}
	
	/**
	 * Builds a select menu that includes all of the ranks from
	 * the database based on the parameters passed to the method.
	 *
	 * <code>
	 * echo NovaForm::rank('ranks', 3, array('id' => 'ranks'));
	 * </code>
	 *
	 * @api
	 * @uses	Form::select
	 * @param	string	the name of the select menu
	 * @param	array 	an array of selected items
	 * @param	array	any extra attributes to add to the select menu
	 * @return	string	a select menu from Form::select
	 */
	public static function rank($name, $selected = array(), $extra = null)
	{
		// grab the ranks
		$ranks = \Model_Rank::get_ranks();
		
		if (count($ranks) > 0)
		{
			foreach ($ranks as $r)
			{
				$options[$r->id] = $r->name;
			}

			return \Form::select($name, $selected, $options, (array) $extra);
		}
		
		return false;
	}
}
