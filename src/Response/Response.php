<?php namespace PhpFanatic\Cakemarketing\Response;
/**
 * Response functionality for Cake Marketing.  Handles the optional response/field parsing
 * of Cake Marketing responses.
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  0.1.1
 */

use PhpFanatic\Cakemarketing\Response\AbstractResponse;

class Response extends AbstractResponse {

	protected $xml;
	protected $apiResponse;
	
	public function getStatus() {
		
	}
	
	public function getField() {
		
	}
		
	public function xml() {
		if($this->xml) {
			return $this->xml;
		}
	
		$xmlString = (string) $this->apiResponse->getBody();
	
		return simplexml_load_string($xmlString);
	}

	public function getResponse() {
		return $this->apiResponse;
	}
}