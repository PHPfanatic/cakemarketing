<?php

use PhpFanatic\Cakemarketing\Track;

class TrackTest extends PHPUnit_Framework_TestCase {

	private $api;
	
	protected function setUp() {
		$this->api = new Track('ABC', '123');	
	}

	protected function tearDown() {

	}
	
	public function testApiCall() {
		
	}
}