<?php namespace PhpFanatic\Cakemarketing\Api;
/**
 * Required methods to handle api requests.
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  0.1.1
 */

interface BuilderInterface {

	/**
	 * Build api call URI.
	 * @param string $function
	 * @param array $data
	 */
	public function BuildUri($function, $data=array());
}