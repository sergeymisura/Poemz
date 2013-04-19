<?php
/**
 * Extends Yii Framework CHttpRequest class
 * 
 * @package  CanDo.Components
 */
class HttpRequest extends CHttpRequest
{
	/**
	 * Returns the HTTP header
	 * 
	 * @param   string  $header  Header to return
	 * 
	 * @return  string  Header value or empty string if it does not exist
	 */
	public function getHeader($header)
	{
		$headerKey = 'HTTP_' . str_replace('-', '_', $header);
		return array_key_exists($headerKey, $_SERVER) ? $_SERVER[$headerKey] : '';
	}

	/**
	 * Returns request's Content-Type header
	 *  
	 * @return  string  Value of Content-Type header
	 */
	public function getContentType()
	{
		$contentType = array_key_exists('CONTENT_TYPE', $_SERVER) ? $_SERVER['CONTENT_TYPE'] : '';
		if (strpos($contentType, ';') !== false)
		{
			$contentType = substr($contentType, 0, strpos($contentType, ';'));
		}
		return $contentType;
	}

	/**
	 * Returns the request type, such as GET, POST, HEAD, PUT, DELETE.
	 * Request type can be manually set in POST requests with a parameter named _method. Useful
	 * for RESTful request from older browsers which do not support PUT or DELETE
	 * natively (available since version 1.1.11).
	 * 
	 * @return string request type, such as GET, POST, HEAD, PUT, DELETE.
	 */
	public function getRequestType()
	{
		if (isset($_REQUEST['_method']))
		{
			return strtoupper($_REQUEST['_method']);
		}

		return strtoupper(isset($_SERVER['REQUEST_METHOD'])?$_SERVER['REQUEST_METHOD']:'GET');
	}

	/**
	 * Returns request's Content-Length header
	 * 
	 * @return  integer  Value of Content-Length header
	 */
	public function getContentLength()
	{
		return array_key_exists('CONTENT_LENGTH', $_SERVER) ? (int) $_SERVER['CONTENT_LENGTH'] : 0;
	}

	/**
	 * Returns request body; automatically decodes it if request content-type is application/json
	 * @return a
	 */
	public function getPayload()
	{
		$payload = file_get_contents('php://input');
		return $this->getContentType() == 'application/json' ? json_decode($payload, true) : true;
	}

	public function getIsSecureConnection()
	{
		return parent::getIsSecureConnection() || (isset($_SERVER['HTTP_CLUSTER_HTTPS']) && $_SERVER['HTTP_CLUSTER_HTTPS'] == 'on');
	}
}
