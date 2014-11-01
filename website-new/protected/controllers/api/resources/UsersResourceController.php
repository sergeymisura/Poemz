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
	 * @param   int     $id        User ID
	 * @param   string  $provider  Social Profile provider
	 *
	 * @return  void
	 */
	public function actionToggleSocialProfile($id, $provider)
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

		$identity = Identity::model()->findByAttributes([
			'user_id' => $user->id,
			'provider' => $provider
		]);

		if ($identity == null)
		{
			$this->sendError(400, 'ERR_INVALID', 'Provider is not valid');
		}

		$identity->is_public = $this->payload->is_public;
		$identity->save();

		$this->send();
	}

	public function actionAttachSocialProfile($id, $provider)
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

		if (!isset($this->payload->uid))
		{
			$this->sendError(400, 'ERR_INVALID', 'Provider-issued user ID is required');
		}

		if (!isset($this->payload->access_token))
		{
			$this->sendError(400, 'ERR_INVALID', 'Provider-issued access token is required');
		}

		$identity = Identity::model()->findByAttributes([
			'user_id' => $user->id,
			'provider' => $provider
		]);

		if ($identity != null)
		{
			$this->sendError(400, 'ERR_INVALID', 'You already have a profile for this provider.');
		}

		$identity = Identity::model()->findByAttributes([
			'uid' => $this->payload->uid,
			'provider' => $provider
		]);

		if ($identity != null)
		{
			$this->sendError(400, 'ERR_INVALID', 'This account is already attached to another Poemz.org profile.');
		}

		$identity = new Identity;
		$identity->user_id = $user->id;
		$identity->provider = $provider;
		$identity->uid = $this->payload->uid;
		$identity->access_token = $this->payload->access_token;

		switch ($provider)
		{
			case Identity::FACEBOOK:
				$response = Yii::app()->http->get(
					'https://graph.facebook.com/me',
					array(
						'access_token' => $this->payload->access_token
					)
				);

				$apiResponse = json_decode($response->data());

				if (!isset($apiResponse->id))
				{
					$this->sendError(500, 'ERR_FB_ERROR', 'Facebook returned invalid response');
				}

				if ($apiResponse->id != $this->payload->uid)
				{
					$this->sendError(400, 'ERR_INVALID', 'Auth token does not match user ID');
				}

				if (isset($apiResponse->link))
				{
					$identity->link = $apiResponse->link;
				}
				break;

			default:
				$this->sendError(400, 'ERR_INVALID', 'Invalid provider');
		}

		$identity->save();
		$this->send();
	}

	public function actionDetachSocialProfile($id, $provider)
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

		$identity = Identity::model()->findByAttributes([
			'user_id' => $user->id,
			'provider' => $provider
		]);

		if ($identity == null)
		{
			$this->send();
		}

		if ($user->password_hash == null)
		{
			$count = Identity::model()->countByAttributes([
				'user_id' => $user->id
			]);
			if ($count == 1)
			{
				$this->sendError(400, 'ERR_INVALID', 'This is your only way to log in to Poemz.org. Create a password before unlinking this profile.');
			}
		}

		$identity->delete();
		$this->send();
	}

	public function actionSetAvatar($id)
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

	public function actionUploadAvatar($id)
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

		if (!isset($_FILES['avatar']))
		{
			$this->sendError(400, 'ERR_INVALID', 'Invalid request');
		}

		$image = new Image;
		$image->content = $this->resizeCrop(file_get_contents($_FILES['avatar']['tmp_name']), 150, 150);
		$image->save();

		$user->avatar_id = $image->id;
		$user->external_avatar_url = null;
		$user->save();

		$this->send(['user' => $user]);
	}

	/**
	 * Resizes / crops the image to fit into the specified size
	 *
	 * @param   string  $content     Image content
	 * @param   int     $new_width   New image width
	 * @param   int     $new_height  New image height
	 *
	 * @return  string  New image content
	 */
	private function resizeCrop($content, $new_width, $new_height)
	{
		$gd = imagecreatefromstring($content);
		$width = imagesx($gd);
		$height = imagesy($gd);

		$resized = imagecreatetruecolor($new_width, $new_height);
		$ratio = max($new_width / $width, $new_height / $height);
		imagecopyresampled(
			$resized,
			$gd,
			0,
			0,
			floor(($width - $new_width / $ratio) / 2),
			floor(($height - $new_height / $ratio) / 2),
			$new_width,
			$new_height,
			floor($new_width / $ratio),
			floor($new_height / $ratio)
		);

		ob_start();
		imagejpeg($resized);
		return ob_get_clean();
	}
}
