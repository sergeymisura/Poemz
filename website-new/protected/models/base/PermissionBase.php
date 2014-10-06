<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use Permission instead.
 * Base class for Permission model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  string  id Database column
 * @property  RolePermission[] role_permissions Relation
 */
abstract class PermissionBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  Permission  An instance of Model class
	 */
	public static function model($className = 'Permission')
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
		return 'permission';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'role_permissions' => array(self::HAS_MANY, 'RolePermission', 'permission_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  PermissionSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new PermissionSerializer($this);
	}
}
