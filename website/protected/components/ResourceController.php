<?php
/**
 * Resource Controller
 * 
 * @package  Canvassing.Controllers.API
 */
abstract class ResourceController extends ApiController
{
	/**
	 * If this is a POST request we read payload to the protected member
	 * 
	 * @param   string  $action  The requested action
	 * 
	 * @return  void
	 */
	public function beforeAction($action)
	{
		if (parent::beforeAction($action))
		{
			if ($this->request->isPostRequest)
			{
				$this->payload = $this->request->getPayload();
			}
			return true;
		}
		return false;
	}

	/**
	 * Returns resource to the client
	 * 
	 * @param   int  id  ID of the requested resource
	 * 
	 * @return  void
	 */
	public function actionGet($id)
	{
		$className = $this->modelClass();
		$instance = $className::model()->findByPk($id);
		if ($instance)
		{
			$this->doVerifyPermissions($instance, 'get');
			$this->send($instance);
		}
		else
		{
			$this->sendError(404, 'ERR_NOT_FOUND', 'Resource not found');
		}
	}

	/**
	 * Creates a new resource and returns it to the client
	 * 
	 * @return  void
	 */
	public function actionCreate()
	{
		$className = $this->modelClass();
		$instance = new $className;
		$this->doInitResource($instance);
		$this->doVerifyPermissions($instance, 'create');
		$this->update($instance);
		$this->send($instance);
	}

	/**
	 * Updates the resource and returns it to the client
	 * 
	 * @param   int  id  ID of the requested resource
	 * 
	 * @return  void
	 */
	public function actionUpdate($id)
	{
		$className = $this->modelClass();
		$instance = $className::model()->findByPk($id);
		if ($instance)
		{
			$this->doVerifyPermissions($instance, 'update');
			$this->update($instance);
			$this->send($instance);
		}
		else
		{
			$this->sendError(404, 'ERR_NOT_FOUND', 'Resource not found');
		}
	}

	/**
	 * @var array  Request payload
	 */
	protected $payload;

	/**
	 * Returns the name of the resource's model class
	 * 
	 * @return  string  Name of the model class
	 */
	protected abstract function modelClass();

	/**
	 * Initializes a new resource right after it is created
	 * 
	 * @param   Model  $instance  Instance of the resource
	 * 
	 * @return  boolean  False, if the request does not have sufficient data to initialize resource
	 */
	protected function initResource(Model $instance)
	{
		return true;
	}

	/**
	 * Verifies user's eligibility to access/update/create resource
	 * 
	 * @param   Model  $instance  Resource
	 * @param   string $action    Requested action ('get', 'create', 'update)
	 * 
	 * @return  boolean  True if the user has enough permissions
	 */
	protected function verifyPermissions(Model $instance, $action)
	{
		return true;
	}

	/**
	 * Updates the model attributes using the data from the request payload
	 * 
	 * @param   Model  $instance  Resource
	 * 
	 * @return  boolean  True if some of the fields were updated. False if the resource was not changed and does not need to be saved.
	 */
	protected function update(Model $instance)
	{
	}

	/**
	 * Tries to initialize resource, throwns an error if initialization failed
	 * 
	 * @param   Model  $instance  Resource
	 * 
	 * @return  void
	 */
	private function doInitResource($instance)
	{
		if(!$this->initResource($instance))
		{
			$this->sendError(400, 'ERR_INVALID_REQUEST', 'Request is not valid');
		}
	}

	/**
	 * Tries to verify permissions, thrown an error if user is not authorized
	 * 
	 * @param   Model   $instance  Resource
	 * @param   string  $action    Requested action
	 * 
	 * @return  void
	 */
	private function doVerifyPermissions($instance, $action)
	{
		if (!$this->verifyPermissions($instance, $action))
		{
			$this->sendError(403, 'ERR_NO_ACCESS', 'You do not allowed to access this resource');
		}
	}
}
