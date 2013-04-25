<?php
/**
 * Base controller for all web pages
 *
 * @package  CanDo.Components
 */
class PageController extends BaseController
{
	/**
	 * @var  string  Default layout
	 */
	public $layout = '//main';

	/**
	 * @var  array  The data that should be passed to client JavaScript as JSON objects
	 */
	protected $pageData = array();

	/**
	 * Adds some data to be included into the page as JSON object
	 * 
	 * @param   string  $name  Key in the associative array
	 * @param   mixed   $data  Any kind of data
	 * 
	 * @return  void
	 */
	protected function setPageData($name, $data)
	{
		$this->pageData[$name] = $this->prepare($data);
	}

	/**
	 * Registering common scripts and other static files
	 * 
	 * @param   string  $action  Requested action
	 * 
	 * @return  void
	 * 
	 * @see CController::beforeAction()
	 */
	public function beforeAction($action)
	{
		if (!$this->request->isSecureConnection && Yii::app()->params['mode'] != 'debug')
		{
			$this->redirect(str_replace('http://', 'https://', Yii::app()->createAbsoluteUrl('/')) . '/');
			return;
		}
		Yii::import('application.widgets.*');
		$assets = Yii::app()->baseUrl . '/assets/';
		$clientScript = Yii::app()->getClientScript();

		if (Yii::app()->params['mode'] == 'debug')
		{
			$clientScript->registerLinkTag('stylesheet/less', 'text/css', $assets . 'less/app.less');
			$clientScript->registerCssFile($assets . 'mediaelement/mediaelementplayer.min.css');

			$clientScript->registerScriptFile($assets . 'js/lib/jquery/jquery-1.9.1.js');
			$clientScript->registerScriptFile($assets . 'js/lib/jquery/jquery.tmpl.min.js');
			$clientScript->registerScriptFile($assets . 'js/lib/less/less-1.3.3.min.js');
			$clientScript->registerScriptFile($assets . 'js/lib/bootstrap/bootstrap.min.js');
			$clientScript->registerScriptFile($assets . 'mediaelement/mediaelement-and-player.min.js');
				
			$clientScript->registerScriptFile($assets . 'js/lib/swfobject.js');
			$clientScript->registerScriptFile($assets . 'js/lib/recorder.js');

			$clientScript->registerScriptFile($assets . 'js/app/app.js?v1.2');
			$clientScript->registerScriptFile($assets . 'js/app/services/rendering.js');
			$clientScript->registerScriptFile($assets . 'js/app/services/bind.js');
			$clientScript->registerScriptFile($assets . 'js/app/services/api.js');
			$clientScript->registerScriptFile($assets . 'js/app/services/dereferred.js');
			$clientScript->registerScriptFile($assets . 'js/app/services/validation.js');
			$clientScript->registerScriptFile($assets . 'js/app/controllers/navbar.js');
			$clientScript->registerScriptFile($assets . 'js/app/controllers/poem.js');
		}
		else
		{
			$clientScript->registerScriptFile($assets . 'js/compiled/lib.js?v=1');
			$clientScript->registerScriptFile($assets . 'js/compiled/app.js?v=1');
			$clientScript->registerCssFile($assets . 'css/app.css?v=1');
		}

		if ($this->user)
		{
			$this->setPageData('user', $this->user);
		}
		return true;
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
		$this->redirect(Yii::app()->createUrl($this->session !== null ? '/' : '/auth'));
	}
}
