<?php
/**
 * Class that stores all the Nova-specific exceptions.
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Fusion;

/**
 * CSRF security token exception
 */
class NovaCSRFException extends \FuelException {}

/**
 * Invalid image type exception
 */
class NovaInvalidImageTypeException extends \FuelException {}

/**
 * Nova Setup Exception
 */
class NovaSetupException extends \FuelException {}
