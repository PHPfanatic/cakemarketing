<?php

use PhpFanatic\Cakemarketing\Response\Response;

class ResponseTest extends PHPUnit_Framework_TestCase {

	private $response;
	
	protected function setUp() {
		$this->response = new Response();
	}

	protected function tearDown() {
		unset($this->response);
	}

	/**
	 * Test that the interface is being set correctly.
	 */
	public function testSetInterface() {
		$this->assertEquals('xml', $this->response->interface);
	}
	
	public function testIsJson() {
		
	}
	
	public function testIsXml() {
		
	}
	
	public function testConvertXmltoJson() {
		
	}
	
	public function testConvertJsontoXml() {
		
	}
}