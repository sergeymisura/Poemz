<?php
/**
 * Serializer class for User model
 *
 * @package Regent.Common.Models.Base
 *
 */
class UserSerializer extends ModelSerializer
{
	/**
	 * Processes the collected attributes before they are serialized.
	 *
	 * @param   array  A reference to an array of attributes
	 *
	 * @return  void
	**/
	protected function process(&$attributes)
	{
		unset($attributes['email']);
		unset($attributes['password_hash']);
		unset($attributes['password_salt']);
		unset($attributes['created']);
		unset($attributes['activation_code']);
		unset($attributes['facebook_user_id']);
		unset($attributes['facebook_token']);

		$attributes['avatar'] = $this->model->getAvatar();
	}
}
