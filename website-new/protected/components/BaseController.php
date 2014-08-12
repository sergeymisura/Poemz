<?php
/**
 * Base class for all controllers
 *
 * @package  CanDo.Components
 */
class BaseController extends CController
{
	/**
	 * @var  HttpRequestExt Http request
	 */
	protected $request;

	/**
	 * @var  UserSession  Current session
	 */
	public $session = null;

	/**
	 * @param CAction $action
	 *
	 * @return bool
	 */
	protected function beforeAction($action)
	{
		$tz = Yii::app()->params['database_timezone'];
		if ($tz != null)
		{
			Yii::app()->db->createCommand('set time_zone = :tz')->execute(array(':tz' => $tz));
		}

		$this->request = Yii::app()->request;

		$cookie_name = Yii::app()->params['auth_cookie'];
		if (isset($this->request->cookies[$cookie_name]))
		{
			$this->session = UserSession::getSession($this->request->cookies[$cookie_name]->value);
		}

		return parent::beforeAction($action);
	}
}
