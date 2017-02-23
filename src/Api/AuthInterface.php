<?php namespace PhpFanatic\Cakemarketing\Api;
/**
 * Required methods to handle authentication to Cake Marketing
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  0.1.1
 */

interface AuthInterface {

	/**
	 * Set your Cake Marketing API key
	 * @param string $key
	 */
	public function SetApiKey($key);

	/**
	 * Set your url endpoint.
	 * @param string $url
	 */
	public function SetApiUrl($url);
}