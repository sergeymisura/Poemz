<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use UserFacebook instead.
 * Base class for UserFacebook model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer user_id Database column
 * @property  string  fb_user_id Database column
 * @property  string  fb_token Database column
 * @property  string  link Database column
 * @property  boolean public Database column
 * @property  User user Relation
 */
abstract class UserFacebookBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  UserFacebook  An instance of Model class
	 */
	public static function model($className = 'UserFacebook')
	{
		return parent::model($className);
	}

	/**
	 * Returns the name of the table
	 *
	 * @return  string  Name of the database table
	 */
	public function tableName()
	{
		return 'user_facebook';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  UserFacebookSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new UserFacebookSerializer($this);
	}
}
