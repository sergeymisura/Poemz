<?php
/**
 * Base controller for all other controllers
 * 
 * @package  CanDo.Components
 */
abstract class BaseController extends CController
{

	/**
	 * A copy of Yii::app()->request
	 * @var CHttpRequest
	 */
	protected $request;

	/**
	 * ApiController constructor
	 * 
	 * @param   string  $id      Controller ID
	 * @param   string  $module  The module that this controller belongs to
	 */
	public function __construct($id, $module=null)
	{
		parent::__construct($id, $module);
		$this->request = Yii::app()->request;
		$this->verifySession();
	}

	/**
	 * Prepares the data before sending it to the client
	 *
	 * @param   mixed  $data  Data to prepare
	 *
	 * @return  mixed  Prepared data
	 */
	protected function prepare($data)
	{
		if (is_array($data))
		{
			$result = array();
			foreach ($data as $key => $value)
			{
				$result[$key] = $this->prepare($value);
			}
		}
		elseif ($data instanceof Model)
		{
			$result = $this->prepare($data->export());
		}
		else
		{
			$result = $data;
		}
		return $result;
	}

	/**
	 * Verifies if the user has valid session and sets PageController::$session
	 *
	 * @return  void
	 */
	private function verifySession()
	{
	}

	/**
	 * This function is being called when the attempt to authenticate user has failed
	 *
	 * @return  void
	 */
	public function authFailed() { throw new Exception('Auth failed'); }
}
