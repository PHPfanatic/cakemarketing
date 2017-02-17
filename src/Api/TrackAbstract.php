<?php namespace PhpFanatic\Cakemarketing;
/**
 * TrackAbstract API functionality for Cake Marketing
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  1.0.0
 */

use PhpFanatic\Cakemarketing\AbstractBaseApi;

abstract class TrackAbstract extends AbstractBaseApi
{
	/**
	 * Create the track class with your given Api key and url.
	 * @param string $key
	 * @param string $url
	 */
	public function __construct($key, $url) {
		parent::__construct($key, $url);
	}

	/**
	 * Returns a message indicating whether or not the conversion was updated.
	 * @see https://support.getcake.com/support/solutions/articles/5000631028-track-updateconversion-api-version-4 Documentation of UpdateConversion
	 * @param array $data
	 * @throws InternalErrorException
	 * @return string Xml structure returned from Cake Marketing
	 */
	public function UpdateConversion($data) {
		$function = '/4/track.asmx/UpdateConversion';
		
		$fields_required = array(
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
		);
		
		if(!array_diff_key($field_required, $data)) {
			throw new \Exception('Missing required fields.');
		}
		
		$this->BuildUri($data, $function);
		$xml = $this->SendRequest();
		
		return $xml;
	}
	
	/**
	 * Returns the rejected dispositions allowed.
	 * @see https://support.getcake.com/support/solutions/articles/5000546019-track-rejecteddispositions-api-version-1 Documentation of RejectedDispositions
	 * @return string Xml structure returned from Cake Marketing
	 */
	public function RejectedDispositions() {
		$function = '/1/track.asmx/RejectedDispositions';
		$data = array();
		
		$this->BuildUri($data, $function);
		$xml = $this->SendRequest();
		
		return $xml;
	}
}