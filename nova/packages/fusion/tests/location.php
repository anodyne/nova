<?php
/**
 * The Location class provides methods for searching through Nova's file structure
 * to find the correct view or image to pull. This is the heart and soul of seamless
 * substitution.
 *
 * @package		Nova
 * @category	Test
 * @author		Anodyne Productions
 */

namespace Fusion;

/**
 * Location class tests
 *
 * @group Nova
 */
class Tests_Location extends \Fuel\Core\TestCase
{
	/**
	 * Test for Location::file()
	 *
	 * @test
	 */
	public function test_file_location()
	{
		$output = Location::file('main', 'titan', 'structure');
		$expected = 'nova::components/structure/main.php';
		$this->assertEquals($expected, $output);
	}
}
