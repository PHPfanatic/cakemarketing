<?php namespace PhpFanatic\Cakemarketing;
/**
 * Export API functionality for Cake Marketing
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  0.1.1
 */

use PhpFanatic\Cakemarketing\Api\AbstractBaseApi;
use PhpFanatic\Cakemarketing\Response\Response;

class Export extends AbstractBaseApi
{
	/*
	 * Fields set to null do not have a default value and therefore must
	 * be provided.  Fields with a value can be passed in if the default value
	 * is not desired.  Cake Marketing API requires all fields to be sent rather 
	 * you you have a value for them or not.
	 */
	public $api_list = [
			'Affiliate'=>[
					'fields'=>[
							'affiliate_id'=>0,
							'account_manager_id'=>0,
							'tag_id'=>0,
							'start_at_row'=>0,
							'row_limit'=>0,
							'sort_field'=>0,
							'sort_descending'=>'TRUE',
							'affiliate_name'=>''
					],
					'uri'=>'/5/export.asmx/Affiliates'
			],
			'Advertisers'=>[
					'fields'=>[
							'advertiser_id'=>0,
							'advertiser_name'=>'',
							'account_manager_id'=>0,
							'tag_id'=>0,
							'start_at_row'=>0,
							'row_limit'=>0,
							'sort_field'=>0,
							'sort_descending'=>'TRUE',
							'affiliate_name'=>''
					],
					'uri'=>'/6/export.asmx/Advertisers'
			],
			'Offers'=>[
					'fields'=>[
							'offer_id'=>0,
							'offer_name'=>'',
							'advertiser_id'=>0,
							'vertical_id'=>0,
							'offer_type_id'=>0,
							'media_type_id'=>0,
							'offer_status_id'=>0,
							'tag_id'=>0,
							'start_at_row'=>0,
							'row_limit'=>0,
							'sort_field'=>0,
							'sort_descending'=>'TRUE'
					],
					'uri'=>'/5/export.asmx/Offers'
			],
			'Campaigns'=>[
					'fields'=>[
							'campaign_id'=>null,
							'offer_id'=>0,
							'affiliate_id'=>0,
							'account_status_id'=>0,
							'media_type_id'=>0,
							'start_at_row'=>0,
							'row_limit'=>0,
							'sort_field'=>0,
							'sort_descending'=>'TRUE'
					],
					'uri'=>'/7/export.asmx/Campaigns'
			],
			'Buyers'=>[
					'fields'=>[
							'buyer_id'=>0,
							'account_status_id'=> 0
					],
					'uri'=>'/2/export.asmx/Buyers'
			],
			'BuyerContracts'=>[
					'fields'=>[
							'buyer_id'=>0,
							'buyer_contract_id'=> 0,
							'vertical_id'=> 0,
							'buyer_contract_status_id'=> 0
					],
					'uri'=>'/3/export.asmx/BuyerContracts'
			],
			'Creatives'=>[
					'fields'=>[
							'creative_id'=>0,
							'creative_name'=> 0,
							'offer_id'=> null,
							'creative_type_id'=> 0,
							'creative_status_id'=>0,
							'start_at_row'=>1,
							'row_limit'=>0,
							'sort_field'=>0,
							'sort_descending'=>'TRUE'
					],
					'uri'=>'/3/export.asmx/Creatives'
			],
			'LeadTiers'=>[
					'fields'=>[
							'vertical_id'=>0
					],
					'uri'=>'/1/export.asmx/LeadTiers'
			],
			'CampaignLeadTiers'=>[
					'fields'=>[
							'campaign_id'=>0,
							'offer_id'=>0,
							'offer_contract_id'=>0,
							'affiliate_id'=>0,
							'account_status_id'=>0,
							'media_type_id'=>0,
							'start_at_row'=>0,
							'row_limit'=>0,
							'sort_field'=>'campaign_id',
							'sort_descending'=>'TRUE'
					],
					'uri'=>'/1/export.asmx/CampaignLeadTiers'
			],
			'AffiliateReferrals'=>[
					'fields'=>[
							'referrer_affiliate_id'=>null,
							'start_at_row'=>0,
							'row_limit'=>0
					],
					'uri'=>'/1/export.asmx/AffiliateReferrals'
			],
			'Blacklists'=>[
					'fields'=>[
							'affiliate_id'=>0,
							'sub_id'=>'',
							'advertiser_id'=>0,
							'offer_id'=>0
					],
					'uri'=>'/1/export.asmx/Blacklists'
			],
			'Schedules'=>[
					'fields'=>[
							'start_date'=>null,
							'end_date'=>null,
							'buyer_id'=>0,
							'status_id'=>null,
							'vertical_id'=>0,
							'priority_only'=>'FALSE',
							'active_only'=>'TRUE'
					],
					'uri'=>'/2/export.asmx/Schedules'
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

	/**
	 * Call the api with the function and data you have provided.
	 * @param string $function
	 * @param array $data Key value pair for the fields required by Cake Marketing
	 * @throws \InvalidArgumentException
	 * @throws \LogicException
	 * @example object->ApiCall('UpdateLeadPrice', array('vertical_id'=>12, 'lead_id'=>'ABC123', 'amount'=>2.50));
	 * @return object \PhpFanatic\Cakemarketing\Response\SimpleXMLElement|SimpleXMLElement
	 */
	public function ApiCall($function, $data=array()) {
		if(!array_key_exists($function, $this->api_list)) {
			throw new \InvalidArgumentException('Requested function does not exist.');
		}
		
		$missing_fields = array_diff_key($this->api_list[$function]['fields'], $data);
		
		// Cycle through the missing fields, if default values is not null then set 
		// the fields in the data array dynamically.
		if(count($missing_fields) > 0) {
			reset($missing_fields);
			
			for($i = 0; $i < count($missing_fields); $i++) {
				$current = key($missing_fields);
				if($this->api_list[$function]['fields'][$current] === null) {
					throw new \LogicException('Missing required field: ' . $current);
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