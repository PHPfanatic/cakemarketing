<?php namespace PhpFanatic\Cakemarketing;
/**
 * Signup API functionality for Cake Marketing
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  0.1.1
 */

use PhpFanatic\Cakemarketing\Api\AbstractBaseApi;
use PhpFanatic\Cakemarketing\Response\Response;

class Signup extends AbstractBaseApi
{
	/*
	 * Fields set to null do not have a default value and therefore must
	 * be provided.  Fields with a value can be passed in if the default value
	 * is not desired.  Cake Marketing API requires all fields to be sent rather
	 * you you have a value for them or not.
	 */
	protected $api_list = [
			'GetMediaTypes'=>[
					'fields'=>[],
					'uri'=>'/1/signup.asmx/GetMediatypes'
			],
			'GetPriceFormats'=>[
					'fields'=>[],
					'uri'=>'/1/signup.asmx/GetPriceFormats'
			],
			'GetTrafficTypes'=>[
					'fields'=>[],
					'uri'=>'/1/signup.asmx/GetTrafficTypes'
			],
			'GetVerticalCategories'=>[
					'fields'=>[],
					'uri'=>'/1/signup.asmx/GetVerticalCategories'
			],
			'Advertiser'=>[
					'fields'=>[
							'company_name'=>null,
							'address_street'=>'',
							'address_street2'=>'',
							'address_city'=>'',
							'address_state'=>'',
							'address_zip_code'=>'',
							'address_country'=>'',
							'first_name'=>null,
							'last_name'=>null,
							'email_address'=>null,
							'password'=>null,
							'website'=>'',
							'notes'=>'',
							'contact_title'=>'',
							'contact_phone_work'=>'',
							'contact_phone_cell'=>'',
							'contact_phone_fax'=>'',
							'contact_im_name'=>'',
							'contact_im_service'=>-1,
							'ip_address'=>null
					],
					'uri'=>'/1/signup.asmx/Advertiser'
			],
			'Affiliate'=>[
					'fields'=>[
							'affiliate_name'=>null,
							'account_status_id'=>3,
							'affiliate_tier_id'=>0,
							'hide_offers'=>TRUE,
							'website'=>'',
							'tax_class'=>'Other',
							'ssn_tax_id'=>'',
							'vat_tax_required'=>FALSE,
							'swift_iban'=>'',
							'payment_to'=>null,
							'payment_min_threshold'=>0,
							'currency_id'=>0,
							'payment_setting_id'=>0,
							'billing_cycle_id'=>0,
							'payment_type_id'=>0,
							'payment_type_info'=>'',
							'address_street'=>'',
							'address_street2'=>'',
							'address_city'=>'',
							'address_state'=>'',
							'address_zip_code'=>'',
							'address_country'=>'',
							'contact_first_name'=>null,
							'contact_middle_name'=>'',
							'contact_last_name'=>null,
							'contact_email_address'=>null,
							'contact_password'=>null,
							'contact_title'=>'',
							'contact_phone_work'=>'',
							'contact_phone_cell'=>'',
							'contact_phone_fax'=>'',
							'contact_im_name'=>'',
							'contact_im_service'=>-1,
							'contact_timezone'=>'',
							'contact_language_id'=>0,
							'media_type_ids'=>null,
							'price_format_ids'=>null,
							'vertical_category_ids'=>null,
							'country_codes'=>null,
							'tag_ids'=>'',
							'date_added'=>date('m/d/Y H:m:s'),
							'signup_ip_address'=>null,
							'referral_affiliate_id'=>0,
							'referral_notes'=>'',
							'terms_and_conditions_agreed'=>null,
							'notes'=>''
					],
					'uri'=>'/1/signup.asmx/Affiliate'
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