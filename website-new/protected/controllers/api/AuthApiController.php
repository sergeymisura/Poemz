<?php
/**
 * AuthApiController class
 *
 * @package  CanDo.Poemz.Controllers.API
 */
class AuthApiController extends ApiController
{
	/**
	 * Page
	 *
	 * @return  void
	 */
	public function actionFacebook()
	{
		/**
		 * @var  HttpCurlResponse  $response
		 * @var  User              $user
         * @var  Identity          $identity
		 */

		if (!isset($this->payload->user_id))
		{
			$this->sendError(400, 'ERR_INVALID', 'Facebook user ID is required');
		}

		if (!isset($this->payload->access_token))
		{
			$this->sendError(400, 'ERR_INVALID', 'Facebook access token is required');
		}

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

		if ($apiResponse->id != $this->payload->user_id)
		{
			$this->sendError(400, 'ERR_INVALID', 'Auth token does not match user ID');
		}

		$identity = Identity::model()->with('user')->findByAttributes(
			array(
				'uid' => $apiResponse->id,
                'provider' => Identity::FACEBOOK
			)
		);

		if ($identity == null)
		{
			$user = new User;
			$user->email = $apiResponse->email;
			$user->created = User::getDbDate(null, true);

            if (isset($apiResponse->username))
            {
                $display_name = $apiResponse->username;
            }
            else
            {
                $display_name = strtolower($apiResponse->first_name . '_' . substr($apiResponse->last_name, 0, 1));
            }
			$idx = 0;
			while (User::model()->countByAttributes(array('username' => $display_name)) > 0)
			{
				$idx++;
				$display_name = strtolower(
						$apiResponse->first_name . '_' . substr($apiResponse->last_name, 0, 1)
					) . '_' . $idx;
			}

			$user->username = $display_name;
			$user->slug = Model::slugify($display_name);
			$user->active = 1;
            $user->save();

            $identity = new Identity();
            $identity->provider = Identity::FACEBOOK;
            $identity->user_id = $user->id;
            $identity->uid = $apiResponse->id;
		}
        else
        {
            $user = $identity->user;
        }

        $identity->access_token = $this->payload->access_token;
        if (isset($apiResponse->link))
        {
            $identity->link = $apiResponse->link;
        }
        $identity->save();

		$this->authenticated($user);
	}

	function actionDb()
	{
		/**
		 * @var  User  $user
		 */
		if (!isset($this->payload->email))
		{
			$this->sendError(400, 'ERR_INVALID', 'Email is required');
		}

		if (!isset($this->payload->password))
		{
			$this->sendError(400, 'ERR_INVALID', 'Password is required');
		}

		$user = User::model()->findByAttributes(
			array(
				'email' => $this->payload->email
			)
		);

		if ($user == null)
		{
			$this->authFailed();
		}

		if ($user->password_hash != $user->createPasswordHash($this->payload->password))
		{
			$this->authFailed();
		}

		$this->authenticated($user);
	}

	public function actionRegister()
	{
		/**
		 * @var  User  $user
		 */
		if (!isset($this->payload->email))
		{
			$this->sendError(400, 'ERR_INVALID', 'Email is required');
		}

		if (!isset($this->payload->password))
		{
			$this->sendError(400, 'ERR_INVALID', 'Password is required');
		}

		if (!isset($this->payload->username))
		{
			$this->sendError(400, 'ERR_INVALID', 'Username is required');
		}

		if (User::model()->countByAttributes(array('username' => $this->payload->username)) > 0)
		{
			$this->sendError(400, 'ERR_INVALID', 'Sorry, this stage name is already taken.');
		}

		if (User::model()->countByAttributes(array('email' => $this->payload->email)) > 0)
		{
			$this->sendError(400, 'ERR_INVALID', 'The user with this email already exists.');
		}

		$user = new User;
		$user->email = $this->payload->email;
		$user->password_hash = $user->createPasswordHash($this->payload->password);
		$user->username = $this->payload->username;
		$user->slug = Model::slugify($user->username);
		$user->created = User::getDbDate(null, true);
		$user->save();

		$this->authenticated($user);
	}

	public function actionChangePassword()
	{
		if ($this->session == null)
		{
			$this->authFailed();
		}

		if (!isset($this->payload->new_password))
		{
			$this->sendError(400, 'ERR_INVALID', 'New password is required');
		}

		if ($this->session->user->password_hash != null)
		{
			if (!isset($this->payload->old_password))
			{
				$this->sendError(400, 'ERR_INVALID', 'Old password is required');
			}

			if ($this->session->user->createPasswordHash($this->payload->old_password)
				!= $this->session->user->password_hash)
			{
				$this->authFailed();
			}
		}

		$this->session->user->password_hash = $this->session->user->createPasswordHash($this->payload->new_password);
		$this->session->user->save();

		$this->send();
	}

	/**
	 * Creates a session, matches the visitor record etc.
	 *
	 * @param   User  $user
	 *
	 * @return  void
	 */
	private function authenticated($user)
	{
		$session = UserSession::createSession($user);
		$this->createAuthCookie($session);
		Visitor::matchVisitor($this->request, $session);
		$this->send(array('session' => $session));
	}

	private function createAuthCookie($session)
	{
		$options = array();
		if (Yii::app()->baseUrl != '')
		{
			$options['path'] = Yii::app()->baseUrl;
		}
		$cookie_name = Yii::app()->params['auth_cookie'];
		$this->request->cookies[$cookie_name] = new CHttpCookie($cookie_name, $session->id, $options);
	}
}
