<?php
/**
 * Base class for UserSession model
 *
 * @package Regent.Common.Models
 *
 */
class UserSession extends UserSessionBase
{
	/**
	 * Session lifetime in minutes
	 */
	const SESSION_LIFETIME = 180;

	public static function createSession(User $user)
	{
		self::cleanup();
		$session_id = sha1(time() . rand(10000, 9999999));

		$session = new UserSession;
		$session->id = $session_id;
		$session->user_id = $user->id;
		$session->expires = Model::getDbDate(time() + self::SESSION_LIFETIME * 60, true);
		$session->save();

		$session->getRelated('user');

		return $session;
	}

	public static function getSession($session_id)
	{
		self::cleanup();
		$session = UserSession::model()->with('user')->findByPk($session_id);

		if ($session != null)
		{
			$session->expires = Model::getDbDate(time() + self::SESSION_LIFETIME * 60, true);
			$session->save();
		}
		return $session;
	}

	public static function cleanup()
	{
		UserSession::model()->deleteAll('expires < :date', array(':date' => Model::getDbDate(time(), true)));
	}
}
