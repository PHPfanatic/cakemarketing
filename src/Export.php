<?php namespace PhpFanatic\Cakemarketing;
/**
 * Export API functionality for Cake Marketing
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  1.0.0
 */

use PhpFanatic\Cakemarketing\AbstractBaseApi;

class Export extends AbstractBaseApi
{
	/**
	 * Create the export class with your given Api key and url.
	 * @param string $key
	 * @param string $url
	 */
	public function __construct($key, $url) {
		parent::__construct($key, $url);
	}

	/**
	 * Returns affiliates potentially filtered by affiliate id, affiliate name, account manager id or tag id.
	 * @see https://support.getcake.com/support/solutions/articles/5000546174-export-affiliates-api-version-5 Documentation of ExportAffiliate
	 * @param array $data
	 * @throws Exception
	 * @return string Xml structure returned from Cake Marketing
	 */
	public function ExportAffiliate($data) {
		$function = '/5/export.asmx/Affiliates';

		$fields_required = array(
				'affiliate_id',
				'account_manager_id',
				'tag_id',
				'start_at_row',
				'row_limit',
				'sort_field',
				'sort_descending',
				'affiliate_name'
		);

		if(!array_diff_key($field_required, $data)) {
			throw new \Exception('Missing required fields.');
		}

		$this->BuildUri($data, $function);
		$xml = $this->SendRequest();

		return $xml;
	}
}