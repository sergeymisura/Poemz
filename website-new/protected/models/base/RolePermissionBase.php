<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use RolePermission instead.
 * Base class for RolePermission model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer id Database column
 * @property  string  role_id Database column
 * @property  string  permission_id Database column
 * @property  mixed   rules Database column
 * @property  Permission permission Relation
 * @property  Role role Relation
 */
abstract class RolePermissionBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  RolePermission  An instance of Model class
	 */
	public static function model($className = 'RolePermission')
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
		return 'role_permission';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'permission' => array(self::BELONGS_TO, 'Permission', 'permission_id'),
			'role' => array(self::BELONGS_TO, 'Role', 'role_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  RolePermissionSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new RolePermissionSerializer($this);
	}
}
