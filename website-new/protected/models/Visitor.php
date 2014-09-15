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
}
