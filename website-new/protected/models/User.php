<?php
/**
 * Base class for User model
 *
 * @package Regent.Common.Models
 *
 * @property  Identity  facebook
 */
class User extends UserBase
{
	public function relations()
	{
		$relations = parent::relations();
		$relations['facebook'] = [
			self::HAS_ONE,
			'Identity',
			'user_id',
			'condition' => 'provider = :provider',
			'params' => [':provider' => Identity::FACEBOOK]
		];
		return $relations;
	}

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

	public function getGravatar()
	{
		return 'http://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '?d=mm&size=150';
	}

	public function getFbAvatar()
	{
		return 'https://graph.facebook.com/' . $this->facebook->uid . '/picture?type=large';
	}

	public function getAvatar()
	{
		if ($this->external_avatar_url != null)
		{
			return $this->external_avatar_url;
		}
		if ($this->avatar_id != null)
		{
			return $this->avatar->url;
		}
		if ($this->facebook != null)
		{
			return $this->getFbAvatar();
		}
		return $this->getGravatar();
	}

	public function afterFind()
	{
		if ($this->slug == null)
		{
			$this->slug = Model::slugify($this->username);
			$this->save();
		}
	}

	public function getWebsiteText()
	{
		return str_replace('http://', '', str_replace('https://', '', $this->website));
	}
}
