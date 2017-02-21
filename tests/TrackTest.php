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
}