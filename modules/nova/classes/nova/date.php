<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Date Class
 *
 * @package		Nova Core
 * @subpackage	Base
 * @author		Anodyne Productions
 * @version		2.0
 */

class Nova_Date extends Kohana_Date
{
	/**
	 * Make the date from a UNIX timestamp with the format provided
	 *
	 * @param	string	the format to use for the date
	 * @param	integer	the UNIX timestamp to convert
	 * @param	string	the timezone to use for converting the timestamp
	 * @return			the formatted date string
	 */
	public static function mdate($format = '', $time = '', $timezone = 'GMT')
	{
		$date = new DateTime('@'.$time, new DateTimeZone($timezone));
		
		return $date->format($format);
	}
	
	/**
	 * Returns the current time
	 *
	 * @param	string	the timezone to use for creating the current timestamp (GMT default)
	 * @return			the UNIX timestamp of the current time
	 */
	public static function now($timezone = 'GMT')
	{
		$now = new DateTime('now', new DateTimeZone($timezone));
		
		return $now->format('U');
	}
	
	/**
	 * Returns an array of timezones (ported from CI 1.7.x)
	 *
	 * Port
	 *
	 * @param	string	timezone
	 * @return			an array of timezones
	 */
	public static function timezones($tz = '')
	{
		/*// create the empty timezones array
		$zones = array();
		
		$list = DateTimeZone::listAbbreviations();
		$idents = DateTimeZone::listIdentifiers();
		
		$data = $offset = $added = array();
		
		foreach ($list as $abbr => $info)
		{
        	foreach ($info as $zone)
        	{
				if ( ! empty($zone['timezone_id']) AND ! in_array($zone['timezone_id'], $added) AND in_array($zone['timezone_id'], $idents))
				{
					$z = new DateTimeZone($zone['timezone_id']);
					$c = new DateTime(null, $z);
					$zone['time'] = $c->format('H:i a');
					$data[] = $zone;
					$offset[] = $z->getOffset($c);
					$added[] = $zone['timezone_id'];
				}
			}
		}
		
		array_multisort($offset, SORT_ASC, $data);
		
		foreach ($data as $key => $row)
		{
			$zones[$row['timezone_id']] = self::formatOffset($row['offset']).' '.$row['timezone_id'];
		}
		
		return $zones;
		
		// create the empty timezones array
		$zones = array();
		
		// define the regions we need to go through
		$regions = array(
			'Africa' => DateTimeZone::AFRICA,
			'America' => DateTimeZone::AMERICA,
			'Antarctica' => DateTimeZone::ANTARCTICA,
			'Asia' => DateTimeZone::ASIA,
			'Atlantic' => DateTimeZone::ATLANTIC,
			'Europe' => DateTimeZone::EUROPE,
			'Indian' => DateTimeZone::INDIAN,
			'Pacific' => DateTimeZone::PACIFIC
		);
		
		foreach ($regions as $name => $mask)
		{
			$zones = array_merge($zones, DateTimeZone::listIdentifiers($mask));
		}
		
		return $zones;

		// Note: Don't change the order of these even though
		// some items appear to be in the wrong order
		
		$zones = array( 
			'UM12'		=> -12,
			'UM11'		=> -11,
			'UM10'		=> -10,
			'UM95'		=> -9.5,
			'UM9'		=> -9,
			'UM8'		=> -8,
			'UM7'		=> -7,
			'UM6'		=> -6,
			'UM5'		=> -5,
			'UM45'		=> -4.5,
			'UM4'		=> -4,
			'UM35'		=> -3.5,
			'UM3'		=> -3,
			'UM2'		=> -2,
			'UM1'		=> -1,
			'UTC'		=> 0,
			'UP1'		=> +1,
			'UP2'		=> +2,
			'UP3'		=> +3,
			'UP35'		=> +3.5,
			'UP4'		=> +4,
			'UP45'		=> +4.5,
			'UP5'		=> +5,
			'UP55'		=> +5.5,
			'UP575'		=> +5.75,
			'UP6'		=> +6,
			'UP65'		=> +6.5,
			'UP7'		=> +7,
			'UP8'		=> +8,
			'UP875'		=> +8.75,
			'UP9'		=> +9,
			'UP95'		=> +9.5,
			'UP10'		=> +10,
			'UP105'		=> +10.5,
			'UP11'		=> +11,
			'UP115'		=> +11.5,
			'UP12'		=> +12,
			'UP1275'	=> +12.75,
			'UP13'		=> +13,
			'UP14'		=> +14
		);
		
		if ($tz == '')
		{
			return $zones;
		}
		
		if ($tz == 'GMT')
		{
			$tz = 'UTC';
		}
			
		return ( ! isset($zones[$tz])) ? 0 : $zones[$tz];*/
		
		// create the empty timezones array
		$zones = array();
		
		$list = DateTimeZone::listAbbreviations();
		$idents = DateTimeZone::listIdentifiers();
		
		foreach ($list as $key => $value)
		{
			if (is_array($value))
			{
				foreach ($value as $k => $v)
				{
					if (!empty($v['timezone_id']))
					{
						$d = new DateTimeZone($v['timezone_id']);
						
						$zones[$v['timezone_id']] = self::formatOffset($d->getOffset(new DateTime('now'))).' '.$v['timezone_id'];
					}
					
					//echo Kohana::debug($v);
					//echo Kohana::debug(self::formatOffset($d->getOffset(new DateTime('now'))));
					//exit();
				}
				
			}
			
			
		}
		
		return $zones;
	}
	
	/**
	 * Builds a dropdown menu with all the timezones (ported from CI 1.7.x)
	 *
	 * @param	string	default timezone
	 * @param	string	a class to associate with the dropdown menu
	 * @param	string	name of the dropdown menu
	 * @return			dropdown menu
	 */
	public static function timezone_menu($default = 'UTC', $class = "", $name = 'timezones')
	{
		$default = ($default == 'GMT') ? 'UTC' : $default;
		
		$menu = '<select name="'.$name.'"';
		
		if ($class != '')
		{
			$menu.= ' class="'.$class.'"';
		}
		
		$menu.= ">\n";
		
		foreach (date::timezones() as $key => $val)
		{
			$selected = ($default == $key) ? " selected='selected'" : '';
			$menu.= "<option value='{$key}'{$selected}>".__($key)."</option>\n";
		}
		
		$menu.= "</select>";
		
		return $menu;
	}
	
	public static function formatOffset($offset) {
		        $hours = $offset / 3600;
		        $remainder = $offset % 3600;
		        $sign = $hours > 0 ? '+' : '-';
		        $hour = (int) abs($hours);
		        $minutes = (int) abs($remainder / 60);
		
		        if ($hour == 0 AND $minutes == 0) {
		            $sign = ' ';
		        }
		        return 'GMT' . $sign . str_pad($hour, 2, '0', STR_PAD_LEFT) 
		                .':'. str_pad($minutes,2, '0');
		
		}
} // End date

// End of file date.php
// Location: modules/nova/classes/nova/date.php