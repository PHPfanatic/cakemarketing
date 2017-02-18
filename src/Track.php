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
	public $api_list = [
			'UpdateConversion'=>[
					'fields'=>[
							'offer_id',
							'conversion_id',
							'request_session_id',
							'transaction_id',
							'payout',
							'add_to_existing_payout',
							'received',
							'received_option',
							'disposition_type',
							'disposition_id',
							'update_revshare_payout',
							'effective_date_option',
							'custom_date',
							'note_to_append',
							'disallow_on_billing_status'
					],
					'uri'=>'/4/track.asmx/UpdateConversion'
			],
			'UpdateSaleRevenue'=>[
					'fields'=>[
							'buyer_contract_id',
							'lead_id',
							'add_to_existing',
							'amount',
							'notes'
					],
					'uri'=>'/1/track.asmx/UpdateSaleRevenue'
			],
			'UpdateLeadPrice'=>[
					'required_fields'=>[
							'vertical_id',
							'lead_id',
							'add_to_existing',
							'amount',
							'mark_as_returned',
							'custom_date',
							'effective_date_option'
					],
					'uri'=>'/2/track.asmx/UpdateLeadPrice'
			],
			'RejectedDispositions'=>[
					'required_fields'=>[],
					'uri'=>'/1/track.asmx/RejectedDispositions'
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