<?php namespace PhpFanatic\Cakemarketing;
/**
 * Addedit API functionality for Cake Marketing
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  1.0.0
 */

use PhpFanatic\Cakemarketing\AbstractBaseApi;

class Addedit extends AbstractBaseApi
{
	/*
	 * Fields set to null do not have a default value and therefore must
	 * be provided.  Fields with a value can be passed in if the default value
	 * is not desired.  Cake Marketing API requires all fields to be sent rather
	 * you you have a value for them or not.
	 */
	public $api_list = [
			'Buyer'=>[
					'fields'=>[
							'buyer_id'=>0,
							'buyer_name'=>null,
							'account_status_id'=>2,
							'account_manager_id'=>1,
							'address_street'=>'',
							'address_street2'=>'',
							'address_city'=>'',
							'address_state'=>'',
							'address_zip_code'=>'',
							'address_country'=>'USA',
							'website'=>'',
							'billing_cycle_id'=>0,
							'credit_type'=>'unlimited',
							'credit_limit'=>-1
					],
					'uri'=>'/1/addedit.asmx/Buyer'
			],
			'Contract'=>[
					'fields'=>[
							'buyer_contract_id'=>0,
							'buyer_id'=>null,
							'vertical_id'=>0,
							'buyer_contract_name'=>null,
							'account_status_id'=>0,
							'account_manager_id'=>1,
							'offer_id'=>null,
							'replace_returns'=>null,
							'replacements_non_returnable'=>null,
							'max_return_age_days'=>-1,
							'buy_upsells'=>null,
							'vintage_leads'=>null,
							'min_lead_age_minutes'=>-1,
							'max_lead_age_minutes'=>-1,
							'posting_wait_seconds'=>-1,
							'default_confirmation_page_link'=>'',
							'max_post_errors'=>-11,
							'send_alert_only'=>'no_change',
							'rank'=>null,
							'email_template_id'=>0,
							'portal_template_id'=>0
					],
					'uri'=>'/1/addedit.asmx/BuyerContract'
			],
			'BuyerContractDeliverySchedule'=>[
					'fields'=>[
							'buyer_contract_id'=>0,
							'delivery_schedule_id'=>0,
							'delivery_schedule_day'=>null,
							'time_open'=>null,
							'time_open_modify'=>'FALSE',
							'time_closed'=>null,
							'time_closed_modify'=>'FALSE',
							'cap'=>null,
							'price'=>null,
							'price_modify'=>'FALSE',
							'schedule_type'=>null,
							'sweeper'=>null,
							'priority'=>null,
							'no_return'=>null
					],
					'uri'=>'/1/addedit.asmx/BuyerContractDeliverySchedule'
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