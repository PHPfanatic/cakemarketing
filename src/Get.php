<?php namespace PhpFanatic\Cakemarketing;
/**
 * Get API functionality for Cake Marketing
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  1.0.0
 */

use PhpFanatic\Cakemarketing\AbstractBaseApi;

class Get extends AbstractBaseApi
{
	/*
	 * Fields set to null do not have a default value and therefore must
	 * be provided.  Fields with a value can be passed in if the default value
	 * is not desired.  Cake Marketing API requires all fields to be sent rather
	 * you you have a value for them or not.
	 */
	public $api_list = [
			'LeadInfo'=>[
					'fields'=>[
							'lead_id'=>null,
							'vertical_id'=>0
					],
					'uri'=>'/1/get.asmx/LeadInfo'
			]
	];

	/**
	 * Create the track class with your given Api key and url.
	 * @param string $key
	 * @param string $url
	 */
	public function __construct($key, $url) {
		parent::__construct($key, $url);
	}

	public function ApiCall($function, $data=array()) {
		if(!array_key_exists($function, $this->api_list)) {
			throw new \Exception('Requested function does not exist.');
		}

		$missing_fields = array_diff_key($this->api_list[$function]['fields'], $data);

		// Cycle through the missing fields, if default values is not null then set
		// the fields in the data array dynamically.
		if(count($missing_fields) > 0) {
			reset($missing_fields);
				
			for($i = 0; $i < count($missing_fields); $i++) {
				$current = key($missing_fields);
				if($this->api_list[$function]['fields'][$current] === null) {
					throw new \Exception('Missing required field: ' . $current);
				}else{
					$data[$current] = $this->api_list[$function]['fields'][$current];
				}
				next($missing_fields);
			}
		}

		$this->BuildUri($this->api_list[$function]['uri'], $data);
		return $this->SendRequest();
	}
}