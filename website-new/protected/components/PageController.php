<?php
/**
 * Base class for all HTML page controllers
 *
 * @package  CanDo.Components
 */
abstract class PageController extends BaseController
{
	/**
	 * @var  string  Default layout
	 */
	public $layout = '//main';

	public $contentClass = '';

	public $permissions = [];

	public $openGraph = [];

	/**
	 * @var  array  Data to pass to the javascript
	 */
	public $page_data = array();

	/**
	 * Serializes the data that should be passed to page JavaScript
	 *
	 * @param    string  $name  Data key
	 * @param    mixed   $data  Data
	 *
	 * @returns  void
	 */
	public function setPageData($name, $data)
	{
		$this->page_data[$name] = Yii::app()->serialization->serialize($data);
	}

	/**
	 * @param CAction $action
	 *
	 * @return bool
	 */
	protected function beforeAction($action)
	{
		Yii::app()->clientScript->loadResourcesFile(
			Yii::app()->basePath . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'resources.json',
			Yii::app()->params['mode'] == 'debug'
		);

		if (parent::beforeAction($action))
		{
			$this->setPageData('session', $this->session);
			return true;
		}

		return false;
	}

	protected function beforeRender($view)
	{
		/**
		 * @var  ClientScript  $client
		 */

		if (!parent::beforeRender($view))
		{
			return false;
		}
		$permissions = [];
		foreach ($this->permissions as $permission_id)
		{
			$permissions[$permission_id] = Yii::app()->access->can($permission_id);
		}
		$this->setPageData('permissions', $permissions);

		$client = Yii::app()->clientScript;

		foreach ($this->openGraph as $name => $value)
		{
			$client->registerMetaTag($value, null, null, ['property' => 'og:' . $name]);
		}

		return true;
	}

	/**
	 * This function is being called when the user does not have access to the requested action
	 *
	 * @return  void
	 */
	protected function authFailed()
	{
		$this->redirect($this->createUrl('auth/index'));
	}

	/**
	 * This function is being called when we need to tell the user that the page they is looking for does not exist
	 *
	 * @return  void
	 */
	protected function notFound()
	{
		$this->redirect($this->createUrl('site/not-found'));
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
			$this->redirect($this->createUrl('site/no-access'));
			return;
		}
	}

	/**
	 * A shortcut for Yii::app()->format->text() to use in views
	 *
	 * @param   string  $value  Value to display
	 *
	 * @return  string  HTML-safe string
	 */
	public function text($value)
	{
		return Yii::app()->format->text($value);
	}

	/**
	 * Additional class attached to <body> for pages like luxver-marketing, etc.
	 * Some CSS hooks require this.
	 *
	 * @var string
	 */
	var $body_class = '';
}
