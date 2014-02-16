<?php
class HelperCommand extends CConsoleCommand
{
	public function actionPassword($id, $password)
	{
		/**
		 * @var  User  $user
		 */
		$user = User::model()->findByPk($id);
		if ($user == null)
		{
			echo "User not found.\n";
			return;
		}

		$user->password_hash = $user->createPasswordHash($password);
		$user->save();

		echo "Password changed for " . $user->email . ".\n";
	}
}
