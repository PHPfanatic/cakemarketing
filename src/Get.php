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
			],
			'AccountStatuses'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/AccountStatuses'
			],
			'Advertisers'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/Advertisers'
			],
			'AffiliateTags'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/AffiliateTags'
			],
			'AffiliateTiers'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/AffiliateTiers'
			],
			'BillingCycles'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/BillingCycles'
			],
			'BlacklistReasons'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/BlacklistReasons'
			],
			'CapIntervals'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/CapIntervals'
			],
			'CapTypes'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/CapTypes'
			],
			'Countries'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/Countries'
			],
			'Currencies'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/Currencies'
			],
			'Departments'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/Departments'
			],
			'EmailTemplates'=>[
					'fields'=>[
							'email_type'=>'both'
					],
					'uri'=>'/1/get.asmx/EmailTemplates'
			],
			'ExchangeRates'=>[
					'fields'=>[
							'start_date'=>null,
							'end_date'=>null
					],
					'uri'=>'/1/get.asmx/ExchangeRates'
			],
			'FilterTypes'=>[
					'fields'=>[
							'filter_type_id'=>0,
							'filter_type_name'=>'',
							'vertical_id'=>0
					],
					'uri'=>'/1/get.asmx/FilterTypes'
			],
			'GetAPIKey'=>[
					'fields'=>[
							'username'=>null,
							'password'=>null
					],
					'uri'=>'/1/get.asmx/GetAPIKey'
			],
			'InactiveReasons'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/InactiveReasons'
			],
			'Languages'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/Languages'
			],
			'LeadInfo'=>[
					'fields'=>[
							'lead_id'=>null,
							'vertical_id'=>0
					],
					'uri'=>'/1/get.asmx/LeadInfo'
			],
			'LeadTierGroups'=>[
					'fields'=>[
							'lead_tier_group_id'=>0
					],
					'uri'=>'/1/get.asmx/LeadTierGroups'
			],
			'LinkDisplayTypes'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/LinkDisplayTypes'
			],
			'GetMediaTypes'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/GetMediaTypes'
			],
			'OfferStatuses '=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/OfferStatuses'
			],
			'OfferTypes'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/OfferTypes'
			],
			'PaymentSettings'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/PaymentSettings'
			],
			'PaymentTypes'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/PaymentTypes'
			],
			'PriceFormats'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/PriceFormats'
			],
			'ResponseDispositions'=>[
					'fields'=>[],
					'uri'=>'/1/get.asmx/ResponseDispositions'
			],
			'TrackingDomains '=>[
					'fields'=>[
							'domain_type'=>'all'
					],
					'uri'=>'/1/get.asmx/TrackingDomains '
			],
			'Verticals'=>[
					'fields'=>[
							'vertical_category_id'=>0
					],
					'uri'=>'/1/get.asmx/Verticals'
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