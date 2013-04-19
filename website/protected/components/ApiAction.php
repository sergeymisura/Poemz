<?php
/**
 * Base class for all class-based actions for API
 * 
 * @package  CanDo.Components
 *
 */
class ApiAction extends CAction
{
	/**
	 * Returns the current session
	 * 
	 * @return  UserSession  Current session
	 */
	public function session()
	{
		return $this->controller->session;
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
	protected function sendError($httpStatus, $error, $message)
	{
		$this->controller->sendError($httpStatus, $error, $message);
	}
}
