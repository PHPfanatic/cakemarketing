<?php

use PhpFanatic\Cakemarketing\Response\Response;

class ResponseTest extends PHPUnit_Framework_TestCase {

	private $response;
	
	protected function setUp() {
		
	}

	protected function tearDown() {
		
	}
	
	public function testInvalidXml() {
		$xml="non xml string";
		$actual = Response::xml($xml);
		
		$this->assertEquals($actual->success, 'false');
	}
}