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

		/*
		if (isset($this->request->cookies['lv_session_id']))
		{
			$this->session = UserSession::model()->findByPk($this->request->cookies['lv_session_id']->value);
			if ($this->session != null)
			{
				$this->session->renew();
			}
		}

		if ($this->session == null && $this->access_action != null)
		{
			$this->authFailed();
		}


		 */
		return parent::beforeAction($action);
	}
}
