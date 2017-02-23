<?php namespace PhpFanatic\Cakemarketing\Response;
/**
 * Response functionality for Cake Marketing.  Handles the optional response/field parsing
 * of Cake Marketing responses.  Currently avoiding PSR-7 handler as this is specific to 
 * Cake Marketings xml responses.
 *
 * @author   Nick White <git@phpfanatic.com>
 * @link     https://github.com/PHPfanatic/cakemarketing
 * @version  0.1.1
 */

class Response
{
	/**
	 * Convert Cake Marketings xml string to an object.
	 * @param string $response
	 * @return \PhpFanatic\Cakemarketing\Response\SimpleXMLElement|SimpleXMLElement
	 */
	public static function xml($response) {
		libxml_use_internal_errors(true);
		$xml = simplexml_load_string($response);
		
		if(!$xml) {
			$errors = libxml_get_errors();
			libxml_clear_errors();
			return self::buildError($errors);
		}else{
			return simplexml_load_string($response);
		}
	}
	
	/**
	 * Convert Cake Marketings xml string to a json string.
	 * Cake Marketing responses are simplexml compliant.
	 * @param string $response
	 * @return string
	 */
	public static function json($response) {
		$xml = self::xml($response);
		return json_encode($xml);
	}
	
	/**
	 * Cake Marketing does not return valid xml when an error occurs.
	 * @param obj $err
	 * @return SimpleXMLElement
	 */
	private static function buildError($err) {
		$errXml = new \SimpleXMLElement('<error_response></error_response>');
		$errXml->addChild('success', 'false');
		$errXml->addChild('row_count', count($err));
		$errXml->addChild('error_message', $err[0]->message);
		
		return simplexml_load_string($errXml->asXML());
	}
}