<?php namespace PhpFanatic\Cakemarketing;
/**
 * Edit API functionality for Cake Marketing
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  0.1.1
 */

use PhpFanatic\Cakemarketing\Api\AbstractBaseApi;
use PhpFanatic\Cakemarketing\Response\Response;

class Edit extends AbstractBaseApi
{
	/*
	 * Fields set to null do not have a default value and therefore must
	 * be provided.  Fields with a value can be passed in if the default value
	 * is not desired.  Cake Marketing API requires all fields to be sent rather
	 * you you have a value for them or not.
	 */
	protected $api_list = [
			'Buyer'=>[
					'fields'=>[
							'buyer_id'=>null,
							'account_status_id'=>null,
							'credit_limit'=>-1
							
					],
					'uri'=>'/1/edit.asmx/Buyer'
			],
				
	];

	/**
	 * Call the api with the function and data you have provided.
	 * @param string $function
	 * @param array $data Key value pair for the fields required by Cake Marketing
	 * @throws \Exception
	 * @example object->ApiCall('UpdateLeadPrice', array('vertical_id'=>12, 'lead_id'=>'ABC123', 'amount'=>2.50));
	 * @return object \PhpFanatic\Cakemarketing\Response\SimpleXMLElement|SimpleXMLElement
	 */
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
		return (Response::xml($this->SendRequest()));
	}
}