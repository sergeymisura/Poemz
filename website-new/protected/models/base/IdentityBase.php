<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use Identity instead.
 * Base class for Identity model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer id Database column
 * @property  integer user_id Database column
 * @property  string  provider Database column
 * @property  string  uid Database column
 * @property  string  access_token Database column
 * @property  string  link Database column
 * @property  boolean is_public Database column
 * @property  User user Relation
 */
abstract class IdentityBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  Identity  An instance of Model class
	 */
	public static function model($className = 'Identity')
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
		return 'identity';
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
	 * @return  IdentitySerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new IdentitySerializer($this);
	}
}
