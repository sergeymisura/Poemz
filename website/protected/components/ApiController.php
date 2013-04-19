<?php
/**
 * Base controller for all API classes
 * 
 * @package  CanDo.Components
 */
class ApiController extends BaseController
{
	/**
	 * Prepares the information and then sends it back to the client.
	 *
	 * @param   mixed  $data  Data to be sent.
	 * 
	 * @return  void
	 */
	public function send($data=array())
	{
		header('Content-Type: application/json');
		if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['callback']))
		{
			echo $_GET['callback'] . '(';
		}
		if (is_array($data) && count($data) === 0)
		{
			echo '{}';
		}
		elseif ($data !== null)
		{
			echo json_encode(
				$this->prepare($data)
			);
		}
		if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['callback']))
		{
			echo ');';
		}
		Yii::app()->end();
	}

	/**
	 * Sends the information about the error
	 * 
	 * @param   int     $httpStatus  HTTP Status Code
	 * @param   string  $error       Short error code
	 * @param   string  $message     Message or array of the messages
	 * 
	 * @return  void
	 */
	public function sendError($httpStatus, $error, $message, $data = array())
	{
		if (!isset($_GET['callback']))
		{
			header('HTTP/1.1 ' . $httpStatus);
		}
		if ($error)
		{
			$data['error'] = $error;
			$data[is_string($message) ? 'message' : 'messages'] = $message;

			if (isset($_GET['callback']))
			{
				$data['http_status'] = $httpStatus;
			}

			$this->send($data);
		}
		Yii::app()->end();
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
}
