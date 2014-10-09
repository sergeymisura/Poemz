<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use UserRole instead.
 * Base class for UserRole model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer id Database column
 * @property  integer user_id Database column
 * @property  string  role_id Database column
 * @property  Role role Relation
 * @property  User user Relation
 */
abstract class UserRoleBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  UserRole  An instance of Model class
	 */
	public static function model($className = 'UserRole')
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
		return 'user_role';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'role' => array(self::BELONGS_TO, 'Role', 'role_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  UserRoleSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new UserRoleSerializer($this);
	}
}
