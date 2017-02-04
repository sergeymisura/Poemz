<?php
/**
 * Base class for all API controllers
 *
 * @package  CanDo.Components
 */
class ApiController extends BaseController
{
	/**
	 * @var  object  A body of JSON POST request
	 */
	protected $payload = null;

	protected function beforeAction($action)
	{
		if (parent::beforeAction($action))
		{
			if ($this->request->isPostRequest && $this->request->getContentType() == 'application/json')
			{
				$this->payload = json_decode(file_get_contents('php://input'));
			}
			return true;
		}
		return false;
	}

	/**
	 * Does the actual data sending both for successful and failed responses and then ends processing
	 *
	 * @param   array  $data  Data to send
	 *
	 * @return  void
	 */
	private function doSend($data)
	{
		header('Content-Type: application/json');
		$this->verifyOrigin();
		if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['callback']))
		{
			echo $_GET['callback'] . '(';
		}

		echo CJSON::encode($data);

		if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['callback']))
		{
			echo ');';
		}

		Yii::app()->end();
	}

	/**
	 * Prepares the information and then sends it back to the client.
	 *
	 * @param   mixed  $data  Data to be sent.
	 *
	 * @return  void
	 */
	public function send($data=null)
	{
		$this->doSend(
			array(
				'data' => Yii::app()->serialization->serialize($data),
				'timestamp' => time()
			)
		);
	}

	/**
	 * Sends the information about the error
	 *
	 * @param   int     $httpStatus  HTTP Status Code
	 * @param   string  $error       Short error code
	 * @param   string  $message     Message or array of the messages
	 * @param   array   $data        Extra data to send back to the client
	 *
	 * @return  void
	 */
	public function sendError($httpStatus, $error, $message, $data = null)
	{
		if (!isset($_GET['callback']))
		{
			header('HTTP/1.1 ' . $httpStatus);
		}

		$this->doSend(
			array(
				'error' => $error,
				'http_status' => $httpStatus,
				'message' => $message,
				'data' => Yii::app()->serialization->serialize($data)
			)
		);
	}

	/**
	 * This functions sends back HTTP response 404
	 *
	 * @return  void
	 */
	public function notFound()
	{
		$this->sendError(404, 'ERR_NOT_FOUND', 'The requested resource is not found');
	}

	/**
	 * This function is being called when the attempt to authenticate user has failed
	 *
	 * @see BaseController::authFailed()
	 *
	 * @return  void
	 */
	public function authFailed()
	{
		$this->sendError(403, 'ERR_AUTH_FAILED', "You don't have access to the requested action");
	}

	/**
	 * Verifies is the current user has permissions to perform a certain action and redirects the user if they don't.
	 *
	 * @param   string   $action     Action name
	 * @param   mixed    $object     Type of the object to perform the action or the reference to the object
	 * @param   integer  $object_id  Identifier of the object or null
	 *
	 * @return  void
	 */
	protected function verifyAction($action, $object = 'Site', $object_id = null)
	{
		if ($this->session == null)
		{
			$this->authFailed();
			return;
		}
		if (!$this->session->user->verifyAction($action, $object, $object_id))
		{
			$this->authFailed();
			return;
		}
	}

	protected function verifyOrigin()
	{
		if (!isset($_SERVER['HTTP_ORIGIN'])) return;
		$origin = $_SERVER['HTTP_ORIGIN'];
		if (array_search($origin, \Yii::app()->params) !== false) {
	    	header('Access-Control-Allow-Origin: ' . $origin);
		}
	}
}
