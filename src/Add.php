<?php namespace PhpFanatic\Cakemarketing;
/**
 * Add API functionality for Cake Marketing
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  1.0.0
 */

use PhpFanatic\Cakemarketing\AbstractBaseApi;

class Add extends AbstractBaseApi
{
	/*
	 * Fields set to null do not have a default value and therefore must
	 * be provided.  Fields with a value can be passed in if the default value
	 * is not desired.  Cake Marketing API requires all fields to be sent rather
	 * you you have a value for them or not.
	 */
	protected $api_list = [
			'AdvertiserCredit'=>[
					'fields'=>[
							'advertiser_id'=>null,
							'currency_id'=>null,
							'amount'=>null,
							'invoice_number'=>null,
							'verification_code'=>null,
							'notes'=>null
					],
					'uri'=>'/1/add.asmx/AdvertiserCredit'
			],
			'Creative'=>[
					'fields'=>[
							'offer_id'=>null,
							'creative_name'=>null,
							'creative_type_id'=>null,
							'creative_status_id'=>null,
							'offer_link'=>null,
							'notes'=>null
					],
					'uri'=>'/1/add.asmx/Creative'
			],
			'BuyerCredit'=>[
					'fields'=>[
							'buyer_id'=>null,
							'credit_type'=>null,
							'credit_to_add'=>null
					],
					'uri'=>'/1/add.asmx/BuyerCredit'
			],
			'ManualCredit'=>[
					'fields'=>[
							'buyer_id'=>null,
							'buyer_contrct_id'=>null,
							'amount'=>null,
							'invoice_number'=>'',
							'verification_code'=>'',
							'notes'=>''
					],
					'uri'=>'/1/add.asmx/ManualCredit'
			],
	];

	/**
	 * Call the api with the function and data you have provided.
	 * @param string $function UpdateConversion, ConversionDispositions, AcceptedDispositions, MassConversionInsert, RejectedDispositions, UpdateLeadPrice, UpdateSaleRevenue
	 * @param array $data Key value pair for the fields required by Cake Marketing
	 * @throws \Exception
	 * @example object->ApiCall('UpdateLeadPrice', array('vertical_id'=>12, 'lead_id'=>'ABC123', 'amount'=>2.50));
	 * @return string Cake Marketing XML response.
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
		return $this->SendRequest();
	}
}