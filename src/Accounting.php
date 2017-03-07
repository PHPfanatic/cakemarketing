<?php namespace PhpFanatic\Cakemarketing;
/**
 * Accounting API functionality for Cake Marketing
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  0.1.1
 */

use PhpFanatic\Cakemarketing\Api\AbstractBaseApi;
use PhpFanatic\Cakemarketing\Response\Response;

class Accounting extends AbstractBaseApi
{
	/*
	 * Fields set to null do not have a default value and therefore must
	 * be provided.  Fields with a value can be passed in if the default value
	 * is not desired.  Cake Marketing API requires all fields to be sent rather
	 * you you have a value for them or not.
	 */
	protected $api_list = [
			'ExportAdvertiserBills'=>[
					'fields'=>[
							'billing_cycle'=>'All',
							'billing_period_start_date'=>null,
							'billing_period_end_date'=>null
					],
					'uri'=>'/1/accounting.asmx/ExportAdvertiserBills'
			],
			'ExportAffiliateBills'=>[
					'fields'=>[
							'billing_cycle'=>'All',
							'billing_period_start_date'=>null,
							'billing_period_end_date'=>null,
							'paid_only'=>TRUE,
							'payment_type_id'=>null
					],
					'uri'=>'/1/accounting.asmx/ExportAffiliateBills'
			],
			'ExportBuyerBills'=>[
					'fields'=>[
							'billing_cycle'=>'All',
							'billing_period_start_date'=>null,
							'billing_period_end_date'=>null
					],
					'uri'=>'/1/accounting.asmx/ExportBuyerBills'
			],
			'MarkAdvertiserBillAsReceived '=>[
					'fields'=>[
							'bill_id'=>null,
							'payment_amount'=>null,
							'payment_type_id'=>0,
							'invoice_number'=>'',
							'verification_code'=>'',
							'date_payment_received'=>null,
							'date_payment_received_modification_type'=>null,
							'notes'=>''
					],
					'uri'=>'/1/accounting.asmx/MarkAdvertiserBillAsReceived '
			],

	];

	/**
	 * Call the api with the function and data you have provided.
	 * @param string $function
	 * @param array $data Key value pair for the fields required by Cake Marketing
	 * @throws \LogicException
	 * @throws \InvalidArgumentException
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