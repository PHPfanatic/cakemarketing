<?php namespace PhpFanatic\Cakemarketing;
/**
 * Base API functionality for Cake Marketing.
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  1.0.0
 */


abstract class AbstractBaseApi implements AuthInterface, BuilderInterface
{
	private $apikey;
	private $apiurl;
	
	public $apicall;
	
	/**
	 * 
	 * @param string $key
	 * @param string $url
	 */
	public function __construct($key, $url) {
		$this->SetApiKey($key);
		$this->SetApiUrl($url);
	}
	
	protected function SetApiKey($key) {
		$this->apikey = $key;	
	}
	
	protected function SetApiUrl($url) {
		$this->apiurl = $url;
	}
	
	public function BuildUri($data, $function) {
		if(!isset($this->apikey) || !isset($this->apiurl)){
			throw new Exception('API Key or Url not set');
		}
		
		$api_vars = http_build_query($data);
		$this->apicall = $this->apiurl.$function.'?api_key='.$api_vars.'&'.$api_vars;
	}
	
	public function SendRequest() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->apicall);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}
}