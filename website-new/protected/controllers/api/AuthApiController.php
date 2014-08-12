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

		$user = User::model()->findByAttributes(
			array(
				'facebook_user_id' => $apiResponse->id
			)
		);

		if ($user == null)
		{
			$user = new User;
			$user->facebook_user_id = $apiResponse->id;
			$user->email = $apiResponse->email;

			$display_name = strtolower($apiResponse->first_name . '_' . substr($apiResponse->last_name, 0, 1));
			$idx = 0;
			while (User::model()->countByAttributes(array('username' => $display_name)) > 0)
			{
				$idx++;
				$display_name = strtolower(
						$apiResponse->first_name . '_' . substr($apiResponse->last_name, 0, 1)
					) . '_' . $idx;
			}

			$user->username = $display_name;
			$user->active = 1;
		}

		$user->facebook_token = $this->payload->access_token;
		$user->save();

		$session = UserSession::createSession($user);
		$this->createAuthCookie($session);
		$this->send(array('session' => $session));
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

		$session = UserSession::createSession($user);
		$this->createAuthCookie($session);
		$this->send(array('session' => $session));
	}

	private function createAuthCookie($session)
	{
		$cookie_name = Yii::app()->params['auth_cookie'];
		$this->request->cookies[$cookie_name] = new CHttpCookie($cookie_name, $session->id, array('path' => Yii::app()->baseUrl));
	}
}
