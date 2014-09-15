<?php
/**
 * Base class for Visitor model
 *
 * @package Regent.Common.Models
 *
 * @property  string  cookieValue
 */
class Visitor extends VisitorBase
{
	const KEY = '834ty34gyurefnwe,sp02kie9j3fhng34jrf';
	const SALT = '4238ur98fhverfnwdp;qwle-0x23-n2ni92';

	public function getCookieValue()
	{
		return base64_encode(Yii::app()->securityManager->encrypt($this->id . '#' . self::SALT, self::KEY));
	}

	public static function findByCookie($cookie)
	{
		$decrypted = Yii::app()->securityManager->decrypt(base64_decode($cookie), self::KEY);
		$pair = explode('#', $decrypted);
		return self::model()->findByPk($pair[0]);
	}

	/**
	 * Matches unique visitor record to the current user
	 *
	 * @param   HttpRequestExt  $request
	 * @param   UserSession     $session
	 *
	 * @return  Visitor
	 */
	public static function matchVisitor($request, $session)
	{
		$visitor = null;

		if ($request->cookies->contains('poemz'))
		{
			$visitor = self::findByCookie($request->cookies['poemz']->value);
		}

		if ($visitor == null)
		{
			$visitor = new self;
		}

		if ($session)
		{
			if (count($session->user->visitors) > 0)
			{
				$visitor = $session->user->visitors[0];
			}
			else
			{
				if ($visitor->user_id != $session->user_id && $visitor->user_id != null)
				{
					$visitor = new self;
				}
				if ($visitor->user_id == null)
				{
					$visitor->user_id = $session->user_id;
				}
			}
		}

		$visitor->save();

		$request->cookies['poemz'] = new CHttpCookie(
			'poemz',
			$visitor->cookieValue,
			array(
				'path' => Yii::app()->baseUrl != '' ? Yii::app()->baseUrl : '/',
				'expire' => time() + 365 * 24 * 60 * 60
			)
		);

		return $visitor;
	}
}
