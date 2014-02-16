<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use UserSession instead.
 * Base class for UserSession model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  string  id Database column
 * @property  integer user_id Database column
 * @property  mixed   expires Database column
 * @property  User user Relation
 */
abstract class UserSessionBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  UserSession  An instance of Model class
	 */
	public static function model($className = 'UserSession')
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
		return 'user_session';
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
	 * @return  UserSessionSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new UserSessionSerializer($this);
	}
}
