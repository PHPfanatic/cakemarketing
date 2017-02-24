<?php namespace PhpFanatic\Cakemarketing;
/**
 * Track API functionality for Cake Marketing
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  0.1.1
 */

use PhpFanatic\Cakemarketing\Api\AbstractBaseApi;
use PhpFanatic\Cakemarketing\Response\Response;

class Track extends AbstractBaseApi
{
	/*
	 * Fields set to null do not have a default value and therefore must
	 * be provided.  Fields with a value can be passed in if the default value
	 * is not desired.  Cake Marketing API requires all fields to be sent rather
	 * you you have a value for them or not.
	 */
	protected $api_list = [
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
			'MassConversionAdjustment'=>[
					'fields'=>[
							'get_current_totals_only'=>'TRUE',
							'start_date'=>null,
							'end_date'=>null,
							'affiliate_id'=>null,
							'offer_id'=>null,
							'campaign_id'=>null,
							'sub_affiliate'=>null,
							'creative_id'=>null,
							'affiliate_payment_type'=>null,
							'advertiser_payment_type'=>null,
							'total_to_adjust'=>null,
							'payout'=>null,
							'payout_currency_id'=>null,
							'received'=>null,
							'received_currency_id'=>null,
							'return_option'=>null,
							'note'=>'',
							'effective_date_option'=>null,
							'custom_date'=>null
					],
					'uri'=>'/2/track.asmx/MassConversionAdjustment'
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
	 * Call the api with the function and data you have provided.
	 * @param string $function 
	 * @param array $data Key value pair for the fields required by Cake Marketing
	 * @param string $interface Determines the response type to return, xml or json.
	 * @throws \Exception
	 * @example object->ApiCall('UpdateLeadPrice', array('vertical_id'=>12, 'lead_id'=>'ABC123', 'amount'=>2.50));
	 * @return object \PhpFanatic\Cakemarketing\Response\SimpleXMLElement|SimpleXMLElement
	 */
	public function ApiCall($function, $data=array(), $interface='xml') {
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