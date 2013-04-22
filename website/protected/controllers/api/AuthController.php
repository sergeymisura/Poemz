<?php 

class AuthController extends ApiController
{
	public function actionRegister() {
		$payload = $this->request->getPayload();
		if (User::model()->findByAttributes(array('email' => $payload['email'])))
		{
			$this->sendError(401, 'ERR_EMAIL_EXISTS', 'This email is already registered');
		}
		if (User::model()->findByAttributes(array('username' => $payload['username'])))
		{
			$this->sendError(401, 'ERR_USERNAME_EXISTS', 'This name is already taken');
		}
		$user = new User();
		$user->email = $payload['email'];
		$user->password_hash = User::createPasswordHash($payload['password']);
		$user->created = User::getDbDate();
		$user->active = 1;
		$user->activation_code = User::createPasswordHash(time() . $user->email);
		$user->username = $payload['username'];
		$user->save();

		$_SESSION['user'] = $user->id;
		$this->send(array('user' => $user));
	}

	public function actionLogin() {
		$payload = $this->request->getPayload();
		$user = User::model()->findByAttributes(array('email' => $payload['email']));
		if ($user)
		{
			if ($user->active && $user->password_hash == User::createPasswordHash($payload['password']))
			{
				$_SESSION['user'] = $user->id;
				$this->send(array('user' => $user));
			}
		}
		$this->authFailed();
	}
}