<?php namespace PhpFanatic\Cakemarketing\Response;
/**
 * Base API functionality for Cake Marketing.
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  0.1.1
 */

abstract class AbstractResponse
{
	public $interface;
	
	/**
	 * Instantiate and set the interface.  Accepts either 'xml' or 'json' or default ('xml').
	 * @param string $interface
	 */
	public function __construct($interface='xml') {
		$this->setInterface($interface);
	}
	
	/**
	 * Set the expected interface response.
	 * @param string $interface
	 */
	public function setInterface($interface) {
		$this->interface = strtolower($interface);	
	}
}