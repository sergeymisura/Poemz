<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use Role instead.
 * Base class for Role model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  string  id Database column
 * @property  RolePermission[] role_permissions Relation
 * @property  UserRole[] user_roles Relation
 */
abstract class RoleBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  Role  An instance of Model class
	 */
	public static function model($className = 'Role')
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
		return 'role';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'role_permissions' => array(self::HAS_MANY, 'RolePermission', 'role_id'),
			'user_roles' => array(self::HAS_MANY, 'UserRole', 'role_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  RoleSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new RoleSerializer($this);
	}
}
