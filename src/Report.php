<?php namespace PhpFanatic\Cakemarketing;
/**
 * Report API functionality for Cake Marketing
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  1.0.0
 */

use PhpFanatic\Cakemarketing\AbstractBaseApi;

class Report extends AbstractBaseApi
{
	/*
	 * Fields set to null do not have a default value and therefore must
	 * be provided.  Fields with a value can be passed in if the default value
	 * is not desired.  Cake Marketing API requires all fields to be sent rather
	 * you you have a value for them or not.
	 */
	public $api_list = [
			'AffiliateSummary'=>[
					'fields'=>[
							'start_date'=>null,
							'end_date'=>null,
							'affiliate_manger_id'=>0,
							'affiliate_tag_id'=>0,
							'offer_tag_id'=>0,
							'event_id'=>0,
							'revenue_filter'=>'conversions_and_events'
					],
					'uri'=>'/2/reports.asmx/AffiliateSummary'
			],
			'CampaignSummary'=>[
					'fields'=>[
							'affiliate_id'=>null,
							'start_date'=>null,
							'end_date'=>null,
							'affiliate_manager_id'=>0,
							'affiliate_tag_id'=>0,
							'offer_id'=>null,
							'offer_tag_id'=>0,
							'campaign_id'=>null,
							'event_id'=>0,
							'revenue_filter'=>'conversions_and_events'
					],
					'uri'=>'/2/reports.asmx/CampaignSummary'
			],
			'DailySummaryExport'=>[
					'fields'=>[
							'affiliate_id'=>null,
							'start_date'=>null,
							'end_date'=>null,
							'advertiser_id'=>0,
							'offer_id'=>null,
							'vertical_id'=>0,
							'campaign_id'=>null,
							'creative_id'=>0,
							'account_manager_id'=>0,
							'include_tests'=>'false'
					],
					'uri'=>'/1/reports.asmx/DailySummaryExport'
			],
			'Conversions'=>[
					'fields'=>[
							'start_date'=>null,
							'end_date'=>null,
							'conversion_type'=>'all',
							'event_id'=>0,
							'affiliate_id'=>null,
							'advertiser_id'=>0,
							'offer_id'=>null,
							'affiliate_tag_id'=>0,
							'advertiser_tag_id'=>0,
							'offer_tag_id'=>0,
							'campaign_id'=>null,
							'creative_id'=>null,
							'price_format_id'=>0,
							'disposition_type'=>'all',
							'disposition_id'=>0,
							'affiliate_billing_status'=>'all',
							'advertiser_billing_status'=>'all',
							'test_filter'=>'both',
							'start_at_row'=>0,
							'row_limit'=>1000,
							'sort_field'=>'conversion_date',
							'sort_descending'=>'false'
					],
					'uri'=>'/11/reports.asmx/Conversions'
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

		$this->BuildUri($data, $this->api_list[$function]['uri']);
		$xml = $this->SendRequest();

		return $xml;
	}
}