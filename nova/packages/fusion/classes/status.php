<?php
/**
 * Character and user statuses are stored as integers now and this class
 * is designed to the store the available statuses as well as translate
 * to and from strings for ease of use.
 */

namespace Fusion;

class Status
{
	const PENDING	= 1;
	const INACTIVE	= 2;
	const ACTIVE	= 3;
	const REMOVED	= 4;

	/**
	 * Translate a status into a string.
	 *
	 * @api
	 * @param	int		the status to translate
	 * @return	int
	 */
	public static function translate_to_string($status)
	{
		switch ($status)
		{
			case self::PENDING:
				$final = lang('pending');
			break;

			case self::INACTIVE:
				$final = lang('inactive');
			break;

			case self::ACTIVE:
				$final = lang('active');
			break;

			default:
				$final = lang('[[error.not_found|status]]');
			break;
		}

		return $final;
	}

	/**
	 * Translate a string into a status.
	 *
	 * @api
	 * @param	string	the text to translate from
	 * @return	int
	 */
	public static function translate_from_string($str)
	{
		switch ($str)
		{
			case 'active':
			case 'current':
			case 'all':
				$final = self::ACTIVE;
			break;

			case 'removed':
			case 'deleted':
			case 'archived':
				$final = self::REMOVED;
			break;

			case 'old':
			case 'inactive':
			case 'previous':
				$final = self::INACTIVE;
			break;

			case 'pending':
			case 'applied':
			case 'waiting':
				$final = self::PENDING;
			break;
		}

		return $final;
	}
}
