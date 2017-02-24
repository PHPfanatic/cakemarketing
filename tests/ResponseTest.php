<?php

use PhpFanatic\Cakemarketing\Response\Response;

class ResponseTest extends PHPUnit_Framework_TestCase {

	private $response;
	
	protected function setUp() {
		
	}

	protected function tearDown() {
		
	}
	
	/**
	 * Test that invalid response generates valid xml error message.
	 */
	public function testInvalidXml() {
		$xml="non xml string";
		$actual = Response::xml($xml);
		
		$this->assertEquals($actual->success, 'false');
	}
	
	/**
	 * Test that valid response generates valid xml object.
	 */
	public function testValidXml() {
		$xml="<xml><test>works</test></xml>";
		$actual = Response::xml($xml);
	
		$this->assertEquals($actual->test, 'works');
	}
}