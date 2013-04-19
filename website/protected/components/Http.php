<?php

class Http extends CComponent
{
	public $options = array();
	private $_baseOptions = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true
	);

	public function init()
	{
	}

	public function request($url)
	{
		$request = new HttpCurlRequest($url);
		return $request->setOptions(CMap::mergeArray($this->_baseOptions, $this->options));
	}

	public function get($url, $data=array())
	{
		return $this->request($url)->get($data);
	}

	public function post($url, $data=array())
	{
		return $this->request($url)->post($data);
	}
}

class HttpCurlRequest
{
	private $_ch;
	private $_url;
	private $_headers;

	public function __construct($url)
	{
		$this->_url = $url;
		$this->_ch = curl_init();
		$this->_headers = array();
	}

	public function get($data=array())
	{
		$this->_url .= (strpos($this->_url, '?') === false) ? '?' : '&';
		$this->_url .= $this->buildData($data);
		return $this->exec();
	}

	public function post($data)
	{
		$this->setOptions(array(
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $this->buildData($data)
		));
		return $this->exec();
	}

	public function setOptions($options)
	{
		curl_setopt_array($this->_ch, $options);
		return $this;
	}

	public function setOption($option, $value)
	{
		curl_setopt($this->_ch, $option, $value);
		return $this;
	}

	public function header($name, $value)
	{
		$this->_headers[$name] = $value;
		return $this;
	}

	private function buildData($data)
	{
		$pairs = array();
		foreach($data as $key => $value)
		{
			$pairs[] = urlencode($key) . '=' . urlencode($value);
		}
		return implode('&', $pairs);
	}

	private function exec()
	{
		$this->setOption(CURLOPT_URL, $this->_url);
		if (count($this->_headers))
		{
			$headers = array();
			foreach($this->_headers as $name => $value)
			{
				$headers[] = $name . ': ' . $value;
			}
			$this->setOption(CURLOPT_HTTPHEADER, $headers);
		}
		return new HttpCurlResponse($this->_ch);
	}
}

class HttpCurlResponse
{
	private $_result;
	private $_info;

	public function __construct($ch)
	{
		$this->_result = curl_exec($ch);
		$this->_info = curl_getinfo($ch);
		$error = curl_error($ch);
		if ($this->_result === false)
		{
			throw new HttpCurlException($this, $error);
		}
		if ($this->httpCode() < 200 || $this->httpCode() > 299)
		{
			throw new HttpCurlException($this, 'The server returned non-200 response');
		}
	}

	public function contentType() {
		return $this->_info['content_type'];
	}

	public function httpCode() {
		return $this->_info['http_code'];
	}

	public function data() {
		return $this->_result;
	}

	public function url() {
		return $this->_info['url'];
	}
}

class HttpCurlException extends Exception
{
	public $response;

	public function __construct(HttpCurlResponse $response, $error)
	{
		parent::__construct($error);
		$this->response = $response;
	}
}
