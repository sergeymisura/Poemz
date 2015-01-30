<?php
/**
 * Interface for the logger that monitors HTTP cURL requests
 *
 * @package  CanDo.Components.Http
 */
interface IHttpLogger
{
	/**
	 * Sets request URL for the log entry
	 *
	 * @param   string  $url  Request URL
	 *
	 * @return  void
	 */
	public function setUrl($url);

	/**
	 * Sets request method for the log entry
	 *
	 * @param   string  $method  Request method
	 *
	 * @return  void
	 */
	public function setMethod($method);

	/**
	 * Sets request for the log entry
	 *
	 * @param   HttpCurlRequest  $request  Request
	 *
	 * @return  void
	 */
	public function setRequest($request);

	/**
	 * Sets response for the log entry
	 *
	 * @param   HttpCurlResponse  $response  Response
	 *
	 * @return  void
	 */
	public function setResponse(HttpCurlResponse $response);

	/**
	 * Logs error message
	 *
	 * @param   string  $message  Error message
	 *
	 * @return  void
	 */
	public function logError($message);

	/**
	 * Creates a log entry
	 *
	 * @return  void
	 */
	public function logResponse();
}

/**
 * Default implementation of the http logger that does not log anything
 *
 * @package  CanDo.Components.Http
 *
 */
class HttpNilLogger implements IHttpLogger
{
	/**
	 * Sets request URL for the log entry
	 *
	 * @param   string  $url  Request URL
	 *
	 * @return  void
	 */
	public function setUrl($url)
	{
	}

	/**
	 * Sets request method for the log entry
	 *
	 * @param   string  $method  Request method
	 *
	 * @return  void
	 */
	public function setMethod($method)
	{
	}

	/**
	 * Sets request for the log entry
	 *
	 * @param   HttpCurlRequest  $request  Request
	 *
	 * @return  void
	 */
	public function setRequest($request)
	{
	}

	/**
	 * Sets response for the log entry
	 *
	 * @param   HttpCurlResponse  $response  Response
	 *
	 * @return  void
	 */
	public function setResponse(HttpCurlResponse $response)
	{
	}

	/**
	 * Logs error message
	 *
	 * @param   string  $message  Error message
	 *
	 * @return  void
	 */
	public function logError($message)
	{
	}

	/**
	 * Creates a log entry
	 *
	 * @return  void
	 */
	public function logResponse()
	{
	}
}

/**
 * A wrapper for cURL library
 *
 * @package  CanDo.Components.Http
 *
 */
class Http extends CComponent
{
	/**
	 * A list of default CURL options configured via app config
	 *
	 * @var array
	 */
	public $options = array();

	/**
	 * @var  IHttpLogger  Logger
	 */
	private $_logger;

	/**
	 * A list of default CURL options applied to all queries by default
	 *
	 * @var array
	 */
	private $_baseOptions = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true
	);

	/**
	 * Component initialization
	 *
	 * @return  void
	 */
	public function init()
	{
		$this->_logger = new HttpNilLogger;
	}

	/**
	 * Sets the HTTP logger instance
	 *
	 * @param   IHttpLogger  $logger  Logger to attach
	 *
	 * @return  Http  Returns itself for chaining
	 */
	public function logger(IHttpLogger $logger)
	{
		$this->_logger = $logger;
		return $this;
	}

	/**
	 * Create a new HTTP request
	 *
	 * @param   string  $url  URL to send the request to
	 *
	 * @return  HttpCurlRequest  Request object
	 */
	public function request($url)
	{
		$request = new HttpCurlRequest($url);
		return $request->setOptions(CMap::mergeArray($this->_baseOptions, $this->options))->logger($this->_logger);
	}

	/**
	 * Performs a GET request with default options
	 *
	 * @param   string  $url   URL to send request to
	 * @param   array   $data  Data to combine into a query string
	 *
	 * @return  HttpCurlResponse  Response object
	 */
	public function get($url, $data=array())
	{
		return $this->request($url)->get($data);
	}

	/**
	 * Performs a POST request with default options
	 *
	 * @param   string   $url   URL to send request to
	 * @param   mixed    $data  Data to send with the POST request
	 * @param   boolean  $json  True to encode the data with json_encode and send it with application/json header
	 *
	 * @return  HttpCurlResponse  Response object
	 */
	public function post($url, $data=array(), $json=false)
	{
		return $this->request($url)->post($data, $json);
	}
}

/**
 * HTTP Request object
 *
 * @package  CanDo.Components.Http
 *
 */
class HttpCurlRequest
{
	private $_logger;

	/**
	 * Resource created by curl_init
	 *
	 * @var resource
	 */
	private $_ch;

	/**
	 * HTTP request URL
	 *
	 * @var resource
	 */
	private $_url;

	/**
	 * Headers to send with the request
	 *
	 * @var array
	 */
	private $_headers;

	/**
	 * Initializes the request object
	 *
	 * @param   string  $url  URL to send request to
	 */
	public function __construct($url)
	{
		$this->_logger = new HttpNilLogger;
		$this->_url = $url;
		$this->_ch = curl_init();
		$this->_headers = array();
	}

	/**
	 * Sets the HTTP logger instance
	 *
	 * @param   IHttpLogger  $logger  Logger to attach
	 *
	 * @return  Http  Returns itself for chaining
	 */
	public function logger(IHttpLogger $logger)
	{
		$this->_logger = $logger;
		return $this;
	}

	/**
	 * Performs a GET request
	 *
	 * @param   array  $data  Data to combine into a query string
	 *
	 * @return  HttpCurlResponse  Response object
	 */
	public function get($data=array())
	{
		$this->_url .= (strpos($this->_url, '?') === false) ? '?' : '&';
		$this->_url .= $this->buildData($data);
		$this->_logger->setMethod('GET');
		return $this->exec();
	}

	/**
	 * Performs a POST request
	 *
	 * @param   mixed    $data  Data to send with the POST request
	 * @param   boolean  $json  True to encode the data with json_encode and send it with application/json header
	 *
	 * @return  HttpCurlResponse  Response object
	 */
	public function post($data, $json=false)
	{
		if ($json)
		{
			if (!is_string($data))
			{
				$data = json_encode($data);
			}
			$this->header('Content-Type', 'application/json');
		}
		else
		{
			if (!is_string($data))
			{
				$data = $this->buildData($data);
			}
		}
		$this->setOptions(
			array(
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $data
			)
		);
		$this->_logger->setMethod('POST');
		$this->_logger->setRequest($this);
		return $this->exec();
	}

	/**
	 * Magic call to perform custom requests (like $req->delete() for 'DELETE' verb)
	 *
	 * @param   string  $name       Lower-case request method
	 * @param   array   $arguments  Arguments (currently not used)
	 *
	 * @return  HttpCurlResponse  Response object
	 */
	public function __call($name, $arguments)
	{
		$method = strtoupper($name);
		$this->setOption(CURLOPT_CUSTOMREQUEST, $method);
		$this->_logger->setMethod($method);
		return $this->exec();
	}

	/**
	 * Sets several CURL options at once
	 *
	 * @param   array  $options  An associative array of CURLOPT_XXX options and their values
	 *
	 * @return  HttpCurlRequest  Returns the same object to support chain calls
	 */
	public function setOptions($options)
	{
		curl_setopt_array($this->_ch, $options);
		return $this;
	}

	/**
	 * Sets the custom CURL option
	 *
	 * @param   int    $option  Option constant (CURLOPT_XXX)
	 * @param   mixed  $value   Option value
	 *
	 * @return  HttpCurlRequest  Returns the same object to support chain calls
	 */
	public function setOption($option, $value)
	{
		curl_setopt($this->_ch, $option, $value);
		return $this;
	}

	/**
	 * Sets the request header
	 *
	 * @param   string  $name   Header name
	 * @param   string  $value  Header value
	 *
	 * @return  HttpCurlRequest  Returns the same object to support chain calls
	 */
	public function header($name, $value)
	{
		$this->_headers[$name] = $value;
		return $this;
	}

	/**
	 * Sets HTTP Basic Authorization header
	 *
	 * @param   string  $username  User name
	 * @param   string  $password  Optional password
	 *
	 * @return  HttpCurlRequest  Returns the same object to support chain calls
	 */
	public function basicAuth($username, $password = '')
	{
		return $this->header('Authorization', 'Basic ' . base64_encode($username . ':' . $password));
	}

	/**
	 * Creates the data for application/x-www-form-urlencoded POST or GET query string
	 *
	 * @param   array  $data  Key-value pairs of data
	 *
	 * @return  string  A string of url-encoded data separated by &
	 */
	private function buildData($data)
	{
		$pairs = array();
		foreach ($data as $key => $value)
		{
			$pairs[] = urlencode($key) . '=' . urlencode($value);
		}
		return implode('&', $pairs);
	}

	/**
	 * Performs the execution of the request and creates the response object.
	 *
	 * @return  HttpCurlResponse
	 */
	private function exec()
	{
		$this->setOption(CURLOPT_URL, $this->_url);
		if (count($this->_headers))
		{
			$headers = array();
			foreach ($this->_headers as $name => $value)
			{
				$headers[] = $name . ': ' . $value;
			}
			$this->setOption(CURLOPT_HTTPHEADER, $headers);
		}
		$this->_logger->setUrl($this->_url);
		return new HttpCurlResponse($this->_ch, $this->_logger);
	}
}

/**
 * HTTP response
 *
 * @package  CanDo.Components.Http
 *
 */
class HttpCurlResponse
{
	/**
	 * Body of the HTTP response
	 *
	 * @var string
	 */
	private $_result;

	/**
	 * Additional information about the HTTP response
	 *
	 * @var array
	 */
	private $_info;

	/**
	 * Creates the HTTP response
	 *
	 * @param   resource     $ch      Resource handler created by curl_init
	 * @param   IHttpLogger  $logger  Http logger instance
	 *
	 * @throws  HttpCurlException
	 */
	public function __construct($ch, IHttpLogger $logger)
	{
		$logger->setResponse($this);
		$this->_result = curl_exec($ch);
		$this->_info = curl_getinfo($ch);
		$error = curl_error($ch);
		if ($this->_result === false)
		{
			$logger->logError($error);
			throw new HttpCurlException($this, $error);
		}
		$logger->logResponse();
		if ($this->httpCode() < 200 || $this->httpCode() > 299)
		{
			throw new HttpCurlException($this, 'The server returned non-200 response');
		}
	}

	/**
	 * Returns the value of the Content-Type header
	 *
	 * @return  string
	 */
	public function contentType()
	{
		return $this->_info['content_type'];
	}

	/**
	 * Returns the response HTTP code
	 *
	 * @return  int
	 */
	public function httpCode()
	{
		return isset($this->_info['http_code']) ? $this->_info['http_code'] : null;
	}

	/**
	 * Returns the response body
	 *
	 * @return  string
	 */
	public function data()
	{
		return $this->_result;
	}

	/**
	 * Returns the URL that was requested
	 *
	 * @return  string
	 */
	public function url()
	{
		return $this->_info['url'];
	}
}

/**
 * An exception that is being thrown if the request fails
 *
 * @package  CanDo.Components.Http
 *
 */
class HttpCurlException extends Exception
{
	/**
	 * A response that caused the problem
	 *
	 * @var HttpCurlResponse
	 */
	public $response;

	/**
	 * Exception constructor
	 *
	 * @param   HttpCurlResponse  $response  A response that caused the problem
	 * @param   string            $error     Error message
	 */
	public function __construct(HttpCurlResponse $response, $error)
	{
		parent::__construct($error);
		$this->response = $response;
	}
}
