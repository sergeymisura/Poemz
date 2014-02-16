<?php
/**
 * Base class for User model
 *
 * @package Regent.Common.Models
 *
 */
class User extends UserBase
{
	public function createPasswordHash($password)
	{
		if ($this->password_salt == null)
		{
			$this->password_salt = sha1(rand(10000, 999999) . $this->id . $this->email);
			$this->save();
		}

		$hash = $this->password_salt . 'fjore2rk03dl;s,[-23r';
		for ($i = 0; $i < 534; $i++)
		{
			$hash = sha1($password . $hash);
		}

		return $hash;
	}
}
