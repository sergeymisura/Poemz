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
		/**
		 * @var  User      $user
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

		$modified = false;

		if (isset($this->payload->email))
		{
			$exists = User::model()->countByAttributes(
					['email' => $this->payload->email],
					'id <> :user_id',
					[':user_id' => $user->id]
				) > 0;

			if ($exists)
			{
				$this->sendError(400, 'ERR_EXISTS', 'A user with this email address already exists.');
			}

			$user->email = $this->payload->email;
			$modified = true;
		}

		if (isset($this->payload->username))
		{
			$exists = User::model()->countByAttributes(
					['username' => $this->payload->username],
					'id <> :user_id',
					[':user_id' => $user->id]
				) > 0;

			if ($exists)
			{
				$this->sendError(400, 'ERR_EXISTS', 'A user with this stage name already exists.');
			}

			$user->username = $this->payload->username;
			$modified = true;
		}

		if (isset($this->payload->about))
		{
			$user->about = $this->payload->about;
			$modified = true;
		}

		if (isset($this->payload->website))
		{
			$website = strtolower($this->payload->website);
			if (strpos($website, 'http://') !== 0 && strpos($website, 'https://') !== 0)
			{
				$this->payload->website = 'http://' . $this->payload->website;
			}
			$user->website = $this->payload->website;
			$modified = true;
		}

		if ($modified)
		{
			$user->save();
		}

		$this->send(['user' => $user]);
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

	public function actionSetAvatar($id)
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

		if (!isset($this->payload->source))
		{
			$this->sendError(400, 'ERR_INVALID', 'Source is required');
		}

		switch ($this->payload->source)
		{
			case 'Facebook':
				$user->external_avatar_url = $user->getFbAvatar();
				break;
			case 'Gravatar':
				$user->external_avatar_url = $user->getGravatar();
				break;
			default:
				$this->sendError(400, 'ERR_INVALID', 'Source is invalid');
		}

		$user->save();

		$this->send(['user' => $user]);
	}
}
