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
			$user = User::model()->findByAttributes(['email' => $apiResponse->email]);
			$is_new = $user === null;
			if ($user === null)
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
				$user->save();
			}

            $identity = new Identity();
            $identity->provider = Identity::FACEBOOK;
            $identity->user_id = $user->id;
            $identity->uid = $apiResponse->id;

			if ($is_new)
			{
				$this->sendActivationEmail($user);
			}
		}
        else
        {
            $user = $identity->user;
        }

        $identity->access_token = $this->payload->access_token;
		$identity->avatar_url = 'https://graph.facebook.com/' . $identity->uid . '/picture?type=large';
        if (isset($apiResponse->link))
        {
            $identity->link = $apiResponse->link;
        }
        $identity->save();

		$this->authenticated($user);
	}

	function actionGooglePlus()
	{
		/**
		 * @var  HttpCurlResponse $response
		 * @var  User $user
		 * @var  Identity $identity
		 */

		if (!isset($this->payload->access_token)) {
			$this->sendError(400, 'ERR_INVALID', 'Access token is required');
		}

		$response = Yii::app()->http->get(
			'https://www.googleapis.com/plus/v1/people/me',
			array(
				'access_token' => $this->payload->access_token
			)
		);

		$apiResponse = json_decode($response->data());

		$identity = Identity::model()->with('user')->findByAttributes(
			array(
				'uid' => $apiResponse->id,
				'provider' => Identity::GOOGLE_PLUS
			)
		);

		$avatar_url = null;
		if (isset($apiResponse->image))
		{
			$parts = explode('?', $apiResponse->image->url);
			$avatar_url = $parts[0] . '?sz=150';
		}

		if ($identity == null)
		{
			$user = new User;
			$user->email = $apiResponse->emails[0]->value;
			$user->created = User::getDbDate(null, true);

			$display_name = $apiResponse->displayName;

			$idx = 0;
			while (User::model()->countByAttributes(array('username' => $display_name)) > 0)
			{
				$idx++;
				$display_name = $apiResponse->displayName . ' ' . $idx;
			}

			$user->username = $display_name;
			$user->slug = Model::slugify($display_name);
			$user->external_avatar_url = $avatar_url;
			$user->save();

			$identity = new Identity();
			$identity->provider = Identity::GOOGLE_PLUS;
			$identity->user_id = $user->id;
			$identity->uid = $apiResponse->id;

			$this->sendActivationEmail($user);
		}
		else
		{
			$user = $identity->user;
		}

		$identity->access_token = $this->payload->access_token;
		$identity->link = $apiResponse->url;
		$identity->avatar_url = $avatar_url;
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

		$this->sendActivationEmail($user);

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

	public function actionActivate()
	{
		/**
		 * @var  UserSession  $session
		 */

		if (!isset($this->payload->session_id))
		{
			$this->sendError(400, 'ERR_INVALID', 'Session ID is required');
		}

		if (!isset($this->payload->activation_code))
		{
			$this->sendError(400, 'ERR_INVALID', 'Activation code is required');
		}

		if (!isset($this->payload->username))
		{
			$this->sendError(400, 'ERR_INVALID', 'Username is required');
		}

		$session = UserSession::model()->with('user')->findByPk($this->payload->session_id);

		if ($session == null || $session->user->status == User::STATUS_DISABLED)
		{
			$this->authFailed();
		}

		if ($session->user->status == User::STATUS_ACTIVE)
		{
			$this->sendError(400, 'ERR_ACTIVATED', 'This account is already activated');
		}

		if ($session->user->activation_code !== $this->payload->activation_code)
		{
			$this->sendError(400, 'ERR_INVALID_CODE', 'Invalid activation code');
		}

		$exists = User::model()->count(
			'username = :name and id <> :id',
			[
				':name' => $this->payload->username,
				':id' => $session->user->id
			]
		);
		if ($exists)
		{
			$this->sendError(400, 'ERR_NAME_TAKEN', 'The name is already taken');
		}

		$session->user->activation_code = null;
		$session->user->status = User::STATUS_ACTIVE;
		$session->user->username = $this->payload->username;
		$session->user->save();

		$this->authenticated($session->user);
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
		if ($user->status == User::STATUS_DISABLED)
		{
			$this->authFailed();
		}

		$session = UserSession::createSession($user);

		if ($user->status == User::STATUS_ACTIVE)
		{
			$this->createAuthCookie($session);
		}

		Visitor::matchVisitor($this->request, $session);

		$this->send(array('session' => $session));
	}

	/**
	 * @param   User  $user
	 */
	private function sendActivationEmail($user)
	{
		$user->activation_code = substr(sha1(time() . rand(100000, 999999) . $user->email), 0, 6);
		$user->save();

		$this->layout = '//email-html';
		$html = $this->render('activation-html', ['user' => $user], true);

		$this->layout = '//email-text';
		$text = $this->render('activation-text', ['user' => $user], true);
		Yii::app()->mail->send([
			'toName' => $user->username,
			'toAddress' => $user->email,
			'subject' => 'Welcome to Poemz.org',
			'text' => $text,
			'html' => $html
		]);
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
