<?php
/**
 * Users Resource Controller
**/
class UsersResourceController extends ApiController
{
	/**
	 * Returns a list of objects
	 *
	 * @return  void
	 */
	public function actionList()
	{
		$this->sendError(501, 'ERR_NOT_IMPLEMENTED', 'The action you are requesting is not implemented');
	}

	/**
	 * Returns a single object
	 *
	 * @param   int  $id  Object ID
	 *
	 * @return  void
	 */
	public function actionGet($id)
	{
		$this->sendError(501, 'ERR_NOT_IMPLEMENTED', 'The action you are requesting is not implemented');
	}

	/**
	 * Creates a new object
	 *
	 * @return  void
	 */
	public function actionCreate()
	{
		$this->sendError(501, 'ERR_NOT_IMPLEMENTED', 'The action you are requesting is not implemented');
	}

	/**
	 * Updates an object
	 *
	 * @param   int  $id  Object ID
	 *
	 * @return  void
	 */
	public function actionUpdate($id)
	{
		$this->sendError(501, 'ERR_NOT_IMPLEMENTED', 'The action you are requesting is not implemented');
	}

	/**
	 * Deletes an object
	 *
	 * @param   int  $id  Object ID
	 *
	 * @return  void
	 */
	public function actionDelete($id)
	{
		$this->sendError(501, 'ERR_NOT_IMPLEMENTED', 'The action you are requesting is not implemented');
	}

	/**
	 * Switches visibility of user's social network profile
	 *
	 * @param   int  $id  User ID
	 *
	 * @return  void
	 */
	public function actionToggleSocialProfile($id)
	{
		/**
		 * @var  User      $user
		 * @var  Identity  $identity
		 */
		$user = User::model()->findByPk($id);

		if ($user == null)
		{
			$this->notFound();
		}

		if ($this->session == null || $user->id != $this->session->user_id)
		{
			$this->authFailed();
		}

		if (!isset($this->payload->is_public))
		{
			$this->sendError(400, 'ERR_INVALID', '"is_public" field is required');
		}

		if (!isset($this->payload->provider))
		{
			$this->sendError(400, 'ERR_INVALID', 'Provider is required');
		}

		$identity = Identity::model()->findByAttributes([
			'user_id' => $user->id,
			'provider' => $this->payload->provider
		]);

		if ($identity == null)
		{
			$this->sendError(400, 'ERR_INVALID', 'Provider is not valid');
		}

		$identity->is_public = $this->payload->is_public;
		$identity->save();

		$this->send();
	}
}
