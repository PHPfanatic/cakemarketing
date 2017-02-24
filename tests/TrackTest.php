<?php

use PhpFanatic\Cakemarketing\Track;
use PhpFanatic\Cakemarketing\Report;
use PhpFanatic\Cakemarketing\Get;
use PhpFanatic\Cakemarketing\Export;
use PhpFanatic\Cakemarketing\Addedit;
use PhpFanatic\Cakemarketing\Add;

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
	 * Test sending invalid API call.
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