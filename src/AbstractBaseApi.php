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
	 * Instantiate and set the required variables.
	 * @param string $key
	 * @param string $url
	 */
	public function __construct($key, $url) {
		$this->SetApiKey($key);
		$this->SetApiUrl($url);
	}
	
	/**
	 * Set the required API key.
	 * {@inheritDoc}
	 * @see \PhpFanatic\Cakemarketing\AuthInterface::SetApiKey()
	 */
	public function SetApiKey($key) {
		$this->apikey = $key;	
	}
	
	/**
	 * Set the required URL.
	 * {@inheritDoc}
	 * @see \PhpFanatic\Cakemarketing\AuthInterface::SetApiUrl()
	 */
	public function SetApiUrl($url) {
		$this->apiurl = $url;
	}
	
	/**
	 * Builds the URI structure for the specificed function (api method).
	 * The data variable is an array of data to be passed to the method.
	 * {@inheritDoc}
	 * @see \PhpFanatic\Cakemarketing\BuilderInterface::BuildUri()
	 * @throws Exception
	 */
	public function BuildUri($data, $function) {
		if(!isset($this->apikey) || !isset($this->apiurl)){
			throw new Exception('API Key or Url not set');
		}
		
		$api_vars = http_build_query($data);
		$this->apicall = $this->apiurl.$function.'?api_key='.$api_vars.'&'.$api_vars;
	}
	
	/**
	 * Send the API request to cake via curl.
	 * @todo Evaluate curl usage, may be better as a socket.
	 * @return string
	 */
	public function SendRequest() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->apicall);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}
}