<?php

use PhpFanatic\Cakemarketing\Track;

class TrackTest extends PHPUnit_Framework_TestCase {

	private $api;
	private $key;
	private $url;
	
	protected function setUp() {
		$this->api = new Track($this->key, $this->url);
	}

	protected function tearDown() {
		unset($this->api);
	}
	
	/**
	 * Test sending invalid method call.
	 */
	public function testApiCallException() {
		$this->expectException(\Exception::class);
		$this->api->ApiCall('invalid_variable');
	}
	
	/**
	 * Test missing required fields.
	 */
	public function testApiCallRequiredField() {
		$this->expectException(\Exception::class);
		$this->api->ApiCall('UpdateLeadPrice', array());
	}
	
	/**
	 * Test that curl is sending and responding.  
	 * Placeholder url returns json string.
	 */
	public function testSendRequest() {
		$this->api->SetApiKey('test123');
		$this->api->SetApiUrl('https://jsonplaceholder.typicode.com/posts');
		$this->api->BuildUri('testFunction');
		$response = $this->api->SendRequest();
		
		$this->assertInternalType('string', $response, "Got a " . gettype($response) . " instead of a string.");
	}
}