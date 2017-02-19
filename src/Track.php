<?php namespace PhpFanatic\Cakemarketing;
/**
 * Track API functionality for Cake Marketing
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  1.0.0
 */

use PhpFanatic\Cakemarketing\AbstractBaseApi;

class Track extends AbstractBaseApi
{
	/*
	 * Fields set to null do not have a default value and therefore must
	 * be provided.  Fields with a value can be passed in if the default value
	 * is not desired.  Cake Marketing API requires all fields to be sent rather
	 * you you have a value for them or not.
	 */
	public $api_list = [
			'UpdateConversion'=>[
					'fields'=>[
							'offer_id'=>null,
							'conversion_id'=>0,
							'request_session_id'=>0,
							'transaction_id'=>null,
							'payout'=>null,
							'add_to_existing_payout'=>'FALSE',
							'received'=>null,
							'received_option'=>'total_revenue',
							'disposition_type'=>null,
							'disposition_id'=>null,
							'update_revshare_payout'=>null,
							'effective_date_option'=>null,
							'custom_date'=>null,
							'note_to_append'=>null,
							'disallow_on_billing_status'=>'ignore'
					],
					'uri'=>'/4/track.asmx/UpdateConversion'
			],
			'UpdateSaleRevenue'=>[
					'fields'=>[
							'buyer_contract_id'=>null,
							'lead_id'=>null,
							'add_to_existing'=>null,
							'amount'=>null,
							'notes'=>''
					],
					'uri'=>'/1/track.asmx/UpdateSaleRevenue'
			],
			'UpdateLeadPrice'=>[
					'fields'=>[
							'vertical_id'=>null,
							'lead_id'=>null,
							'add_to_existing'=>'FALSE',
							'amount'=>null,
							'mark_as_returned'=>'FALSE',
							'custom_date'=>'01/01/2017 00:00:00',
							'effective_date_option'=>'conversion_date'
					],
					'uri'=>'/2/track.asmx/UpdateLeadPrice'
			],
			'RejectedDispositions'=>[
					'required_fields'=>[],
					'uri'=>'/1/track.asmx/RejectedDispositions'
			],
			'MassConversionInsert'=>[
					'fields'=>[
							'affiliate_id'=>null,
							'campaign_id'=>null,
							'sub_affiliate'=>null,
							'creative_id'=>null,
							'total_to_insert'=>null,
							'payout'=>null,
							'received'=>null,
							'note'=>null,
							'transaction_ids'=>null,
							'conversion_date'=>null
					],
					'uri'=>'/2/track.asmx/MassConversionInsert'
			],
			'AcceptedDispositions'=>[
					'fields'=>[],
					'uri'=>'/1/track.asmx/AcceptedDispositions'
			],
			'ConversionDispositions'=>[
					'fields'=>[],
					'uri'=>'/2/track.asmx/ConversionDispositions'
			],
			
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
	 * @param array $data
	 * @throws \Exception
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
		
		$this->BuildUri($data, $this->api_list[$function]['uri']);
		$xml = $this->SendRequest();
		
		return $xml;
	}
}